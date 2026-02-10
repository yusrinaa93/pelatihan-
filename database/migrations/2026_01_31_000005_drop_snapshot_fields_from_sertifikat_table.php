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
            // Hapus kolom snapshot, karena akan diambil dari users berdasarkan user_id
            if (Schema::hasColumn('sertifikat', 'nama_di_sertifikat')) {
                $table->dropColumn('nama_di_sertifikat');
            }
            if (Schema::hasColumn('sertifikat', 'ttl_di_sertifikat')) {
                $table->dropColumn('ttl_di_sertifikat');
            }
            // Real column name in this DB is `hp_di_sertifikat`
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
            // Kembalikan kolom (nullable biar aman)
            if (!Schema::hasColumn('sertifikat', 'nama_di_sertifikat')) {
                $table->string('nama_di_sertifikat')->nullable();
            }
            if (!Schema::hasColumn('sertifikat', 'ttl_di_sertifikat')) {
                $table->string('ttl_di_sertifikat')->nullable();
            }
            if (!Schema::hasColumn('sertifikat', 'hp_di_sertifikat')) {
                $table->string('hp_di_sertifikat')->nullable();
            }
        });
    }
};
