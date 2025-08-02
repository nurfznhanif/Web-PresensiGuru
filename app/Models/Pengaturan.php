<?php
// app/Models/Pengaturan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $fillable = [
        'jam_masuk_normal',
        'jam_masuk_telat',
        'jam_pulang_normal',
        'latitude_sekolah',
        'longitude_sekolah',
        'radius_absensi',
        'nama_lokasi',
        'alamat_lokasi',
    ];

    protected $casts = [
        'jam_masuk_normal' => 'datetime:H:i',
        'jam_masuk_telat' => 'datetime:H:i',
        'jam_pulang_normal' => 'datetime:H:i',
        'latitude_sekolah' => 'decimal:8',
        'longitude_sekolah' => 'decimal:8',
    ];

    public static function getPengaturan()
    {
        return static::first() ?: new static();
    }
}
