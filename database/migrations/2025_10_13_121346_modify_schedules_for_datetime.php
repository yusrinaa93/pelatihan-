<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Pada skema terbaru, kolom sudah menggunakan dateTime.
            // Migration ini dipertahankan agar instalasi lama tetap bisa naik versi tanpa error.
            if (! Schema::hasColumn('jadwal', 'waktu_mulai')) {
                $table->dateTime('waktu_mulai')->after('kategori');
            }
            if (! Schema::hasColumn('jadwal', 'waktu_selesai')) {
                $table->dateTime('waktu_selesai')->after('waktu_mulai');
            }

            // Jika masih ada kolom legacy, drop.
            if (Schema::hasColumn('jadwal', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('jadwal', 'time')) {
                $table->dropColumn('time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal', 'waktu_mulai')) {
                $table->dropColumn('waktu_mulai');
            }
            if (Schema::hasColumn('jadwal', 'waktu_selesai')) {
                $table->dropColumn('waktu_selesai');
            }

            // Kembalikan kolom legacy (jika diperlukan untuk downgrade)
            if (! Schema::hasColumn('jadwal', 'date')) {
                $table->date('date');
            }
            if (! Schema::hasColumn('jadwal', 'time')) {
                $table->string('time');
            }
        });
    }
};
