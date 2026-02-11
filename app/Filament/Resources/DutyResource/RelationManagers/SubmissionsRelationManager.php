<?php

namespace App\Filament\Resources\DutyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_file_asli')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_file_asli') // Pastikan ini nama_file_asli
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pengunggah')
                    ->searchable(),

                // PERBAIKAN: Gunakan 'nama_file_asli' sesuai database
                Tables\Columns\TextColumn::make('nama_file_asli')
                    ->label('Nama File')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->nama_file_asli),

                Tables\Columns\TextColumn::make('nilai')
                    ->label('Nilai')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state >= 70 ? 'success' : ($state === null ? 'gray' : 'danger'))
                    ->formatStateUsing(fn($state) => $state === null ? 'Belum Dinilai' : $state),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                // ACTION DOWNLOAD LANGSUNG (Tanpa Controller)
                Tables\Actions\Action::make('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->label('Download')
                    ->action(function ($record) {
                        // Cek apakah file ada
                        if (!$record->path_file || !Storage::disk('public')->exists($record->path_file)) {
                            \Filament\Notifications\Notification::make()
                                ->title('File tidak ditemukan')
                                ->danger()
                                ->send();
                            return;
                        }

                        // Download langsung
                        return Storage::disk('public')->download($record->path_file, $record->nama_file_asli);
                    }),

                Tables\Actions\Action::make('Grade')
                    ->icon('heroicon-o-pencil')
                    ->label('Nilai')
                    ->form([
                        Forms\Components\TextInput::make('nilai')
                            ->label('Berikan Nilai (0-100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $record->update(['nilai' => (int) $data['nilai']]);

                        \Filament\Notifications\Notification::make()
                            ->title('Nilai berhasil disimpan')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
