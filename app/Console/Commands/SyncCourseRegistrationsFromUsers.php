<?php

namespace App\Console\Commands;

use App\Models\CourseRegistration;
use Illuminate\Console\Command;

class SyncCourseRegistrationsFromUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Usage:
     *  php artisan course-registrations:sync
     *  php artisan course-registrations:sync --force
     *  php artisan course-registrations:sync --only-empty
     */
    protected $signature = 'course-registrations:sync {--force : Overwrite existing values} {--only-empty : Only fill empty/null fields}';

    /**
     * The console command description.
     */
    protected $description = 'Sync identitas (NIK, WA, TTL) pada course_registrations dari tabel users.';

    public function handle(): int
    {
        $force = (bool) $this->option('force');
        $onlyEmpty = (bool) $this->option('only-empty');

        if ($force && $onlyEmpty) {
            $this->error('Pilih salah satu: --force atau --only-empty (tidak boleh keduanya).');
            return self::FAILURE;
        }

        $query = CourseRegistration::query()->with('user');

        if ($onlyEmpty) {
            $query->where(function ($q) {
                $q->whereNull('nik')->orWhere('nik', '')->orWhere('nik', '-')
                  ->orWhereNull('no_hp')->orWhere('no_hp', '')->orWhere('no_hp', '-')
                  ->orWhereNull('tempat_lahir')->orWhere('tempat_lahir', '')->orWhere('tempat_lahir', '-')
                  ->orWhereNull('tanggal_lahir');
            });
        }

        $total = $query->count();
        if ($total === 0) {
            $this->info('Tidak ada data yang perlu disinkronkan.');
            return self::SUCCESS;
        }

        $this->info("Menemukan {$total} data course_registrations untuk diproses...");

        $updated = 0;
        $skipped = 0;

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $query->chunkById(200, function ($rows) use (&$updated, &$skipped, $force, $onlyEmpty, $bar) {
            foreach ($rows as $reg) {
                $user = $reg->user;
                if (!$user) {
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                $data = [
                    'nik' => $user->nik,
                    'no_hp' => $user->nomor_wa,
                    'tempat_lahir' => $user->tempat_lahir,
                    'tanggal_lahir' => $user->tanggal_lahir,
                ];

                // normalize empty
                foreach ($data as $k => $v) {
                    if ($v === null || $v === '') {
                        $data[$k] = null;
                    }
                }

                $changed = false;

                foreach ($data as $field => $value) {
                    if ($force) {
                        if ($reg->{$field} !== $value) {
                            $reg->{$field} = $value;
                            $changed = true;
                        }
                        continue;
                    }

                    // default behaviour: fill if empty-ish
                    $current = $reg->{$field};
                    $isEmptyish = $current === null || $current === '' || $current === '-';
                    if ($isEmptyish && $value !== null) {
                        $reg->{$field} = $value;
                        $changed = true;
                    }
                }

                if ($changed) {
                    $reg->save();
                    $updated++;
                } else {
                    $skipped++;
                }

                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info("Selesai. Updated: {$updated}, Skipped: {$skipped}.");

        return self::SUCCESS;
    }
}
