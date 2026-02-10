<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('ujian')) {
            return;
        }

        if (! Schema::hasColumn('ujian', 'pelatihan_id')) {
            Schema::table('ujian', function (Blueprint $table) {
                $table->foreignId('pelatihan_id')
                    ->nullable()
                    ->constrained('pelatihan')
                    ->nullOnDelete()
                    ->after('id');
            });
        }

        // Backfill from legacy FK name if it exists.
        if (Schema::hasColumn('ujian', 'course_id') && Schema::hasColumn('ujian', 'pelatihan_id')) {
            DB::table('ujian')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('ujian') || ! Schema::hasColumn('ujian', 'pelatihan_id')) {
            return;
        }

        Schema::table('ujian', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pelatihan_id');
        });
    }
};
