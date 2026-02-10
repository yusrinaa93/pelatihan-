<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'judul',
        'nomor_sertifikat',
        'pelatihan_id',
    ];

    /**
     * Relasi "belongsTo":
     * Sertifikat ini DIMILIKI OLEH satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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

    // Backward-compat property aliases (jaga integrasi lama)
    public function getSerialNumberAttribute()
    {
        return $this->nomor_sertifikat;
    }

    public function getPhoneOnCertificateAttribute()
    {
        return $this->user?->nomor_wa;
    }

    public function getNameOnCertificateAttribute()
    {
        return $this->user?->name;
    }

    public function getTtlOnCertificateAttribute()
    {
        if (!$this->user) {
            return null;
        }

        $tempat = $this->user->tempat_lahir;
        $tgl = optional($this->user->tanggal_lahir)?->format('d-m-Y');

        $tempat = is_string($tempat) ? trim($tempat) : '';
        $tgl = is_string($tgl) ? trim($tgl) : '';

        return trim($tempat . ($tempat && $tgl ? ', ' : '') . $tgl);
    }
}
