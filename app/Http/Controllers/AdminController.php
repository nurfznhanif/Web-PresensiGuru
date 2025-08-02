<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalGuru = User::where('role', 'guru')->count();
        $presensiHariIni = Presensi::whereDate('tanggal', today())->count();
        $telatHariIni = Presensi::whereDate('tanggal', today())
            ->where('status_masuk', 'telat')
            ->count();
        $alphaHariIni = Presensi::whereDate('tanggal', today())
            ->where('status_masuk', 'alpha')
            ->count();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_guru' => $totalGuru,
                'presensi_hari_ini' => $presensiHariIni,
                'telat_hari_ini' => $telatHariIni,
                'alpha_hari_ini' => $alphaHariIni,
            ]
        ]);
    }

    public function gurus()
    {
        return Inertia::render('Admin/Gurus');
    }
}
