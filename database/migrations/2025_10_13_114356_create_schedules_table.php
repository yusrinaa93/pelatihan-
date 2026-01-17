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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Contoh: 'Pelatihan PPH - Batch 1'
            $table->date('date');       // Kolom untuk tanggal
            $table->string('time');     // Contoh: '07.00 - 16.00'
            $table->text('zoom_link')->nullable(); // Kolom untuk link Zoom, boleh kosong
            $table->boolean('manual_presensi')->default(false); // Kolom untuk toggle manual presensi
            $table->boolean('presensi_open')->default(false); // Kolom untuk menandai apakah presensi dibuka
            $table->boolean('presensi_close')->default(false); // Kolom untuk menandai apakah presensi ditutup
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};