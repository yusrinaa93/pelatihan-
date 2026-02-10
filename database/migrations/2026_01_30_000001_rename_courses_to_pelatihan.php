<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('pelatihan')
            && Schema::hasColumn('pelatihan', 'short_description')
            && !Schema::hasColumn('pelatihan', 'deskripsi_singkat')
        ) {
            $col = DB::selectOne("
                SELECT COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT
                FROM information_schema.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'pelatihan'
                  AND COLUMN_NAME = 'short_description'
                LIMIT 1
            ");

            $type = $col->COLUMN_TYPE ?? 'text';
            $nullable = (($col->IS_NULLABLE ?? 'YES') === 'YES') ? 'NULL' : 'NOT NULL';

            $defaultSql = '';
            if (isset($col->COLUMN_DEFAULT) && $col->COLUMN_DEFAULT !== null) {
                $lowerType = strtolower((string) $type);
                if (!str_contains($lowerType, 'text') && !str_contains($lowerType, 'blob')) {
                    $defaultSql = ' DEFAULT ' . DB::getPdo()->quote($col->COLUMN_DEFAULT);
                }
            }

            DB::statement("ALTER TABLE `pelatihan` CHANGE `short_description` `deskripsi_singkat` {$type} {$nullable}{$defaultSql}");
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('pelatihan')
            && Schema::hasColumn('pelatihan', 'deskripsi_singkat')
            && !Schema::hasColumn('pelatihan', 'short_description')
        ) {
            $col = DB::selectOne("
                SELECT COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT
                FROM information_schema.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'pelatihan'
                  AND COLUMN_NAME = 'deskripsi_singkat'
                LIMIT 1
            ");

            $type = $col->COLUMN_TYPE ?? 'text';
            $nullable = (($col->IS_NULLABLE ?? 'YES') === 'YES') ? 'NULL' : 'NOT NULL';

            $defaultSql = '';
            if (isset($col->COLUMN_DEFAULT) && $col->COLUMN_DEFAULT !== null) {
                $lowerType = strtolower((string) $type);
                if (!str_contains($lowerType, 'text') && !str_contains($lowerType, 'blob')) {
                    $defaultSql = ' DEFAULT ' . DB::getPdo()->quote($col->COLUMN_DEFAULT);
                }
            }

            DB::statement("ALTER TABLE `pelatihan` CHANGE `deskripsi_singkat` `short_description` {$type} {$nullable}{$defaultSql}");
        }
    }
};