<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('tugas')) {
            return;
        }

        // Add the expected column used by Filament forms / Eloquent ($fillable etc.)
        if (! Schema::hasColumn('tugas', 'pelatihan_id')) {
            Schema::table('tugas', function (Blueprint $table) {
                $table->foreignId('pelatihan_id')
                    ->nullable()
                    ->constrained('pelatihan')
                    ->nullOnDelete()
                    ->after('id');
            });
        }

        // If the DB already has course_id, backfill pelatihan_id so existing records stay connected.
        if (Schema::hasColumn('tugas', 'course_id') && Schema::hasColumn('tugas', 'pelatihan_id')) {
            DB::table('tugas')
                ->whereNull('pelatihan_id')
                ->whereNotNull('course_id')
                ->update(['pelatihan_id' => DB::raw('course_id')]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('tugas') || ! Schema::hasColumn('tugas', 'pelatihan_id')) {
            return;
        }

        Schema::table('tugas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pelatihan_id');
        });
    }
};
