<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Tambahan penting

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
        // Kode ini memaksa Laravel menggunakan HTTPS saat di server (Railway)
        // Agar CSS dan Gambar tidak dianggap "Mixed Content" (rusak)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
