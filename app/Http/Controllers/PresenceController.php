<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Schedule; // <-- Penting: Jangan lupa import ini
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    /**
     * Menyimpan data presensi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        // 1. Ambil data jadwal berdasarkan ID
        $schedule = Schedule::findOrFail($request->schedule_id);

        // 2. VALIDASI WAKTU KETAT
        // Jika sekarang bukan waktunya (belum mulai atau sudah lewat), tolak!
        if (! $schedule->is_presence_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal! Waktu presensi sudah ditutup atau belum dimulai.'
            ], 422); // 422 Unprocessable Entity
        }

        // 3. Simpan Presensi (gunakan firstOrCreate untuk cegah duplikat)
        $attendance = Attendance::firstOrCreate([
            'user_id' => Auth::id(),
            'schedule_id' => $request->schedule_id,
        ]);

        // 4. Beri respon berdasarkan apakah data baru dibuat atau tidak
        if ($attendance->wasRecentlyCreated) {
            return response()->json([
                'status' => 'success', 
                'message' => 'Presensi berhasil dicatat!'
            ]);
        } else {
            return response()->json([
                'status' => 'warning', 
                'message' => 'Anda sudah melakukan presensi sebelumnya.'
            ]);
        }
    }
}