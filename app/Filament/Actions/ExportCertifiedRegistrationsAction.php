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
                Select::make('course_id')
                    ->label('Filter Pelatihan (opsional)')
                    ->options(fn () => Course::query()->orderBy('title')->pluck('title', 'id')->all())
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ])
            ->action(function (array $data) {
                $courseId = $data['course_id'] ?? null;

                $filename = 'pendaftar-lulus-sertifikasi' . ($courseId ? ('-course-' . $courseId) : '') . '.xlsx';

                return Excel::download(new CertifiedRegistrationsExport($courseId), $filename);
            });
    }
}
