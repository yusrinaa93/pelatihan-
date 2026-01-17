<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // If these columns already exist (on some DBs), this migration may fail.
            // Keep schema consistent going forward.
            if (! Schema::hasColumn('schedules', 'manual_presensi')) {
                $table->boolean('manual_presensi')->default(false)->after('zoom_link');
            }
            if (! Schema::hasColumn('schedules', 'presensi_open')) {
                $table->boolean('presensi_open')->default(false)->after('manual_presensi');
            }
            if (! Schema::hasColumn('schedules', 'presensi_close')) {
                $table->boolean('presensi_close')->default(false)->after('presensi_open');
            }
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            if (Schema::hasColumn('schedules', 'presensi_close')) {
                $table->dropColumn('presensi_close');
            }
            if (Schema::hasColumn('schedules', 'presensi_open')) {
                $table->dropColumn('presensi_open');
            }
            if (Schema::hasColumn('schedules', 'manual_presensi')) {
                $table->dropColumn('manual_presensi');
            }
        });
    }
};
