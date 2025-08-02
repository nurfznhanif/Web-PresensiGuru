<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

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

        $presensiHariIni = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        // PASTIKAN render ke halaman yang benar
        return Inertia::render('Presensi/Index', [
            'presensi' => $presensi,
            'presensiHariIni' => $presensiHariIni,
            'isAdmin' => $user->role === 'admin',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:masuk,pulang',
            'status' => 'required_if:type,masuk|in:masuk,telat,alpha,izin',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $today = today();
        $now = now();

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

            $presensi->update([
                'jam_masuk' => $now->format('H:i:s'),
                'status_masuk' => $request->status,
                'keterangan' => $request->keterangan,
            ]);

            return back()->with('success', 'Presensi masuk berhasil dicatat.');
        } else {
            if (!$presensi->jam_masuk) {
                return back()->withErrors(['message' => 'Anda belum melakukan presensi masuk hari ini.']);
            }

            if ($presensi->jam_pulang) {
                return back()->withErrors(['message' => 'Anda sudah melakukan presensi pulang hari ini.']);
            }

            $presensi->update([
                'jam_pulang' => $now->format('H:i:s'),
                'status_pulang' => 'pulang',
            ]);

            return back()->with('success', 'Presensi pulang berhasil dicatat.');
        }
    }
}
