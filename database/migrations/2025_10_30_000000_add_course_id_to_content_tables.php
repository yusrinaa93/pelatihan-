<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // jadwal (was schedules)
        if (Schema::hasTable('jadwal') && ! Schema::hasColumn('jadwal', 'pelatihan_id')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->foreignId('pelatihan_id')->nullable()->constrained('pelatihan')->nullOnDelete();
            });
        }

        // tugas (was duties)
        // NOTE: In this app, duties initially used `course_id`. After Indonesian renames, the table became `tugas`.
        // Some parts of the codebase still reference `pelatihan_id`, but the DB uses `course_id`.
        if (Schema::hasTable('tugas')) {
            if (! Schema::hasColumn('tugas', 'course_id')) {
                Schema::table('tugas', function (Blueprint $table) {
                    $table->foreignId('course_id')->nullable()->constrained('pelatihan')->nullOnDelete();
                });
            }

            // If an older column exists, keep it in sync so legacy code doesn't break.
            if (Schema::hasColumn('tugas', 'pelatihan_id') && Schema::hasColumn('tugas', 'course_id')) {
                DB::table('tugas')
                    ->whereNull('pelatihan_id')
                    ->whereNotNull('course_id')
                    ->update(['pelatihan_id' => DB::raw('course_id')]);
            }
        }

        // ujian (was exams)
        if (Schema::hasTable('ujian') && ! Schema::hasColumn('ujian', 'pelatihan_id')) {
            Schema::table('ujian', function (Blueprint $table) {
                $table->foreignId('pelatihan_id')->nullable()->constrained('pelatihan')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('jadwal') && Schema::hasColumn('jadwal', 'pelatihan_id')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->dropConstrainedForeignId('pelatihan_id');
            });
        }
        if (Schema::hasTable('tugas') && Schema::hasColumn('tugas', 'course_id')) {
            Schema::table('tugas', function (Blueprint $table) {
                $table->dropConstrainedForeignId('course_id');
            });
        }
        if (Schema::hasTable('ujian') && Schema::hasColumn('ujian', 'pelatihan_id')) {
            Schema::table('ujian', function (Blueprint $table) {
                $table->dropConstrainedForeignId('pelatihan_id');
            });
        }
    }
};


