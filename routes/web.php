<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GuestCourseController;
use App\Http\Controllers\MyCourseController;
use App\Http\Controllers\DutyController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AccountController;
use App\Models\Course;

// --- RUTE PUBLIK (Dapat diakses siapa saja) ---

Route::get('/', function () {
    $courses = Course::latest()->take(6)->get();

    return view('home', [
        'activeNav' => 'home',
        'courses' => $courses,
    ]);
});

Route::get('/about', function () {
    return view('about', ['activeNav' => 'about']);
});

// Route untuk halaman pelatihan public (tanpa login)
Route::get('/pelatihan', [GuestCourseController::class, 'index'])->name('guest.courses');

// Rute untuk menampilkan form pendaftaran kursus (opsional pilih course)
// Memerlukan middleware untuk memastikan profil sudah lengkap
Route::get('/pendaftaran-kursus/{course?}', [CourseRegistrationController::class, 'create'])
    ->name('course.register.form')
    ->middleware('auth', 'ensureProfileCompleted');

// Rute untuk menyimpan data dari form pendaftaran kursus
Route::post('/pendaftaran-kursus', [CourseRegistrationController::class, 'store'])
    ->name('course.register.store')
    ->middleware('auth', 'ensureProfileCompleted');

// Rute untuk menampilkan form register dan login PENGGUNA
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Rute untuk memproses data register dan login PENGGUNA
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/presence', [PresenceController::class, 'store'])->name('presence.store');


// --- RUTE TERPROTEKSI (Hanya untuk pengguna yang sudah login) ---

Route::middleware('auth')->group(function () {
    
    Route::get('/courses', [CourseController::class, 'index'])->name('courses');
    
    // Halaman utama "My Courses" (Daftar semua course yang diikuti)
    Route::get('/my-courses', [MyCourseController::class, 'index'])->name('my-courses');

    // Halaman "My Certificates"
    Route::get('/my-certificates', [CertificateController::class, 'index'])->name('certificate.index');

    // Halaman FAQ
    Route::get('/faq', function () {
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
    })->name('faq');

    // Rute untuk UPLOAD tugas
    Route::post('/duty/{id}/upload', [DutyController::class, 'upload'])->name('duty.upload');

    // Rute untuk memulai, submit, dan melihat hasil ujian
    Route::get('/exams/start/{exam}', [ExamController::class, 'show'])->name('exams.show');
    Route::post('/exams/submit/{exam}', [ExamController::class, 'submit'])->name('exams.submit');
    Route::get('/exams/result/{examResult}', [ExamController::class, 'result'])->name('exams.result');

    // Rute untuk mengecek & generate sertifikat
    Route::get('/my-courses/certificate/{course}/check', [CertificateController::class, 'check'])
           ->name('certificate.check');
    Route::post('/my-courses/certificate/{course}/generate', [CertificateController::class, 'generate'])
           ->name('certificate.generate');
           

    // --- RUTE AKUN (DIPERBARUI MENGGUNAKAN ACCOUNT CONTROLLER) ---
    
    // Menampilkan Halaman Akun
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    
    // Memproses Form Update Profil (Foto & Nama)
    Route::patch('/account/profile', [AccountController::class, 'updateProfile'])
         ->name('account.updateProfile');
    
    // Memproses Form Ganti Password
    Route::patch('/account/password', [AccountController::class, 'updatePassword'])
         ->name('account.updatePassword');
         
    // --- AKHIR RUTE AKUN ---


    // Halaman "Detail Course"
    Route::get('/my-courses/{course}', [MyCourseController::class, 'show'])->name('my-courses.show');
});