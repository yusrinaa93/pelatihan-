<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('jadwal')) {
            return;
        }

        if (! Schema::hasColumn('jadwal', 'pelatihan_id')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->foreignId('pelatihan_id')
                    ->nullable()
                    ->constrained('pelatihan')
                    ->nullOnDelete()
                    ->after('id');
            });
        }

        // Backfill from legacy FK name if it exists.
        if (Schema::hasColumn('jadwal', 'course_id') && Schema::hasColumn('jadwal', 'pelatihan_id')) {
            DB::table('jadwal')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('jadwal') || ! Schema::hasColumn('jadwal', 'pelatihan_id')) {
            return;
        }

        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pelatihan_id');
        });
    }
};
