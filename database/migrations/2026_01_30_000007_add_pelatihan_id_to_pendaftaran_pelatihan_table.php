<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('pendaftaran_pelatihan')) {
            return;
        }

        if (! Schema::hasColumn('pendaftaran_pelatihan', 'pelatihan_id')) {
            Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
                $table->foreignId('pelatihan_id')
                    ->nullable()
                    ->constrained('pelatihan')
                    ->nullOnDelete()
                    ->after('user_id');
            });
        }

        // Backfill from legacy FK name if it exists.
        if (Schema::hasColumn('pendaftaran_pelatihan', 'course_id') && Schema::hasColumn('pendaftaran_pelatihan', 'pelatihan_id')) {
            DB::table('pendaftaran_pelatihan')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('pendaftaran_pelatihan') || ! Schema::hasColumn('pendaftaran_pelatihan', 'pelatihan_id')) {
            return;
        }

        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pelatihan_id');
        });
    }
};
