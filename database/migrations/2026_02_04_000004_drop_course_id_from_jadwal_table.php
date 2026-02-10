<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jadwal')) {
            return;
        }

        // Pastikan pelatihan_id terisi sebelum course_id dihapus
        if (Schema::hasColumn('jadwal', 'course_id') && Schema::hasColumn('jadwal', 'pelatihan_id')) {
            DB::table('jadwal')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }

        if (!Schema::hasColumn('jadwal', 'course_id')) {
            return;
        }

        Schema::table('jadwal', function (Blueprint $table) {
            // FK name di DB ini masih pakai nama lama (schedules_course_id_foreign)
            try {
                $table->dropForeign('schedules_course_id_foreign');
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
        if (!Schema::hasTable('jadwal')) {
            return;
        }

        if (!Schema::hasColumn('jadwal', 'course_id')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->nullable()->after('updated_at');
            });

            Schema::table('jadwal', function (Blueprint $table) {
                try {
                    $table->foreign('course_id', 'schedules_course_id_foreign')
                        ->references('id')
                        ->on('pelatihan')
                        ->nullOnDelete();
                } catch (\Throwable $e) {
                    // ignore
                }
            });
        }

        // backfill dari pelatihan_id
        if (Schema::hasColumn('jadwal', 'course_id') && Schema::hasColumn('jadwal', 'pelatihan_id')) {
            DB::table('jadwal')
                ->whereNull('course_id')
                ->whereNotNull('pelatihan_id')
                ->update(['course_id' => DB::raw('pelatihan_id')]);
        }
    }
};
