<?php

namespace App\Filament\Resources\DutyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage; // <-- WAJIB: Agar fitur download berfungsi

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_filename')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_filename')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pengunggah')
                    ->searchable(),

                Tables\Columns\TextColumn::make('original_filename')
                    ->label('Nama File'),
                    
                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state === null ? '-' : $state),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y, H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                // --- PERBAIKAN ACTION DOWNLOAD ---
                Tables\Actions\Action::make('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    // Menggunakan Storage Facade untuk menghasilkan URL yang valid
                    ->url(fn ($record) => Storage::disk('public')->url($record->file_path))
                    // Membuka di tab baru (opsional, karena 'download' attribute akan mengatasinya)
                    ->openUrlInNewTab()
                    // Menambahkan atribut HTML 'download' agar browser langsung menyimpan file
                    ->extraAttributes(fn ($record) => [
                        'download' => $record->original_filename ?? 'downloaded-file'
                    ]), 
                // ---------------------------------

                Tables\Actions\Action::make('Grade')
                    ->icon('heroicon-o-pencil')
                    ->form([
                        Forms\Components\TextInput::make('score')
                            ->label('Nilai (0-100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $record->update(['score' => (int) $data['score']]);
                    })
                    ->requiresConfirmation(false), // Mematikan konfirmasi agar lebih cepat

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}