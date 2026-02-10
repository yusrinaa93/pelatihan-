<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pindahkan data existing dari users.* ke rekening_bank (kalau tabel/kolom ada)
        if (!DB::getSchemaBuilder()->hasTable('rekening_bank')) {
            return;
        }

        if (!DB::getSchemaBuilder()->hasTable('users')) {
            return;
        }

        $usersColumns = DB::getSchemaBuilder()->getColumnListing('users');

        $hasLegacyColumns = in_array('bank_name', $usersColumns, true)
            && in_array('bank_account_name', $usersColumns, true)
            && in_array('bank_account_number', $usersColumns, true);

        if (!$hasLegacyColumns) {
            return;
        }

        // Insert hanya untuk user yang punya minimal 1 field bank terisi dan belum ada record rekening_bank
        DB::statement(<<<SQL
INSERT INTO rekening_bank (user_id, nama_bank, nama_rekening, nomor_rekening, created_at, updated_at)
SELECT u.id,
       COALESCE(u.bank_name, ''),
       COALESCE(u.bank_account_name, ''),
       COALESCE(u.bank_account_number, ''),
       NOW(),
       NOW()
FROM users u
LEFT JOIN rekening_bank rb ON rb.user_id = u.id
WHERE rb.id IS NULL
  AND (
    (u.bank_name IS NOT NULL AND u.bank_name <> '')
    OR (u.bank_account_name IS NOT NULL AND u.bank_account_name <> '')
    OR (u.bank_account_number IS NOT NULL AND u.bank_account_number <> '')
  )
SQL);

        // Optional: bersihkan kolom users agar sumber data tunggal di rekening_bank
        // (Tidak menghapus kolom, hanya nul-kan isinya)
        DB::table('users')
            ->where(function ($q) {
                $q->whereNotNull('bank_name')
                    ->orWhereNotNull('bank_account_name')
                    ->orWhereNotNull('bank_account_number');
            })
            ->update([
                'bank_name' => null,
                'bank_account_name' => null,
                'bank_account_number' => null,
            ]);
    }

    public function down(): void
    {
        // Tidak ada down yang aman (karena erase dari users)
    }
};
