<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('course_registrations') && ! Schema::hasTable('pendaftaran_pelatihan')) {
            Schema::rename('course_registrations', 'pendaftaran_pelatihan');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pendaftaran_pelatihan') && ! Schema::hasTable('course_registrations')) {
            Schema::rename('pendaftaran_pelatihan', 'course_registrations');
        }
    }
};
