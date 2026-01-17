<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Course;

// SEMUA 'use' statement HARUS DI SINI, di luar class
class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Jadwal';
    protected static ?string $modelLabel = 'Jadwal';
    protected static ?string $pluralModelLabel = 'Daftar Jadwal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label('Pelatihan')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\TextInput::make('category')
                    ->label('Nama/Kategori Jadwal')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Waktu Mulai')
                    ->timezone('Asia/Jakarta')
                    ->seconds(false)
                    ->displayFormat('d/m/Y H:i')
                    ->required(),

                Forms\Components\DateTimePicker::make('end_time')
                    ->label('Waktu Selesai')
                    ->timezone('Asia/Jakarta')
                    ->seconds(false)
                    ->displayFormat('d/m/Y H:i')
                    ->required(),

                Forms\Components\Toggle::make('manual_presensi')
                    ->label('Presensi Manual (override jam)')
                    ->helperText('Jika aktif, admin dapat paksa buka/tutup presensi tanpa mengikuti rentang waktu.')
                    ->default(false)
                    ->reactive(),

                Forms\Components\Toggle::make('presensi_open')
                    ->label('Buka Presensi')
                    ->default(false)
                    ->visible(fn (Forms\Get $get) => (bool) $get('manual_presensi'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $set('presensi_close', false);
                        }
                    }),

                Forms\Components\Toggle::make('presensi_close')
                    ->label('Tutup Presensi')
                    ->default(false)
                    ->visible(fn (Forms\Get $get) => (bool) $get('manual_presensi'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $set('presensi_open', false);
                        }
                    }),

                Forms\Components\TextInput::make('zoom_link')
                    ->label('Link Zoom Meeting')
                    ->url()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->label('Nama Jadwal')
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Waktu Mulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Waktu Selesai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }    
}
