<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftarResource\Pages;
use App\Models\Pendaftar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Pastikan semua method berada di dalam class ini
class PendaftarResource extends Resource
{
    protected static ?string $model = Pendaftar::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pendaftar';
    protected static ?string $modelLabel = 'Pendaftar';
    protected static ?string $pluralModelLabel = 'Daftar Pendaftar';

    // METHOD FORM ANDA HARUS DI DALAM SINI
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->maxLength(100),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),
                Forms\Components\TextInput::make('nomor_wa')
                    ->label('Nomor WhatsApp')
                    ->required()
                    ->maxLength(25),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat Domisili')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    // METHOD TABLE ANDA JUGA HARUS DI DALAM SINI
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_wa')
                    ->label('Nomor WhatsApp'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftars::route('/'),
            'create' => Pages\CreatePendaftar::route('/create'),
            'edit' => Pages\EditPendaftar::route('/{record}/edit'),
        ];
    }
} // <-- Pastikan ada kurung kurawal penutup untuk class