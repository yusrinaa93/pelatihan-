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
        // NOTE: Disabled.
        // Dropping `pendaftar` breaks the admin (Filament) resource that still queries this table.
        // If you really want to migrate away from this table, remove/disable the Filament PendaftarResource first.
        return;

        // Hapus tabel pendaftar karena sekarang menggunakan users table
        // Schema::dropIfExists('pendaftar');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_wa')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }
};
