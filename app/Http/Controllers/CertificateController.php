<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\ExamResult;
use App\Models\DutySubmission;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Pendaftar;
use App\Models\CourseRegistration; // [PENTING] Tambahkan model ini
use Carbon\Carbon;

class CertificateController extends Controller
{
    /**
     * 1. Menampilkan Halaman DAFTAR PELATIHAN (Hanya yang diikuti User)
     */
    public function index()
    {
        $user = Auth::user();
        $registered_courses = collect(); // Inisialisasi koleksi kosong

        if ($user) {
            // PERBAIKAN: Ambil kursus hanya dari tabel CourseRegistration milik user
            $registrations = CourseRegistration::with('course')
                ->where('user_id', $user->id)
                ->get();

            // Ekstrak data 'course' dari setiap pendaftaran
            $registered_courses = $registrations->map(function ($registration) {
                return $registration->course;
            });
        }

        return view('certificate.index', [
            'courses' => $registered_courses
        ]);
    }

    /**
     * 2. MENGECEK SYARAT KELULUSAN
     */
    public function check(Course $course)
    {
        $user = Auth::user();
        $pendaftarData = User::where('email', $user->email)->first();

        // Cek apakah Admin sudah "meluncurkan" sertifikat
        if (!$course->is_certificate_active) {
            return view('certificate.gagal', ['reasons' => ['Sertifikat untuk pelatihan ini belum diluncurkan oleh Admin.']]);
        }

        // Hitung kelayakan untuk course ini
        $examScore = ExamResult::where('user_id', $user->id)
            ->whereHas('exam', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->avg('score') ?? 0;

        $dutyScore = DutySubmission::where('user_id', $user->id)
            ->whereNotNull('score')
            ->whereHas('duty', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->avg('score') ?? 0;

        $attendanceCount = Attendance::where('user_id', $user->id)
            ->whereHas('schedule', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->count();

        // Kriteria lulus: exam >= 50, duty >= 50, presensi >= 3
        $syaratGagal = [];
        $examDisp = number_format((float) $examScore, 0);
        $dutyDisp = number_format((float) $dutyScore, 0);

        if ($examScore < 50) {
            $syaratGagal[] = "Nilai ujian minimum 50 (Nilai Anda: $examDisp)";
        }
        if ($dutyScore < 50) {
            $syaratGagal[] = "Nilai tugas minimum 50 (Nilai Anda: $dutyDisp)";
        }
        if ($attendanceCount < 3) {
            $syaratGagal[] = "Presensi minimum 3 kali (Presensi Anda: $attendanceCount)";
        }

        if (!empty($syaratGagal)) {
            return view('certificate.gagal', ['reasons' => $syaratGagal]);
        }

        // Jika memenuhi syarat, tampilkan form
        $existingCertificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        return view('certificate.form', [
            'user' => $user,
            'course' => $course,
            'pendaftarData' => $pendaftarData,
            'existingData' => $existingCertificate,
        ]);
    }

    /**
     * 3. MEMBUAT DAN MENGUNDUH PDF
     */
    public function generate(Request $request, Course $course)
    {
        $user = Auth::user();

        // --- 1. Recheck eligibility (Keamanan Server-side) ---
        $examScore = ExamResult::where('user_id', $user->id)
            ->whereHas('exam', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->avg('score') ?? 0;

        $dutyScore = DutySubmission::where('user_id', $user->id)
            ->whereNotNull('score')
            ->whereHas('duty', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->avg('score') ?? 0;

        $attendanceCount = Attendance::where('user_id', $user->id)
            ->whereHas('schedule', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->count();

        if ($examScore < 50 || $dutyScore < 50 || $attendanceCount < 3) {
            return redirect()->route('certificate.index')
                ->withErrors(['msg' => 'Anda tidak memenuhi syarat kelulusan.']);
        }

        // --- 2. VALIDASI DATA (KEY DISESUAIKAN DENGAN FORM) ---
        $validatedData = $request->validate([
            'nama'          => 'required|string|max:255', // Sesuai name="nama" di form
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'nomor_wa'      => 'required|string|max:25',  // Sesuai name="nomor_wa" di form
            'bank_name' => 'required|string|max:100',
            'bank_account_name' => 'required|string|max:150',
            'bank_account_number' => 'required|string|max:50',
        ]);

        // Simpan data bank ke profil user (wajib untuk yang lulus)
        $user->forceFill([
            'bank_name' => $validatedData['bank_name'],
            'bank_account_name' => $validatedData['bank_account_name'],
            'bank_account_number' => $validatedData['bank_account_number'],
        ])->save();

        // --- 3. Buat Nomor Sertifikat ---
        $serial_number = $this->generateSerialNumber($course, $user); 

        // --- 4. SIMPAN DATA KE DATABASE ---
        $certificate = Certificate::updateOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'title' => $course->title,
                'serial_number' => $serial_number,
                'name_on_certificate' => $validatedData['nama'], 
                'ttl_on_certificate'  => $validatedData['tempat_lahir'] . ', ' . Carbon::parse($validatedData['tanggal_lahir'])->format('d-m-Y'),
                'phone_on_certificate'=> $validatedData['nomor_wa'],
            ]
        );

        // --- 5. Siapkan Data untuk PDF ---
        $data = [
            'nama' => $certificate->name_on_certificate,
            'tempat_tanggal_lahir' => $certificate->ttl_on_certificate,
            'no_hp' => $certificate->phone_on_certificate,
            'serial_number' => $certificate->serial_number
        ];

        // --- 6. Generate PDF ---
        $pdf = Pdf::loadView('certificate.template', $data);
        $pdf->setPaper('letter', 'portrait');

        return $pdf->download('Sertifikat-PPH-' . str_replace(' ', '-', $user->name) . '.pdf');
    }

    /**
     * Helper function untuk membuat nomor seri unik
     */
    private function generateSerialNumber(Course $course, User $user)
    {
        $existing = Certificate::where('user_id', $user->id)
                               ->where('course_id', $course->id)
                               ->first();
        
        if ($existing && $existing->serial_number) {
            return $existing->serial_number;
        }

        $prefix = "D-13/PPH/IX/2023";
        $user_id_padded = str_pad($user->id, 4, '0', STR_PAD_LEFT); 
        $course_id_padded = str_pad($course->id, 2, '0', STR_PAD_LEFT);

        return $prefix . '/' . $course_id_padded . '/' . $user_id_padded;
    }
}