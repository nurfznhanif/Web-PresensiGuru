<?php
// app/Http/Controllers/PengaturanController.php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::getPengaturan();

        return Inertia::render('Admin/Pengaturan', [
            'pengaturan' => $pengaturan
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_masuk_normal' => 'required|date_format:H:i',
            'jam_masuk_telat' => 'required|date_format:H:i',
            'jam_pulang_normal' => 'required|date_format:H:i',
            'latitude_sekolah' => 'required|numeric|between:-90,90',
            'longitude_sekolah' => 'required|numeric|between:-180,180',
            'radius_absensi' => 'required|integer|min:10|max:1000',
            'nama_lokasi' => 'required|string|max:255',
            'alamat_lokasi' => 'nullable|string|max:500',
        ]);

        $pengaturan = Pengaturan::first();

        if (!$pengaturan) {
            $pengaturan = Pengaturan::create($request->all());
        } else {
            $pengaturan->update($request->all());
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan');
    }
}
