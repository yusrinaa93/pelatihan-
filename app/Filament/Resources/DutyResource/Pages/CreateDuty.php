<?php

namespace App\Filament\Resources\DutyResource\Pages;

use App\Filament\Resources\DutyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDuty extends CreateRecord
{
    protected static string $resource = DutyResource::class;
    // --- TAMBAHKAN FUNGSI INI ---
    protected function getRedirectUrl(): string
    {
        // Mengarahkan kembali ke halaman List (index) setelah create berhasil
        return $this->getResource()::getUrl('index');
    }
}
