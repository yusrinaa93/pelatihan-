<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Ganti nama tabel: courses -> pelatihan
    protected $table = 'pelatihan';

    protected $fillable = [
        'judul',
        'path_gambar',
        'deskripsi',
        'deskripsi_singkat',
        'tanggal_mulai',
        'tanggal_selesai',
        'sertifikat_aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'sertifikat_aktif' => 'boolean',
    ];

    public function getRegistrationEndedAttribute(): bool
    {
        if (! $this->tanggal_selesai) {
            return false;
        }

        return now()->startOfDay()->gt($this->tanggal_selesai->startOfDay());
    }

    // ===== Backward-compat accessors =====
    public function getTitleAttribute() { return $this->judul; }
    public function setTitleAttribute($value): void { $this->attributes['judul'] = $value; }

    public function getDescriptionAttribute() { return $this->deskripsi; }
    public function setDescriptionAttribute($value): void { $this->attributes['deskripsi'] = $value; }

    public function getImagePathAttribute() { return $this->path_gambar; }
    public function setImagePathAttribute($value): void { $this->attributes['path_gambar'] = $value; }

    public function getStartDateAttribute() { return $this->tanggal_mulai; }
    public function setStartDateAttribute($value): void { $this->attributes['tanggal_mulai'] = $value; }

    public function getEndDateAttribute() { return $this->tanggal_selesai; }
    public function setEndDateAttribute($value): void { $this->attributes['tanggal_selesai'] = $value; }

    public function getIsCertificateActiveAttribute() { return $this->sertifikat_aktif; }
    public function setIsCertificateActiveAttribute($value): void { $this->attributes['sertifikat_aktif'] = $value; }

    // Optional accessor to support older blades using 'judul'
    public function getJudulAttribute()
    {
        return $this->attributes['judul'] ?? null;
    }

    // Backward compatibility: support reads of $course->short_description
    public function getShortDescriptionAttribute()
    {
        return $this->deskripsi_singkat;
    }

    public function setShortDescriptionAttribute($value): void
    {
        $this->attributes['deskripsi_singkat'] = $value;
    }
}
