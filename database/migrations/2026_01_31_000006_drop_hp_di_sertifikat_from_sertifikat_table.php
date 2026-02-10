<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sertifikat')) {
            return;
        }

        Schema::table('sertifikat', function (Blueprint $table) {
            // Kolom yang benar di DB adalah hp_di_sertifikat (bukan nohp_di_sertifikat)
            if (Schema::hasColumn('sertifikat', 'hp_di_sertifikat')) {
                $table->dropColumn('hp_di_sertifikat');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('sertifikat')) {
            return;
        }

        Schema::table('sertifikat', function (Blueprint $table) {
            if (!Schema::hasColumn('sertifikat', 'hp_di_sertifikat')) {
                $table->string('hp_di_sertifikat')->nullable();
            }
        });
    }
};
