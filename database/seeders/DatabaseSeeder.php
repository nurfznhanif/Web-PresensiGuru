<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nip' => 'ADM001',
        ]);

        // Guru users
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
    }
}
