<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('pelatihan_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['pelatihan_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }
};
