
<?php
// database/migrations/2024_01_01_000004_add_location_to_presensi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->decimal('latitude_masuk', 10, 8)->nullable()->after('keterangan');
            $table->decimal('longitude_masuk', 11, 8)->nullable()->after('latitude_masuk');
            $table->decimal('latitude_pulang', 10, 8)->nullable()->after('longitude_masuk');
            $table->decimal('longitude_pulang', 11, 8)->nullable()->after('latitude_pulang');
        });
    }

    public function down()
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->dropColumn(['latitude_masuk', 'longitude_masuk', 'latitude_pulang', 'longitude_pulang']);
        });
    }
};
