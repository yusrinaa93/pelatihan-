<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamResource\Pages;
use App\Filament\Resources\ExamResource\RelationManagers;
use App\Models\Exam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Ujian';
    protected static ?string $modelLabel = 'Ujian';
    protected static ?string $pluralModelLabel = 'Daftar Ujian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pelatihan_id')
                    ->label('Pelatihan')
                    ->relationship('pelatihan', 'judul')
                    ->required(),

                TextInput::make('judul')
                    ->label('Judul Ujian')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('deskripsi')
                    ->label('Deskripsi Ujian')
                    ->columnSpanFull(),

                Forms\Components\DateTimePicker::make('batas_waktu')
                    ->label('Deadline Ujian')
                    ->timezone('Asia/Jakarta')
                    ->seconds(false)
                    ->displayFormat('d/m/Y H:i')
                    ->helperText('Jika diisi, peserta tidak bisa mengerjakan setelah melewati deadline.')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pelatihan.judul')->label('Pelatihan'),
                TextColumn::make('judul')->label('Judul Ujian')->searchable(),
                TextColumn::make('deskripsi')->label('Deskripsi')->limit(50),
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
            RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }
}
