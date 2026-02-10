<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- Wajib ada ini

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cek apakah tabel 'hasil_ujian' ada
        if (!Schema::hasTable('hasil_ujian')) {
            return;
        }

        // 2. Daftar nama kunci asing (Foreign Key) yang mungkin nyangkut
        // Kita harus menebak nama-nama yang mungkin dibuat oleh Laravel sebelumnya
        $possibleConstraints = [
            'hasil_ujian_exam_id_foreign',      // Nama default dari tabel 'hasil_ujian'
            'exam_results_exam_id_foreign',     // Nama legacy dari tabel bahasa inggris
            'hasil_ujian_ujian_id_foreign',     // Kemungkinan lain
        ];

        foreach ($possibleConstraints as $fkName) {
            // TANYA DULU KE DATABASE: "Apakah kunci ini ada?"
            $exists = DB::table('information_schema.table_constraints')
                ->where('table_name', 'hasil_ujian')
                ->where('constraint_name', $fkName)
                ->exists();

            if ($exists) {
                // Hapus HANYA jika benar-benar ada (Safe Mode)
                Schema::table('hasil_ujian', function (Blueprint $table) use ($fkName) {
                    $table->dropForeign($fkName);
                });
            }
        }

        // 3. Buat Foreign Key Baru
        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Kita bungkus try-catch sekedar untuk jaga-jaga jika constraint sudah terbuat sebagian
            try {
                // Pastikan kolom di database Anda memang 'exam_id'. 
                // Jika di DBeaver kolomnya 'ujian_id', GANTI 'exam_id' jadi 'ujian_id' di sini.
                $table->foreign('exam_id') 
                    ->references('id')
                    ->on('ujian') // Arahkan ke tabel 'ujian'
                    ->onDelete('cascade');
            } catch (\Throwable $e) {
                // Abaikan jika ternyata sudah terbuat
            }
        });
    }

    public function down(): void
    {
        // Biarkan kosong
    }
};
