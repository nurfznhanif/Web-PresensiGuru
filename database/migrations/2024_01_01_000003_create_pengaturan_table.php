<?php
// database/migrations/2024_01_01_000003_create_pengaturan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->time('jam_masuk_normal')->default('08:00:00');
            $table->time('jam_masuk_telat')->default('08:30:00');
            $table->time('jam_pulang_normal')->default('16:00:00');
            $table->decimal('latitude_sekolah', 10, 8)->nullable();
            $table->decimal('longitude_sekolah', 11, 8)->nullable();
            $table->integer('radius_absensi')->default(100); // dalam meter
            $table->string('nama_lokasi')->default('Sekolah');
            $table->text('alamat_lokasi')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('pengaturan')->insert([
            'jam_masuk_normal' => '08:00:00',
            'jam_masuk_telat' => '08:30:00',
            'jam_pulang_normal' => '16:00:00',
            'latitude_sekolah' => -6.200000,
            'longitude_sekolah' => 106.816666,
            'radius_absensi' => 100,
            'nama_lokasi' => 'Sekolah',
            'alamat_lokasi' => 'Jl. Pendidikan No. 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('pengaturan');
    }
};
