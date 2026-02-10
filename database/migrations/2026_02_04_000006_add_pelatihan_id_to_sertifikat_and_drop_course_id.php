<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sertifikat')) {
            return;
        }

        // 1) Tambah pelatihan_id jika belum ada
        if (!Schema::hasColumn('sertifikat', 'pelatihan_id')) {
            Schema::table('sertifikat', function (Blueprint $table) {
                $table->foreignId('pelatihan_id')
                    ->nullable()
                    ->constrained('pelatihan')
                    ->nullOnDelete()
                    ->after('user_id');
            });
        }

        // 2) Backfill dari course_id
        if (Schema::hasColumn('sertifikat', 'course_id') && Schema::hasColumn('sertifikat', 'pelatihan_id')) {
            DB::table('sertifikat')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }

        // 3) Drop course_id + FK legacy
        if (Schema::hasColumn('sertifikat', 'course_id')) {
            Schema::table('sertifikat', function (Blueprint $table) {
                try {
                    $table->dropForeign('certificates_course_id_foreign');
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
    }

    public function down(): void
    {
        if (!Schema::hasTable('sertifikat')) {
            return;
        }

        if (!Schema::hasColumn('sertifikat', 'course_id')) {
            Schema::table('sertifikat', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->nullable()->after('user_id');
            });

            Schema::table('sertifikat', function (Blueprint $table) {
                try {
                    $table->foreign('course_id', 'certificates_course_id_foreign')
                        ->references('id')
                        ->on('pelatihan')
                        ->nullOnDelete();
                } catch (\Throwable $e) {
                    // ignore
                }
            });
        }

        if (Schema::hasColumn('sertifikat', 'course_id') && Schema::hasColumn('sertifikat', 'pelatihan_id')) {
            DB::table('sertifikat')
                ->whereNull('course_id')
                ->whereNotNull('pelatihan_id')
                ->update(['course_id' => DB::raw('pelatihan_id')]);
        }

        if (Schema::hasColumn('sertifikat', 'pelatihan_id')) {
            Schema::table('sertifikat', function (Blueprint $table) {
                $table->dropConstrainedForeignId('pelatihan_id');
            });
        }
    }
};
