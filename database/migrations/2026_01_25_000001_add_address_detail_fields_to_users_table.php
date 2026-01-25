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
            $table->string('nik', 32)->nullable()->after('alamat');
            $table->string('provinsi', 100)->nullable()->after('nik');
            $table->string('kabupaten', 100)->nullable()->after('provinsi');
            $table->string('kecamatan', 100)->nullable()->after('kabupaten');
            $table->string('kodepos', 10)->nullable()->after('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'provinsi', 'kabupaten', 'kecamatan', 'kodepos']);
        });
    }
};
