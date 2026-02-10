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
        // NOTE: Tabel aplikasi sudah di-Indonesia-kan.
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();

            $table->string('kategori'); // Contoh: 'Pelatihan PPH - Batch 1'
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');

            $table->text('tautan_zoom')->nullable();

            $table->boolean('manual_presensi')->default(false);
            $table->boolean('presensi_open')->default(false);
            $table->boolean('presensi_close')->default(false);

            // Relasi ke pelatihan (nullable sesuai migration add_course_id sebelumnya)
            $table->foreignId('pelatihan_id')->nullable()->constrained('pelatihan')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};