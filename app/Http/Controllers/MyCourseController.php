<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseRegistration;
use App\Models\Pendaftar;
use App\Models\Course;
use App\Models\Duty;
use App\Models\DutySubmission;
use App\Models\Exam;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\ExamResult;

class MyCourseController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Hanya ambil kursus yang user daftar
        $registrations = CourseRegistration::with('course')
            ->where('user_id', $userId)
            ->get();

        $courses = $registrations->map(fn ($r) => $r->course)->filter()->values();

        // === LOGIKA HITUNG PROGRESS BAR ===
        foreach ($courses as $course) {
            // 1. Hitung TOTAL Materi (Jadwal + Tugas + Ujian)
            $totalSchedules = Schedule::where('course_id', $course->id)->count();
            $totalDuties    = Duty::where('course_id', $course->id)->count();
            $totalExams     = Exam::where('course_id', $course->id)->count();
            
            $totalItems = $totalSchedules + $totalDuties + $totalExams;

            // 2. Hitung Materi yang SUDAH SELESAI (Presensi + Kumpul Tugas + Ujian Selesai)
            
            // a. Presensi (Attendance)
            $attendedCount = Attendance::where('user_id', $userId)
                ->whereHas('schedule', fn($q) => $q->where('course_id', $course->id))
                ->count();

            // b. Tugas (Submission)
            $submittedDutyCount = DutySubmission::where('user_id', $userId)
                ->whereHas('duty', fn($q) => $q->where('course_id', $course->id))
                ->count();

            // c. Ujian (ExamResult)
            $completedExamCount = ExamResult::where('user_id', $userId)
                ->whereHas('exam', fn($q) => $q->where('course_id', $course->id))
                ->count();

            $completedItems = $attendedCount + $submittedDutyCount + $completedExamCount;

            // 3. Hitung Persentase
            if ($totalItems > 0) {
                // Batasi maksimal 100% agar tidak lebih (jika ada data aneh)
                $percentage = min(100, round(($completedItems / $totalItems) * 100));
            } else {
                $percentage = 0; 
            }

            // 4. Simpan data ke object course (agar bisa dibaca di View)
            $course->progress_percent = $percentage;
            $course->completed_items = $completedItems;
            $course->total_items = $totalItems;
        }

        return view('my_courses', [ 'courses' => $courses ]);
    }

    public function show(Course $course)
    {
        $userId = Auth::id();

        // Filter per course
        $schedules = Schedule::with(['attendances' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->where('course_id', $course->id)->get();

        foreach ($schedules as $schedule) {
            $schedule->is_presence_active = false;
            if ($schedule->start_time && $schedule->end_time) {
                $schedule->is_presence_active = now()->between(
                    $schedule->start_time,
                    $schedule->end_time
                );
            }
            $schedule->has_attended = $schedule->attendances->isNotEmpty();
        }

        // Duties + submission status for this user
        $duties = Duty::where('course_id', $course->id)->latest()->get();
        foreach ($duties as $duty) {
            $duty->submission = DutySubmission::where('user_id', $userId)
                ->where('duty_id', $duty->id)
                ->first();
        }

        // Exams list with question counts
        $exams = Exam::where('course_id', $course->id)->withCount('questions')->get();

        return view('my_course_detail', [
            'course' => $course,
            'schedules' => $schedules,
            'duties' => $duties,
            'exams' => $exams,
        ]);
    }
}