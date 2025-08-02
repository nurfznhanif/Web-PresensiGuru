<?php
// app/Http/Controllers/PresensiController.php (Final Fix)

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil pengaturan dari database
        $pengaturan = Pengaturan::first();

        // Jika belum ada pengaturan, buat default
        if (!$pengaturan) {
            $pengaturan = $this->createDefaultSettings();
        }

        if ($user->role === 'admin') {
            $presensi = Presensi::with('user')
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            $presensi = Presensi::where('user_id', $user->id)
                ->orderBy('tanggal', 'desc')
                ->paginate(20);
        }

        // Gunakan timezone Asia/Jakarta untuk hari ini
        $today = now()->toDateString();
        $presensiHariIni = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        return Inertia::render('Presensi/Index', [
            'presensi' => $presensi,
            'presensiHariIni' => $presensiHariIni,
            'isAdmin' => $user->role === 'admin',
            'pengaturan' => $pengaturan,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:masuk,pulang',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = Auth::user();

        // Gunakan helper now() yang sudah otomatis pakai timezone dari config
        $today = now()->toDateString();
        $now = now();

        \Log::info('Timezone Debug:', [
            'today' => $today,
            'now' => $now->toDateTimeString(),
            'timezone' => $now->timezoneName,
            'php_timezone' => date_default_timezone_get(),
        ]);

        // Ambil pengaturan dinamis dari database
        $pengaturan = Pengaturan::first();
        if (!$pengaturan) {
            $pengaturan = $this->createDefaultSettings();
        }

        // Validasi lokasi
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $pengaturan->latitude_sekolah,
            $pengaturan->longitude_sekolah
        );

        if ($distance > $pengaturan->radius_absensi) {
            return back()->withErrors([
                'location' => "Anda berada di luar radius absensi {$pengaturan->nama_lokasi}. Jarak Anda: " . round($distance) . " meter dari lokasi yang ditentukan (maksimal: {$pengaturan->radius_absensi}m)."
            ]);
        }

        // Cek apakah sudah ada presensi hari ini
        $presensi = Presensi::firstOrCreate(
            [
                'user_id' => $user->id,
                'tanggal' => $today,
            ],
            [
                'status_masuk' => 'alpha',
                'status_pulang' => 'belum_pulang',
            ]
        );

        if ($request->type === 'masuk') {
            if ($presensi->jam_masuk) {
                return back()->withErrors(['message' => 'Anda sudah melakukan presensi masuk hari ini.']);
            }

            // Deteksi status otomatis berdasarkan waktu
            $status = $this->determineAttendanceStatus($now, $pengaturan);

            // Siapkan data update
            $updateData = [
                'jam_masuk' => $now->format('H:i:s'),
                'status_masuk' => $status,
            ];

            // Tambahkan koordinat
            $updateData = array_merge($updateData, $this->addLocationData($request, 'masuk'));

            $presensi->update($updateData);

            $statusText = $this->getStatusText($status);
            $message = "Presensi masuk berhasil dicatat di {$pengaturan->nama_lokasi}. Status: {$statusText}";
            $message .= " (Waktu: {$now->format('H:i:s')}, Tanggal: {$now->format('d/m/Y')})";

            if ($status === 'telat') {
                $message .= " - Batas normal: {$this->formatTime($pengaturan->jam_masuk_normal)}, Batas telat: {$this->formatTime($pengaturan->jam_masuk_telat)}";
            }

            return back()->with('success', $message);
        } else {
            // Presensi pulang
            if (!$presensi->jam_masuk) {
                return back()->withErrors(['message' => 'Anda belum melakukan presensi masuk hari ini.']);
            }

            if ($presensi->jam_pulang) {
                return back()->withErrors(['message' => 'Anda sudah melakukan presensi pulang hari ini.']);
            }

            // Cek apakah sudah waktunya pulang
            $isPulangTooEarly = $this->isPulangTooEarly($now, $pengaturan);

            // Siapkan data update
            $updateData = [
                'jam_pulang' => $now->format('H:i:s'),
                'status_pulang' => 'pulang',
            ];

            // Tambahkan koordinat
            $updateData = array_merge($updateData, $this->addLocationData($request, 'pulang'));

            $presensi->update($updateData);

            $message = "Presensi pulang berhasil dicatat di {$pengaturan->nama_lokasi}";
            $message .= " (Waktu: {$now->format('H:i:s')}, Tanggal: {$now->format('d/m/Y')})";
            if ($isPulangTooEarly) {
                $message .= " - Pulang lebih awal dari jam normal: {$this->formatTime($pengaturan->jam_pulang_normal)}";
            }

            return back()->with('success', $message);
        }
    }

    private function createDefaultSettings()
    {
        return Pengaturan::create([
            'jam_masuk_normal' => '08:00:00',
            'jam_masuk_telat' => '08:30:00',
            'jam_pulang_normal' => '16:00:00',
            'latitude_sekolah' => -6.200000,
            'longitude_sekolah' => 106.816666,
            'radius_absensi' => 100,
            'nama_lokasi' => 'Lokasi Belum Diatur',
            'alamat_lokasi' => 'Silakan hubungi admin untuk mengatur lokasi absensi',
        ]);
    }

    private function determineAttendanceStatus($now, $pengaturan)
    {
        try {
            $jamSekarang = $now->format('H:i');
            $jamNormal = $this->formatTime($pengaturan->jam_masuk_normal);
            $jamTelat = $this->formatTime($pengaturan->jam_masuk_telat);

            // Debug log
            \Log::info('Status Detection:', [
                'jam_sekarang' => $jamSekarang,
                'jam_normal' => $jamNormal,
                'jam_telat' => $jamTelat,
            ]);

            $currentTime = Carbon::createFromFormat('H:i', $jamSekarang);
            $normalTime = Carbon::createFromFormat('H:i', $jamNormal);
            $lateTime = Carbon::createFromFormat('H:i', $jamTelat);

            if ($currentTime->gt($lateTime)) {
                return 'telat';
            } else {
                return 'masuk';
            }
        } catch (\Exception $e) {
            \Log::warning('Error determining attendance status: ' . $e->getMessage());
            return 'masuk'; // Default fallback
        }
    }

    private function isPulangTooEarly($now, $pengaturan)
    {
        try {
            $jamSekarang = $now->format('H:i');
            $jamPulang = $this->formatTime($pengaturan->jam_pulang_normal);

            $currentTime = Carbon::createFromFormat('H:i', $jamSekarang);
            $normalPulangTime = Carbon::createFromFormat('H:i', $jamPulang);

            return $currentTime->lt($normalPulangTime);
        } catch (\Exception $e) {
            \Log::warning('Error checking pulang time: ' . $e->getMessage());
            return false;
        }
    }

    private function addLocationData($request, $type)
    {
        try {
            if ($type === 'masuk') {
                return [
                    'latitude_masuk' => $request->latitude,
                    'longitude_masuk' => $request->longitude,
                ];
            } else {
                return [
                    'latitude_pulang' => $request->latitude,
                    'longitude_pulang' => $request->longitude,
                ];
            }
        } catch (\Exception $e) {
            \Log::info('Location columns not available yet: ' . $e->getMessage());
            return [];
        }
    }

    private function getStatusText($status)
    {
        $statusMap = [
            'masuk' => 'MASUK NORMAL',
            'telat' => 'TELAT',
            'alpha' => 'ALPHA',
            'izin' => 'IZIN',
        ];
        return $statusMap[$status] ?? $status;
    }

    private function formatTime($time)
    {
        if (strlen($time) > 5) {
            return substr($time, 0, 5);
        }
        return $time;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
