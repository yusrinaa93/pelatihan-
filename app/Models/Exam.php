<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\ExamResult;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'ujian';

    protected $fillable = [
        'judul',
        'deskripsi',
        'pelatihan_id',
        'batas_waktu',
    ];

    protected $casts = [
        'batas_waktu' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function pelatihan()
    {
        return $this->belongsTo(Course::class, 'pelatihan_id');
    }

    // Backward-compat alias
    public function course()
    {
        return $this->pelatihan();
    }

    public function getIsCompletedAttribute()
    {
        if (! Auth::check()) {
            return false;
        }
        return $this->results()->where('user_id', Auth::id())->exists();
    }

    public function getIsDeadlinePassedAttribute(): bool
    {
        if (! $this->batas_waktu) {
            return false;
        }

        return now()->gt($this->batas_waktu);
    }
}