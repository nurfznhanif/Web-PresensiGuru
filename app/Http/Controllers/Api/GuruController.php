<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Presensi;

class GuruController extends Controller
{
    public function apiIndex()
    {
        $gurus = User::where('role', 'guru')
            ->with(['presensi' => function ($query) {
                $query->whereDate('tanggal', today());
            }])
            ->get();

        // Transform data untuk frontend
        $gurus = $gurus->map(function ($guru) {
            $guru->presensi_hari_ini = $guru->presensi->first();
            unset($guru->presensi);
            return $guru;
        });

        return response()->json([
            'success' => true,
            'data' => $gurus
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|unique:users,nip',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'guru';

        $guru = User::create($validated);

        return response()->json([
            'success' => true,
            'data' => $guru,
            'message' => 'Guru berhasil ditambahkan'
        ]);
    }

    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip' => 'required|string|unique:users,nip,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $guru->update($validated);

        return response()->json([
            'success' => true,
            'data' => $guru,
            'message' => 'Data guru berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $guru = User::findOrFail($id);

        // Hapus data presensi terkait
        Presensi::where('user_id', $id)->delete();

        $guru->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil dihapus'
        ]);
    }
}
