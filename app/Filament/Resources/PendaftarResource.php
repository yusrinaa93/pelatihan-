<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftarResource\Pages;
use App\Models\Attendance;
use App\Models\CourseRegistration;
use App\Models\DutySubmission;
use App\Models\ExamResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PendaftarResource extends Resource
{
    protected static ?string $model = CourseRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pendaftar';
    protected static ?string $modelLabel = 'Pendaftar';
    protected static ?string $pluralModelLabel = 'Daftar Pendaftar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pelatihan_id')
                    ->label('Pelatihan')
                    ->relationship('pelatihan', 'judul')
                    ->disabled()
                    ->dehydrated(false),

                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->dehydrated(false),

                Forms\Components\TextInput::make('user.nik')
                    ->label('NIK')
                    ->disabled()
                    ->dehydrated(false),

                Forms\Components\TextInput::make('user.nomor_wa')
                    ->label('No. HP / WhatsApp')
                    ->disabled()
                    ->dehydrated(false),

                Forms\Components\TextInput::make('user.tempat_lahir')
                    ->label('Tempat Lahir')
                    ->disabled()
                    ->dehydrated(false),

                Forms\Components\DatePicker::make('user.tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->disabled()
                    ->dehydrated(false),

                Forms\Components\Placeholder::make('kelulusan_realtime')
                    ->label('Kelulusan (Realtime)')
                    ->content(function ($record) {
                        if (! $record) return '-';

                        $examScore = ExamResult::where('user_id', $record->user_id)
                            ->whereHas('exam', fn ($q) => $q->where('pelatihan_id', $record->pelatihan_id))
                            ->avg('nilai') ?? 0;

                        $dutyScore = DutySubmission::where('user_id', $record->user_id)
                            ->whereNotNull('nilai')
                            ->whereHas('duty', fn ($q) => $q->where('pelatihan_id', $record->pelatihan_id))
                            ->avg('nilai') ?? 0;

                        $attendanceCount = Attendance::where('user_id', $record->user_id)
                            ->whereHas('schedule', fn ($q) => $q->where('pelatihan_id', $record->pelatihan_id))
                            ->count();

                        $lulus = ($examScore >= 50) && ($dutyScore >= 50) && ($attendanceCount >= 3);

                        $examDisp = number_format((float) $examScore, 0);
                        $dutyDisp = number_format((float) $dutyScore, 0);

                        $detail = "Ujian: {$examDisp}, Tugas: {$dutyDisp}, Presensi: {$attendanceCount}";
                        return ($lulus ? 'Lulus' : 'Tidak Lulus') . " ({$detail})";
                    }),
            ]);
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
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.nik')
                    ->label('NIK')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.nomor_wa')
                    ->label('No. HP')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('kelulusan_realtime')
                    ->label('Kelulusan')
                    ->getStateUsing(function (CourseRegistration $record) {
                        $examScore = ExamResult::where('user_id', $record->user_id)
                            ->whereHas('exam', fn ($q) => $q->where('pelatihan_id', $record->pelatihan_id))
                            ->avg('nilai') ?? 0;

                        $dutyScore = DutySubmission::where('user_id', $record->user_id)
                            ->whereNotNull('nilai')
                            ->whereHas('duty', fn ($q) => $q->where('pelatihan_id', $record->pelatihan_id))
                            ->avg('nilai') ?? 0;

                        $attendanceCount = Attendance::where('user_id', $record->user_id)
                            ->whereHas('schedule', fn ($q) => $q->where('pelatihan_id', $record->pelatihan_id))
                            ->count();

                        return (($examScore >= 50) && ($dutyScore >= 50) && ($attendanceCount >= 3)) ? 1 : 0;
                    })
                    ->colors([
                        'success' => 1,
                        'danger' => 0,
                    ])
                    ->formatStateUsing(fn ($state) => $state === 1 ? 'Lulus' : 'Tidak Lulus'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftars::route('/'),
            'view' => Pages\ViewPendaftar::route('/{record}'),
        ];
    }
}