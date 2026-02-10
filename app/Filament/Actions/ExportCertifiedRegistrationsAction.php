<?php

namespace App\Filament\Actions;

use App\Exports\CertifiedRegistrationsExport;
use App\Models\Course;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;

class ExportCertifiedRegistrationsAction
{
    public static function make(): Action
    {
        return Action::make('exportCertified')
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
            });
    }
}
