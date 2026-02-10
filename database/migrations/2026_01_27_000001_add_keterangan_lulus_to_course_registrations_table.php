<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            // null = belum dinilai
            $table->boolean('is_lulus')->nullable()->after('tanggal_lahir');
            $table->text('keterangan')->nullable()->after('is_lulus');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->dropColumn(['is_lulus', 'keterangan']);
        });
    }
};
