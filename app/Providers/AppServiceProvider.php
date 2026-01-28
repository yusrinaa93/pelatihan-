<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request; // <--- WAJIB DITAMBAHKAN

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
        // Cek jika aplikasi berjalan di production (Railway)
        if ($this->app->environment('production')) {

            // 1. Paksa HTTPS (Code lama Anda)
            URL::forceScheme('https');

            // 2. CODE BARU: TRUST PROXY (PENANGANAN ERROR 419 UTAMA)
            // Ini memberitahu Laravel untuk mempercayai request dari Load Balancer Railway
            // Tanpa ini, Laravel menganggap request tidak aman & memblokir Cookies sesi.
            Request::setTrustedProxies(
                ['*'], // Percayai semua proxy (aman untuk Railway)
                Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO |
                Request::HEADER_X_FORWARDED_AWS_ELB
            );
        }
    }
}
