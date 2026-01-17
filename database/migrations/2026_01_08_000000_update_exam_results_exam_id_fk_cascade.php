<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            // Drop existing FK (default name from constrained())
            try {
                $table->dropForeign(['exam_id']);
            } catch (\Throwable $e) {
                // ignore if it doesn't exist
            }
        });

        Schema::table('exam_results', function (Blueprint $table) {
            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
                ->onDelete('cascade');
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

        // Recreate original behaviour (restrict)
        Schema::table('exam_results', function (Blueprint $table) {
            $table->foreign('exam_id')
                ->references('id')
                ->on('exams');
        });
    }
};
