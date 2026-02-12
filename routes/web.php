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

// --- RUTE PUBLIK ---

// Optimasi: Menggunakan Controller agar route bisa di-cache
Route::get('/', [GuestCourseController::class, 'home'])->name('home');
Route::get('/about', [GuestCourseController::class, 'about'])->name('about');

Route::get('/pelatihan', [GuestCourseController::class, 'index'])->name('guest.courses');

// Middleware ensureProfileCompleted
Route::get('/pendaftaran-kursus/{course?}', [CourseRegistrationController::class, 'create'])
    ->name('course.register.form')
    ->middleware(['auth', 'ensureProfileCompleted']);

Route::post('/pendaftaran-kursus', [CourseRegistrationController::class, 'store'])
    ->name('course.register.store')
    ->middleware(['auth', 'ensureProfileCompleted']);

// Auth Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/presence', [PresenceController::class, 'store'])->name('presence.store');


// --- RUTE TERPROTEKSI ---

Route::middleware('auth')->group(function () {

    Route::get('/courses', [CourseController::class, 'index'])->name('courses');

    // Optimasi: FAQ dipindahkan ke controller
    Route::get('/faq', [CourseController::class, 'faq'])->name('faq');

    Route::get('/my-courses', [MyCourseController::class, 'index'])->name('my-courses');
    Route::get('/my-certificates', [CertificateController::class, 'index'])->name('certificate.index');

    Route::post('/duty/{id}/upload', [DutyController::class, 'upload'])->name('duty.upload');

    Route::get('/exams/start/{exam}', [ExamController::class, 'show'])->name('exams.show');
    Route::post('/exams/submit/{exam}', [ExamController::class, 'submit'])->name('exams.submit');
    Route::get('/exams/result/{examResult}', [ExamController::class, 'result'])->name('exams.result');

    Route::get('/my-courses/certificate/{course}/check', [CertificateController::class, 'check'])->name('certificate.check');
    Route::post('/my-courses/certificate/{course}/generate', [CertificateController::class, 'generate'])->name('certificate.generate');

    // Akun
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::patch('/account/profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::patch('/account/password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');

    Route::get('/my-courses/{course}', [MyCourseController::class, 'show'])->name('my-courses.show');
    Route::get('/duties/{duty}/download', [DutyController::class, 'downloadAttachment'])->name('duties.download');
    Route::get('/duty-submissions/{submission}/download', [DutyController::class, 'downloadSubmission'])->name('duty-submissions.download');
});
