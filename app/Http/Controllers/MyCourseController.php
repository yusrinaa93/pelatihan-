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
            $totalSchedules = Schedule::where('pelatihan_id', $course->id)->count();
            $totalDuties    = Duty::where('pelatihan_id', $course->id)->count();
            $totalExams     = Exam::where('pelatihan_id', $course->id)->count();

            $totalItems = $totalSchedules + $totalDuties + $totalExams;

            // 2. Hitung Materi yang SUDAH SELESAI (Presensi + Kumpul Tugas + Ujian Selesai)

            // a. Presensi (Attendance)
            $attendedCount = Attendance::where('user_id', $userId)
                ->whereHas('schedule', fn($q) => $q->where('pelatihan_id', $course->id))
                ->count();

            // b. Tugas (Submission)
            $submittedDutyCount = DutySubmission::where('user_id', $userId)
                ->whereHas('duty', fn($q) => $q->where('pelatihan_id', $course->id))
                ->count();

            // c. Ujian (ExamResult)
            $completedExamCount = ExamResult::where('user_id', $userId)
                ->whereHas('exam', fn($q) => $q->where('pelatihan_id', $course->id))
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
        }])->where('pelatihan_id', $course->id)->get();

        foreach ($schedules as $schedule) {
            $schedule->has_attended = $schedule->attendances->isNotEmpty();

            // Use accessor so it also respects manual admin overrides
            $schedule->is_presence_active = (bool) $schedule->is_presence_active;

            // Derive status for UI
            $schedule->presence_status = 'closed';

            if ($schedule->manual_presensi) {
                if ($schedule->presensi_open && ! $schedule->presensi_close) {
                    $schedule->presence_status = 'active';
                } else {
                    $schedule->presence_status = 'closed';
                }
            } elseif ($schedule->waktu_mulai && $schedule->waktu_selesai) {
                if (now()->lt($schedule->waktu_mulai)) {
                    $schedule->presence_status = 'not_started';
                } elseif (now()->between($schedule->waktu_mulai, $schedule->waktu_selesai)) {
                    $schedule->presence_status = 'active';
                } else {
                    $schedule->presence_status = 'closed';
                }
            }
        }

        // Duties + submission status for this user
        $duties = Duty::where('pelatihan_id', $course->id)->latest()->get();
        foreach ($duties as $duty) {
            $duty->submission = DutySubmission::where('user_id', $userId)
                ->where('duty_id', $duty->id)
                ->first();
            $duty->can_submit = $duty->canSubmit();
            $duty->is_deadline_passed = $duty->isDeadlinePassed();
        }

        // Exams list with question counts
        $exams = Exam::where('pelatihan_id', $course->id)->withCount('questions')->get();

        return view('my_course_detail', [
            'course' => $course,
            'schedules' => $schedules,
            'duties' => $duties,
            'exams' => $exams,
        ]);
    }
}