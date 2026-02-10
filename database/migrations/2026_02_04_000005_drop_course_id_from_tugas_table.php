<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tugas')) {
            return;
        }

        // Pastikan pelatihan_id terisi sebelum course_id dihapus
        if (Schema::hasColumn('tugas', 'course_id') && Schema::hasColumn('tugas', 'pelatihan_id')) {
            DB::table('tugas')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }

        if (!Schema::hasColumn('tugas', 'course_id')) {
            return;
        }

        Schema::table('tugas', function (Blueprint $table) {
            // FK legacy name: duties_course_id_foreign
            try {
                $table->dropForeign('duties_course_id_foreign');
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
        if (!Schema::hasTable('tugas')) {
            return;
        }

        if (!Schema::hasColumn('tugas', 'course_id')) {
            Schema::table('tugas', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->nullable()->after('updated_at');
            });

            Schema::table('tugas', function (Blueprint $table) {
                try {
                    $table->foreign('course_id', 'duties_course_id_foreign')
                        ->references('id')
                        ->on('pelatihan')
                        ->nullOnDelete();
                } catch (\Throwable $e) {
                    // ignore
                }
            });
        }

        // backfill dari pelatihan_id
        if (Schema::hasColumn('tugas', 'course_id') && Schema::hasColumn('tugas', 'pelatihan_id')) {
            DB::table('tugas')
                ->whereNull('course_id')
                ->whereNotNull('pelatihan_id')
                ->update(['course_id' => DB::raw('pelatihan_id')]);
        }
    }
};
