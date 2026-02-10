<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        // 1) Backfill avatar_path dari avatar (kalau avatar masih ada dan avatar_path kosong)
        if (Schema::hasColumn('users', 'avatar') && Schema::hasColumn('users', 'avatar_path')) {
            DB::table('users')
                ->whereNull('avatar_path')
                ->whereNotNull('avatar')
                ->update(['avatar_path' => DB::raw('avatar')]);
        }

        // 2) Drop kolom avatar (pakai avatar_path saja)
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
        });

        // 3) Drop email_verified_at (kalau tidak dipakai verifikasi email)
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('bank_name');
            }
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
        });

        // Restore avatar values from avatar_path (best-effort)
        if (Schema::hasColumn('users', 'avatar') && Schema::hasColumn('users', 'avatar_path')) {
            DB::table('users')
                ->whereNull('avatar')
                ->whereNotNull('avatar_path')
                ->update(['avatar' => DB::raw('avatar_path')]);
        }
    }
};
