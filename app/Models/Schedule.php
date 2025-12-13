<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'course_id',
        'category',
        'start_time',
        'end_time',
        'zoom_link',
    ];

    /**
     * Casts untuk mengubah tipe data secara otomatis.
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Accessor: Cek apakah Presensi SEDANG BUKA saat ini.
     * Mengembalikan true hanya jika waktu sekarang (now) berada di antara start_time dan end_time.
     */
    public function getIsPresenceActiveAttribute()
    {
        $now = now(); // Waktu server saat ini

        // Jika start_time atau end_time null, anggap tidak aktif
        if (!$this->start_time || !$this->end_time) {
            return false;
        }

        // Cek range waktu (inklusif)
        return $now->between($this->start_time, $this->end_time);
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
    public function course() { return $this->belongsTo(Course::class); }
}