<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cek apakah tabel ada (Safety check)
        if (!Schema::hasTable('pendaftaran_pelatihan')) {
            return;
        }

        // 2. Backfill data: Pindahkan course_id ke pelatihan_id sebelum dihapus
        if (Schema::hasColumn('pendaftaran_pelatihan', 'course_id') && Schema::hasColumn('pendaftaran_pelatihan', 'pelatihan_id')) {
            DB::table('pendaftaran_pelatihan')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }

        // 3. Jika kolom course_id sudah tidak ada, berhenti.
        if (!Schema::hasColumn('pendaftaran_pelatihan', 'course_id')) {
            return;
        }

        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            // --- BAGIAN PERBAIKAN DI SINI ---
            
            // Nama foreign key "hantu" (versi lama)
            $fkNameOld = 'course_registrations_course_id_foreign';
            
            // Cek manual ke sistem PostgreSQL apakah constraint ini benar-benar ada
            // Kita pakai query ke information_schema agar aman dan tidak memicu error transaksi
            $fkExists = DB::table('information_schema.table_constraints')
                ->where('table_name', 'pendaftaran_pelatihan')
                ->where('constraint_name', $fkNameOld)
                ->exists();

            if ($fkExists) {
                // Hapus hanya jika benar-benar ada
                $table->dropForeign($fkNameOld);
            } else {
                // Jika nama lama tidak ada, coba cek nama standard baru (pendaftaran_pelatihan_course_id_foreign)
                // Ini untuk jaga-jaga agar dropColumn di bawah tidak gagal
                $fkNameNew = 'pendaftaran_pelatihan_course_id_foreign';
                $fkNewExists = DB::table('information_schema.table_constraints')
                    ->where('table_name', 'pendaftaran_pelatihan')
                    ->where('constraint_name', $fkNameNew)
                    ->exists();
                
                if ($fkNewExists) {
                    $table->dropForeign($fkNameNew);
                }
            }

            // 4. Akhirnya aman untuk menghapus kolom
            $table->dropColumn('course_id');
        });
    }

    public function down(): void
    {
        // ... (Kode down Anda sudah oke, biarkan saja)
        if (!Schema::hasTable('pendaftaran_pelatihan')) {
            return;
        }

        if (!Schema::hasColumn('pendaftaran_pelatihan', 'course_id')) {
            Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->nullable()->after('user_id');
            });
            
            // Kembalikan foreign key (opsional, bungkus try-catch di sini aman karena rollback)
            Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
                try {
                     $table->foreign('course_id', 'course_registrations_course_id_foreign')
                        ->references('id')->on('pelatihan')->cascadeOnDelete();
                } catch (\Throwable $e) {}
            });
        }
    }
};
