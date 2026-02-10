<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    use HasFactory;

    // Ganti nama tabel: course_registrations -> pendaftaran_pelatihan
    protected $table = 'pendaftaran_pelatihan';

    protected $fillable = [
        'user_id',
        'pelatihan_id',
        'lulus',
        'catatan',
    ];

    // Remove legacy sync: we now store only `pelatihan_id`

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
}
