<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'pelatihan_id',
        'kategori',
        'waktu_mulai',
        'waktu_selesai',
        'tautan_zoom',
        // actual column names (Indonesian)
        'presensi_manual',
        'presensi_buka',
        'presensi_tutup',
    ];

    /**
     * Casts untuk mengubah tipe data secara otomatis.
     */
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'presensi_manual' => 'boolean',
        'presensi_buka' => 'boolean',
        'presensi_tutup' => 'boolean',
    ];

    // Backward-compat: map legacy attribute names used by older forms/code
    public function setManualPresensiAttribute($value): void
    {
        $this->attributes['presensi_manual'] = $value;
    }

    public function getManualPresensiAttribute()
    {
        return $this->attributes['presensi_manual'] ?? null;
    }

    public function setPresensiOpenAttribute($value): void
    {
        $this->attributes['presensi_buka'] = $value;
    }

    public function getPresensiOpenAttribute()
    {
        return $this->attributes['presensi_buka'] ?? null;
    }

    public function setPresensiCloseAttribute($value): void
    {
        $this->attributes['presensi_tutup'] = $value;
    }

    public function getPresensiCloseAttribute()
    {
        return $this->attributes['presensi_tutup'] ?? null;
    }

    /**
     * Accessor: Cek apakah Presensi SEDANG BUKA saat ini.
     */
    public function getIsPresenceActiveAttribute()
    {
        // Admin override (manual presensi)
        if ($this->presensi_manual) {
            // If both toggles are set, "close" wins for safety.
            if ($this->presensi_tutup) {
                return false;
            }
            if ($this->presensi_buka) {
                return true;
            }
            // Manual enabled but no explicit open => treat as closed.
            return false;
        }

        $now = now(); // Waktu server saat ini

        // Jika start_time atau end_time null, anggap tidak aktif
        if (! $this->waktu_mulai || ! $this->waktu_selesai) {
            return false;
        }

        // Cek range waktu (inklusif)
        return $now->between($this->waktu_mulai, $this->waktu_selesai);
    }

    /**
     * Accessor: Cek apakah user yang login SUDAH presensi.
     */
    public function getHasAttendedAttribute()
    {
        // Jika user belum login, return false
        if (!auth()->check()) {
            return false;
        }

        // Cek di tabel attendances
        return $this->attendances()
                    ->where('user_id', auth()->id())
                    ->exists();
    }

    public function attendances() { return $this->hasMany(Attendance::class); }
    public function pelatihan() { return $this->belongsTo(Course::class, 'pelatihan_id'); }

    // Backward-compat alias (kalau masih ada kode lama yang memanggil $schedule->course)
    public function course() { return $this->pelatihan(); }
}