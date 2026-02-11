<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationLabel = 'Sertifikat';
    protected static ?string $modelLabel = 'Sertifikat';
    protected static ?string $pluralModelLabel = 'Daftar Sertifikat';

    // Sertifikat dibuat oleh sistem dari sisi peserta, jadi admin tidak perlu create/edit.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        // No edit form (read-only through table)
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelatihan.judul')
                    ->label('Pelatihan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('nomor_sertifikat')
                    ->label('No. Sertifikat')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dicetak Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->label('Reset (Hapus)')
                    ->modalHeading('Reset status cetak sertifikat?')
                    ->modalDescription('Tindakan ini akan menghapus record sertifikat sehingga peserta dapat mencetak ulang.')
                    ->successNotificationTitle('Sertifikat direset (record dihapus).'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Reset (Hapus) Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
        ];
    }
}
