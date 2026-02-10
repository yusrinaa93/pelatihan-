<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // File ini sebelumnya kosong dan membuat migrate gagal.
        // Tidak dilakukan backfill karena aturan kelulusan dihitung realtime dari nilai/presensi.
        // Jika butuh disimpan permanen, kita bisa implement query khusus di sini.
    }

    public function down(): void
    {
        // no-op
    }
};
