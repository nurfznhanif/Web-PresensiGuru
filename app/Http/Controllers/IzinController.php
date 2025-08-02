<?php
// app/Http/Controllers/IzinController.php (Optional - untuk fitur pengajuan izin)

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Untuk admin: lihat semua pengajuan izin
        // Untuk guru: lihat pengajuan izin sendiri
        $izinQuery = Presensi::where('status_masuk', 'izin');

        if ($user->role !== 'admin') {
            $izinQuery->where('user_id', $user->id);
        } else {
            $izinQuery->with('user');
        }

        $pengajuanIzin = $izinQuery->orderBy('tanggal', 'desc')->paginate(20);

        return Inertia::render('Izin/Index', [
            'pengajuanIzin' => $pengajuanIzin,
            'isAdmin' => $user->role === 'admin',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'keterangan' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $tanggal = Carbon::parse($request->tanggal);

        // Cek apakah sudah ada presensi/izin di tanggal tersebut
        $existingPresensi = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($existingPresensi) {
            return back()->withErrors([
                'tanggal' => 'Anda sudah memiliki catatan presensi di tanggal tersebut.'
            ]);
        }

        // Buat pengajuan izin
        Presensi::create([
            'user_id' => $user->id,
            'tanggal' => $tanggal,
            'status_masuk' => 'izin',
            'status_pulang' => 'izin',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pengajuan izin berhasil disubmit untuk tanggal ' . $tanggal->format('d/m/Y'));
    }
}
