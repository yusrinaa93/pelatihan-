<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DutySubmission extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'duty_id',
        'path_file',
        'nama_file_asli',
        'nilai',
    ];

    /**
     * Mendefinisikan relasi "belongsTo": Satu Pengumpulan (Submission) dimiliki oleh satu Pengguna (User).
     * Ini memungkinkan kita untuk memanggil $submission->user->name.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "belongsTo": Satu Pengumpulan (Submission) dimiliki oleh satu Tugas (Duty).
     * Ini memungkinkan kita untuk memanggil $submission->duty->name.
     */
    public function duty()
    {
        return $this->belongsTo(Duty::class);
    }

    /**
     * Accessor untuk mendapatkan URL publik dari file yang diunggah.
     * Dapat dipanggil dengan $submission->download_url.
     *
     * @return string|null
     */
    public function getDownloadUrlAttribute()
    {
        if ($this->path_file) {
            return Storage::disk('public')->url($this->path_file);
        }

        return null;
    }
}