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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('email');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('nomor_wa')->nullable()->after('tanggal_lahir');
            $table->text('alamat')->nullable()->after('nomor_wa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tempat_lahir', 'tanggal_lahir', 'nomor_wa', 'alamat']);
        });
    }
};
