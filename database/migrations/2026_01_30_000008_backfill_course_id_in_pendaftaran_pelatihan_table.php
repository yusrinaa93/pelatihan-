<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('pendaftaran_pelatihan')) {
            return;
        }

        // Ensure legacy NOT NULL FK `course_id` is populated for new/old rows.
        if (Schema::hasColumn('pendaftaran_pelatihan', 'course_id') && Schema::hasColumn('pendaftaran_pelatihan', 'pelatihan_id')) {
            DB::table('pendaftaran_pelatihan')
                ->whereNull('course_id')
                ->whereNotNull('pelatihan_id')
                ->update(['course_id' => DB::raw('pelatihan_id')]);
        }
    }

    public function down(): void
    {
        // no-op (data backfill)
    }
};
