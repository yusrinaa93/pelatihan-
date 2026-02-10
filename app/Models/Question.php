<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $fillable = ['exam_id', 'teks_pertanyaan'];

    // Relasi ke tabel exams
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relasi ke tabel options
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}