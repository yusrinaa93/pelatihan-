<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        // Tambahan status kelulusan di user (opsional). Dibuat nullable agar aman.
        if (!Schema::hasColumn('users', 'status_kelulusan')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status_kelulusan', 30)->nullable()->after('profile_completed');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'status_kelulusan')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status_kelulusan');
        });
    }
};
