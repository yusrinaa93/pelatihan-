<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ujian')) {
            return;
        }

        // Pastikan pelatihan_id terisi sebelum course_id dihapus
        if (Schema::hasColumn('ujian', 'course_id') && Schema::hasColumn('ujian', 'pelatihan_id')) {
            DB::table('ujian')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }

        if (!Schema::hasColumn('ujian', 'course_id')) {
            return;
        }

        Schema::table('ujian', function (Blueprint $table) {
            // FK legacy name: exams_course_id_foreign
            try {
                $table->dropForeign('exams_course_id_foreign');
            } catch (\Throwable $e) {
                try {
                    $table->dropForeign(['course_id']);
                } catch (\Throwable $e2) {
                    // ignore
                }
            }

            $table->dropColumn('course_id');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('ujian')) {
            return;
        }

        if (!Schema::hasColumn('ujian', 'course_id')) {
            Schema::table('ujian', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->nullable()->after('updated_at');
            });

            Schema::table('ujian', function (Blueprint $table) {
                try {
                    $table->foreign('course_id', 'exams_course_id_foreign')
                        ->references('id')
                        ->on('pelatihan')
                        ->nullOnDelete();
                } catch (\Throwable $e) {
                    // ignore
                }
            });
        }

        // backfill dari pelatihan_id
        if (Schema::hasColumn('ujian', 'course_id') && Schema::hasColumn('ujian', 'pelatihan_id')) {
            DB::table('ujian')
                ->whereNull('course_id')
                ->whereNotNull('pelatihan_id')
                ->update(['course_id' => DB::raw('pelatihan_id')]);
        }
    }
};
