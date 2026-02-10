<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateProfileCompletedStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update profile_completed status untuk user yang sudah lengkap datanya';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Update semua user yang sudah punya data lengkap
        $updated = User::whereNotNull('tempat_lahir')
            ->whereNotNull('tanggal_lahir')
            ->whereNotNull('nomor_wa')
            ->whereNotNull('alamat')
            ->update(['profile_completed' => true]);

        $this->info("✅ Berhasil update {$updated} user dengan profile lengkap!");
    }
}
