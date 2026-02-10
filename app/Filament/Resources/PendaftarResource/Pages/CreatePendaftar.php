<?php

namespace App\Filament\Resources\PendaftarResource\Pages;

use App\Filament\Resources\PendaftarResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePendaftar extends CreateRecord
{
    protected static string $resource = PendaftarResource::class;

    public function mount(): void
    {
        abort(404);
    }
}
