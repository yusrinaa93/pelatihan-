<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;

class FillShortDescription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:fill-short-desc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill short_description dari description untuk course yang belum ada short description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $courses = Course::whereNull('short_description')->get();

        foreach ($courses as $course) {
            // Ambil deskripsi, hapus HTML tags, potong 200 karakter
            $text = strip_tags($course->description);
            $course->short_description = substr($text, 0, 200);
            $course->save();
            $this->info("✅ Updated: {$course->title}");
        }

        $this->info("Selesai! {$courses->count()} course di-update.");
    }
}
