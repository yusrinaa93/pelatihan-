<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            // --- Bagian 1: Pastikan kolom ada (Biarkan ini tetap ada) ---
            if (!Schema::hasColumn('exam_results', 'user_id')) {
                $table->foreignId('user_id')->constrained('users')->after('id');
            }

            if (!Schema::hasColumn('exam_results', 'exam_id')) {
                // Perhatikan: foreignId() saja kadang sudah bikin constraint otomatis.
                // Tapi kita lanjut ke bawah untuk setel ulang.
                $table->foreignId('exam_id')->after('user_id');
            }

            if (!Schema::hasColumn('exam_results', 'score')) {
                $table->integer('score')->after('exam_id');
            }
        });

        // --- Bagian 2: Perbaiki foreign key (INI YANG DIUBAH) ---
        Schema::table('exam_results', function (Blueprint $table) {

            // >>>>> KOMENTARI / MATIKAN BLOK INI <<<<<
            // Karena kita sedang migrate:fresh (database kosong),
            // tidak ada foreign key lama yang perlu dihapus.
            /*
            try {
                $table->dropForeign(['exam_id']);
            } catch (\Throwable $e) {
                // ignore jika belum ada
            }
            */
            // >>>>> SELESAI KOMENTAR <<<<<

            // Langsung timpa/buat aturan baru (Cascade)
            // Kita bungkus pakai try-catch juga biar aman kalau constraintnya ternyata sudah ada
            try {
                $table->foreign('exam_id')
                    ->references('id')
                    ->on('exams')
                    ->onDelete('cascade');
            } catch (\Throwable $e) {
                // Jika error "already exists", biarkan saja.
            }
        });
    }

    public function down(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            try {
                $table->dropForeign(['exam_id']);
            } catch (\Throwable $e) {
                // ignore
            }
        });
    }
};
