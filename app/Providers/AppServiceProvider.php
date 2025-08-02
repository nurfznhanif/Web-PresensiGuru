<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set timezone untuk Carbon - CARA YANG BENAR
        Carbon::setLocale('id'); // Bahasa Indonesia
        date_default_timezone_set('Asia/Jakarta'); // PHP timezone

        // Set timezone untuk database
        try {
            \DB::statement("SET time_zone='+07:00'");
        } catch (\Exception $e) {
            // Ignore jika database belum ready
        }
    }
}
