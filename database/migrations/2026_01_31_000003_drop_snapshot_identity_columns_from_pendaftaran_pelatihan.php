<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // File ini sebelumnya kosong dan membuat migrate gagal.
        // Kolom identitas sudah dipindah dan di-drop oleh migration lain.
    }

    public function down(): void
    {
        // no-op
    }
};
