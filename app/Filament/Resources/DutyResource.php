<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DutyResource\Pages;
use App\Filament\Resources\DutyResource\RelationManagers; // <-- PENTING
use App\Models\Duty;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DutyResource extends Resource
{
    protected static ?string $model = Duty::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationLabel = 'Tugas';
    protected static ?string $modelLabel = 'Tugas';
    protected static ?string $pluralModelLabel = 'Daftar Tugas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label('Pelatihan')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Tugas')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi / Instruksi Tambahan')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('attachment_path')
                    ->label('File Tugas')
                    ->disk('public')
                    ->directory('duties')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->maxSize(2048)
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/zip',
                        'application/x-zip-compressed',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    ])
                    ->helperText('Unggah modul atau berkas instruksi tugas (PDF/DOC/ZIP, maks 2MB).')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('deadline')
                    ->label('Deadline')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.title')->label('Pelatihan'),
                Tables\Columns\TextColumn::make('name')->label('Nama Tugas'),
                Tables\Columns\TextColumn::make('deadline')->label('Deadline')->dateTime('d M Y, H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }
    
    // INI BAGIAN YANG ANDA TAMBAHKAN
    public static function getRelations(): array
    {
        return [
            RelationManagers\SubmissionsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDuties::route('/'),
            'create' => Pages\CreateDuty::route('/create'),
            'edit' => Pages\EditDuty::route('/{record}/edit'),
        ];
    }    
}
