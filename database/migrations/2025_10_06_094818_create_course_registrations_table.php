<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_xxxxxx_create_course_registrations_table.php

public function up(): void
{
    Schema::create('pendaftaran_pelatihan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel users
        $table->foreignId('course_id')->constrained('pelatihan')->onDelete('cascade'); // Menghubungkan ke tabel pelatihan
        $table->string('nik');
        $table->string('no_hp');
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_pelatihan');
    }
};
