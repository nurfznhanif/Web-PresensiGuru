<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = User::where('role', 'guru')
            ->with(['presensiHariIni'])
            ->get()
            ->map(function ($guru) {
                return [
                    'id' => $guru->id,
                    'name' => $guru->name,
                    'email' => $guru->email,
                    'nip' => $guru->nip,
                    'presensi_hari_ini' => $guru->presensiHariIni ? [
                        'status_masuk' => $guru->presensiHariIni->status_masuk,
                        'jam_masuk' => $guru->presensiHariIni->jam_masuk,
                        'jam_pulang' => $guru->presensiHariIni->jam_pulang,
                        'status_pulang' => $guru->presensiHariIni->status_pulang,
                    ] : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $gurus,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nip' => 'required|string|unique:users,nip',
        ]);

        $guru = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'nip' => $request->nip,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Guru berhasil ditambahkan',
            'data' => [
                'id' => $guru->id,
                'name' => $guru->name,
                'email' => $guru->email,
                'nip' => $guru->nip,
            ],
        ], 201);
    }
}
