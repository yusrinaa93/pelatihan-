<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Kolom-kolom ini diizinkan untuk diisi melalui form.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pelatihan_id',
        'nama',
        'deskripsi',
        'path_lampiran',
        'batas_waktu',
    ];

    /**
     * Mengatur tipe data atribut secara otomatis.
     * Ini akan mengubah 'batas_waktu' menjadi objek Carbon yang lebih mudah dikelola.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'batas_waktu' => 'datetime',
    ];

    /**
     * Mendefinisikan relasi "One-to-Many": Satu Tugas (Duty) memiliki banyak Pengumpulan (Submissions).
     * Ini memungkinkan kita untuk memanggil $duty->submissions.
     */
    public function submissions()
    {
        return $this->hasMany(DutySubmission::class);
    }

    public function pelatihan()
    {
        return $this->belongsTo(Course::class, 'pelatihan_id');
    }

    // Backward-compat aliases
    public function course()
    {
        return $this->pelatihan();
    }

    public function getNameAttribute()
    {
        return $this->nama;
    }

    public function getDescriptionAttribute()
    {
        return $this->deskripsi;
    }

    public function getAttachmentPathAttribute()
    {
        return $this->path_lampiran;
    }

    public function getDeadlineAttribute()
    {
        return $this->batas_waktu;
    }

    /**
     * Cek apakah deadline sudah lewat
     */
    public function isDeadlinePassed()
    {
        return now()->isAfter($this->batas_waktu);
    }

    /**
     * Cek apakah tugas masih bisa dikumpulkan
     */
    public function canSubmit()
    {
        return !$this->isDeadlinePassed();
    }
}