<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Menampilkan halaman daftar kursus dengan paginasi.
     */
    public function index()
    {
        $registeredCourseIds = collect();

        if (Auth::check()) {
            $registeredCourseIds = \App\Models\CourseRegistration::where('user_id', Auth::id())
                ->pluck('pelatihan_id');
        }

        $courses = Course::latest()->paginate(8);

        return view('courses', [
            'registeredCourseIds' => $registeredCourseIds,
            'courses' => $courses
        ]);
    }

    /**
     * Menampilkan halaman FAQ.
     */
    public function faq()
    {
        $faqs = [
            [
                'title' => 'Bagaimana cara mendaftar kursus?',
                'content' => 'Masuk ke menu Courses, pilih pelatihan yang diinginkan, lalu klik tombol "Register Course". Lengkapi data pendaftaran dan tunggu konfirmasi melalui email atau WhatsApp.',
            ],
            [
                'title' => 'Saya sudah daftar, tapi stok kursus penuh?',
                'content' => 'Jika kuota sudah penuh, Anda akan dimasukkan ke daftar tunggu. Tim kami akan menghubungi segera ketika batch berikutnya dibuka.',
            ],
            [
                'title' => 'Bagaimana cara mengikuti Zoom meeting?',
                'content' => 'Masuk ke halaman My Courses > pilih kursus > tab "Jadwal & Zoom". Klik tombol "Join Zoom" pada jadwal yang sedang aktif.',
            ],
            [
                'title' => 'Di mana saya mengunduh materi tugas?',
                'content' => 'Pada tab "Tugas" di halaman detail kursus, admin akan mengunggah file tugas. Tekan tombol "Unduh Tugas" untuk mendapatkan berkas terbaru.',
            ],
            [
                'title' => 'Apakah saya bisa mengulang ujian?',
                'content' => 'Pengulangan ujian dapat dilakukan jika status ujian masih terbuka dan Anda belum mencapai nilai minimal. Hubungi admin jika membutuhkan reset ujian.',
            ],
            [
                'title' => 'Kapan sertifikat bisa diunduh?',
                'content' => 'Setelah menyelesaikan presensi minimal 3 kali, nilai ujian ≥ 50, dan nilai tugas ≥ 50, buka menu My Certificates lalu klik "Lihat / Unduh".',
            ],
        ];

        return view('faq', [
            'activeSidebar' => 'faq',
            'activeNav' => 'courses',
            'faqs' => $faqs,
        ]);
    }
}
