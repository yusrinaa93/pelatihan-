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

        Schema::table('users', function (Blueprint $table) {
            // Kolom legacy (sudah dipindahkan ke tabel rekening_bank)
            $toDrop = [];

            if (Schema::hasColumn('users', 'bank_name')) {
                $toDrop[] = 'bank_name';
            }
            if (Schema::hasColumn('users', 'bank_account_name')) {
                $toDrop[] = 'bank_account_name';
            }
            if (Schema::hasColumn('users', 'bank_account_number')) {
                $toDrop[] = 'bank_account_number';
            }

            if (!empty($toDrop)) {
                $table->dropColumn($toDrop);
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bank_account_name')) {
                $table->string('bank_account_name', 150)->nullable()->after('kodepos');
            }
            if (!Schema::hasColumn('users', 'bank_account_number')) {
                $table->string('bank_account_number', 50)->nullable()->after('bank_account_name');
            }
            if (!Schema::hasColumn('users', 'bank_name')) {
                $table->string('bank_name', 100)->nullable()->after('bank_account_number');
            }
        });
    }
};
