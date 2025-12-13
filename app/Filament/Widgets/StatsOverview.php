<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Pendaftar;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Mengatur agar widget ini update otomatis setiap 15 detik (opsional)
    protected static ?string $pollingInterval = '15s';

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            // 1. STATISTIK PENGGUNA
            Stat::make('Total Pengguna', User::count())
                ->description('Akun peserta terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success') // Hijau (Sesuai tema Halal Center)
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]), // Grafik hiasan

            // 2. STATISTIK PELATIHAN
            Stat::make('Total Pelatihan', Course::count())
                ->description('Kelas / Kursus Aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary') // Warna Utama (Emerald/Hijau Tua)
                ->chart([2, 10, 3, 12, 1, 15, 10, 17]), // Grafik hiasan naik

            // 3. STATISTIK PENDAFTAR
            Stat::make('Total Pendaftar', Pendaftar::count())
                ->description('Formulir masuk')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info') // Biru (sebagai variasi yang harmonis)
                ->chart([15, 4, 10, 2, 12, 4, 12]), // Grafik hiasan
        ];
    }
}