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
            // --- Pastikan kolom ada ---
            if (!Schema::hasColumn('exam_results', 'user_id')) {
                $table->foreignId('user_id')->constrained('users')->after('id');
            }

            if (!Schema::hasColumn('exam_results', 'exam_id')) {
                $table->foreignId('exam_id')->after('user_id');
            }

            if (!Schema::hasColumn('exam_results', 'score')) {
                $table->integer('score')->after('exam_id');
            }
        });

        // --- Perbaiki foreign key exam_id supaya cascade ---
        Schema::table('exam_results', function (Blueprint $table) {
            // drop FK lama kalau ada, lalu buat ulang dengan cascade
            try {
                $table->dropForeign(['exam_id']);
            } catch (\Throwable $e) {
                // ignore jika belum ada
            }

            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
                ->onDelete('cascade');

            // user_id biasanya tidak perlu cascade; cukup restrict
            // (opsional) kalau mau, bisa juga cascade user delete.
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
