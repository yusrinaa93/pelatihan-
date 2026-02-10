<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseRegistrationController extends Controller
{
    /**
     * Menampilkan form pendaftaran dan mengirim data user yang login.
     */
    public function create(Request $request, $course = null)
    {
        // Ambil CSRF token dari session
        $csrfToken = $request->session()->token();
        
        // Ambil data user yang sedang login
        $user = Auth::user();
        
        // Kirim CSRF token, data user, dan daftar kursus ke view
        $courses = \App\Models\Course::all();
        return view('pendaftaran-kursus', [
            'csrf_token' => $csrfToken,
            'user' => $user,
            'selected_course_id' => $course,
            'courses' => $courses,
        ]);
    }

    /**
     * Menyimpan data pendaftaran kursus.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'pelatihan_id' => 'required|exists:pelatihan,id',
        ]);

        try {
            // 2. Jika user sudah login, tambahkan ke pendaftaran_pelatihan
            if (Auth::check()) {
                $user = Auth::user();

                \App\Models\CourseRegistration::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'pelatihan_id' => $validatedData['pelatihan_id'],
                    ],
                    []
                );
            }

            // 3. Kirim balasan sukses dalam format JSON
            return response()->json(['status' => 'success', 'message' => 'Pendaftaran berhasil!']);

        } catch (\Exception $e) {
            // 4. Jika gagal, kirim balasan error dalam format JSON
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
}