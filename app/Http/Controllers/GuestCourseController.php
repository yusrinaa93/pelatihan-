<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class GuestCourseController extends Controller
{
    /**
     * Menampilkan halaman daftar pelatihan untuk user yang belum login (guest)
     */
    public function index()
    {
        $courses = Course::all();

        return view('guest-courses', [
            'activeNav' => 'courses',
            'courses' => $courses,
        ]);
    }

    // ... method index yang sudah ada biarkan saja ...

    /**
     * Menampilkan Halaman Utama (Home).
     * Dipindahkan dari web.php
     */
    public function home()
    {
        // Mengambil 6 kursus terbaru untuk ditampilkan di beranda
        $courses = \App\Models\Course::latest()->take(6)->get();

        return view('home', [
            'activeNav' => 'home',
            'courses' => $courses,
        ]);
    }
    /**
     * Menampilkan Halaman About.
     */
    public function about()
    {
        return view('about', ['activeNav' => 'about']);
    }
}
