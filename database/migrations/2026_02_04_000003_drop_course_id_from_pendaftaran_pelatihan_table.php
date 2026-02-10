<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pendaftaran_pelatihan')) {
            return;
        }

        // Pastikan pelatihan_id terisi sebelum course_id dihapus
        if (Schema::hasColumn('pendaftaran_pelatihan', 'course_id') && Schema::hasColumn('pendaftaran_pelatihan', 'pelatihan_id')) {
            DB::table('pendaftaran_pelatihan')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }

        if (!Schema::hasColumn('pendaftaran_pelatihan', 'course_id')) {
            return;
        }

        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            // FK name di DB ini masih pakai nama lama (course_registrations_course_id_foreign)
            try {
                $table->dropForeign('course_registrations_course_id_foreign');
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
        if (!Schema::hasTable('pendaftaran_pelatihan')) {
            return;
        }

        if (!Schema::hasColumn('pendaftaran_pelatihan', 'course_id')) {
            Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->nullable()->after('user_id');
            });

            // Recreate FK with the same legacy name to match existing installations
            Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
                try {
                    $table->foreign('course_id', 'course_registrations_course_id_foreign')
                        ->references('id')
                        ->on('pelatihan')
                        ->cascadeOnDelete();
                } catch (\Throwable $e) {
                    // ignore
                }
            });
        }

        // backfill dari pelatihan_id
        if (Schema::hasColumn('pendaftaran_pelatihan', 'course_id') && Schema::hasColumn('pendaftaran_pelatihan', 'pelatihan_id')) {
            DB::table('pendaftaran_pelatihan')
                ->whereNull('course_id')
                ->whereNotNull('pelatihan_id')
                ->update(['course_id' => DB::raw('pelatihan_id')]);
        }
    }
};
