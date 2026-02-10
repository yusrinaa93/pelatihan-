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
}
