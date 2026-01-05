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
        Schema::table('course_registrations', function (Blueprint $table) {
            // Make all fields nullable with default empty string or null
            $table->string('nik')->nullable()->default('')->change();
            $table->string('no_hp')->nullable()->default('')->change();
            $table->string('tempat_lahir')->nullable()->default('')->change();
            $table->date('tanggal_lahir')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->string('nik')->nullable()->change();
            $table->string('no_hp')->nullable()->change();
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
        });
    }
};
