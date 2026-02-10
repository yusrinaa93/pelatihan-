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
        Schema::table('pelatihan', function (Blueprint $table) {
            // Menambahkan field untuk deskripsi singkat
            if (!Schema::hasColumn('pelatihan', 'deskripsi_singkat')) {
                $table->text('deskripsi_singkat')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihan', function (Blueprint $table) {
            if (Schema::hasColumn('pelatihan', 'deskripsi_singkat')) {
                $table->dropColumn('deskripsi_singkat');
            }
        });
    }
};
