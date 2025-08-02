<?php

// database/migrations/2024_01_01_000001_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status_masuk', ['masuk', 'telat', 'alpha', 'izin'])->default('alpha');
            $table->enum('status_pulang', ['pulang', 'belum_pulang'])->default('belum_pulang');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'tanggal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('presensi');
    }
};
