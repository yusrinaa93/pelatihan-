<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pendaftaran_pelatihan')) {
            return;
        }

        // Drop kolom identitas peserta dari tabel pendaftaran (karena sudah ada di users)
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftaran_pelatihan', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('pendaftaran_pelatihan', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
            if (Schema::hasColumn('pendaftaran_pelatihan', 'tempat_lahir')) {
                $table->dropColumn('tempat_lahir');
            }
            if (Schema::hasColumn('pendaftaran_pelatihan', 'tanggal_lahir')) {
                $table->dropColumn('tanggal_lahir');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('pendaftaran_pelatihan')) {
            return;
        }

        // Kembalikan kolom (nullable biar aman)
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran_pelatihan', 'nik')) {
                $table->string('nik')->nullable();
            }
            if (!Schema::hasColumn('pendaftaran_pelatihan', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }
            if (!Schema::hasColumn('pendaftaran_pelatihan', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable();
            }
            if (!Schema::hasColumn('pendaftaran_pelatihan', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable();
            }
        });
    }
};
