<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'title',
        'image_path',
        'description',
        'short_description',
        'start_date',
        'end_date',
        'is_certificate_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_certificate_active' => 'boolean',
    ];

    public function getRegistrationEndedAttribute(): bool
    {
        // If end_date is missing, don't block registration.
        if (! $this->end_date) {
            return false;
        }

        // Registration ends after end_date has passed.
        return now()->startOfDay()->gt($this->end_date->startOfDay());
    }

    // Optional accessor to support older blades using 'judul'
    public function getJudulAttribute()
    {
        return $this->title;
    }
}
