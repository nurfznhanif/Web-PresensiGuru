<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pengaturan;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Buat admin default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nip' => 'ADM001',
        ]);

        // Buat beberapa guru contoh
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => 'GR001',
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => 'GR002',
        ]);

        User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => 'GR003',
        ]);

        // Buat pengaturan default jika belum ada
        if (!Pengaturan::first()) {
            Pengaturan::create([
                'jam_masuk_normal' => '08:00:00',
                'jam_masuk_telat' => '08:30:00',
                'jam_pulang_normal' => '16:00:00',
                'latitude_sekolah' => -6.200000,
                'longitude_sekolah' => 106.816666,
                'radius_absensi' => 100,
                'nama_lokasi' => 'Sekolah Dasar Negeri 01',
                'alamat_lokasi' => 'Jl. Pendidikan No. 1, Jakarta Pusat',
            ]);
        }
    }
}
