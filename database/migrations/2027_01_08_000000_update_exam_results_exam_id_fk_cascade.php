<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cek apakah tabel 'hasil_ujian' ada (sesuai nama di database Anda)
        if (!Schema::hasTable('hasil_ujian')) {
            return;
        }

        Schema::table('hasil_ujian', function (Blueprint $table) {
            
            // 2. Hapus FK lama dengan aman
            // Kita coba hapus kunci yang mungkin bernama 'exam_id'
            try {
                $table->dropForeign(['exam_id']);
            } catch (\Throwable $e) {
                // Abaikan jika tidak ada
            }

            // Coba juga hapus jika namanya masih pakai format lama (exam_results_...)
            try {
                $table->dropForeign('exam_results_exam_id_foreign');
            } catch (\Throwable $e) {
                // Abaikan
            }

            // 3. Buat FK baru yang mengarah ke tabel 'ujian' (bukan 'exams')
            // Pastikan kolom di tabel hasil_ujian namanya 'exam_id'. 
            // Jika kolomnya 'ujian_id', ganti 'exam_id' di bawah ini dengan 'ujian_id'.
            try {
                $table->foreign('exam_id')
                    ->references('id')
                    ->on('ujian') // INI YANG PENTING: Arahkan ke tabel 'ujian'
                    ->onDelete('cascade');
            } catch (\Throwable $e) {
                // Abaikan jika FK sudah ada
            }
        });
    }

    public function down(): void
    {
        // Biarkan kosong atau gunakan logic yang aman
        if (Schema::hasTable('hasil_ujian')) {
            Schema::table('hasil_ujian', function (Blueprint $table) {
                try {
                    $table->dropForeign(['exam_id']);
                } catch (\Throwable $e) {}
            });
        }
    }
};
