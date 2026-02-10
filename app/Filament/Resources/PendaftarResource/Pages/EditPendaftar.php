<?php

namespace App\Filament\Resources\PendaftarResource\Pages;

use App\Filament\Resources\PendaftarResource;
use Filament\Resources\Pages\EditRecord;

class EditPendaftar extends EditRecord
{
    protected static string $resource = PendaftarResource::class;

    public function mount(int | string $record): void
    {
        abort(404);
    }
}
