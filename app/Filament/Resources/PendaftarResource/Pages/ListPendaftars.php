<?php

namespace App\Filament\Resources\PendaftarResource\Pages;

use App\Exports\CertifiedRegistrationsExport;
use App\Filament\Resources\PendaftarResource;
use App\Models\Course;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListPendaftars extends ListRecords
{
    protected static string $resource = PendaftarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportCertified')
                ->label('Unduh Excel (Lulus)')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->form([
                    Select::make('pelatihan_id')
                        ->label('Filter Pelatihan (opsional)')
                        ->options(fn () => Course::query()->orderBy('judul')->pluck('judul', 'id')->all())
                        ->searchable()
                        ->preload()
                        ->nullable(),
                ])
                ->action(function (array $data) {
                    $courseId = $data['pelatihan_id'] ?? null;

                    $filename = 'pendaftar-lulus-sertifikasi' . ($courseId ? ('-pelatihan-' . $courseId) : '') . '.xlsx';

                    return Excel::download(new CertifiedRegistrationsExport($courseId), $filename);
                }),
        ];
    }
}
