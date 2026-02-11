<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Duty;
use App\Models\DutySubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DutyController extends Controller
{
    public function index()
    {
        $duties = Duty::latest()->get();
        $userId = Auth::id();

        foreach ($duties as $duty) {
            $duty->submission = DutySubmission::where('user_id', $userId)
                                              ->where('duty_id', $duty->id)
                                              ->first();
        }

        return view('duty', ['duties' => $duties]);
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $userId = Auth::id();
        $duty = Duty::findOrFail($id);

        // Validasi deadline
        if ($duty->isDeadlinePassed()) {
            return redirect()->back()
                ->with('error', 'Maaf, deadline pengumpulan tugas sudah lewat.')
                ->withFragment('tab-tugas');
        }

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        $filename = time() . '_' . Str::random(6) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $path = $file->storeAs("duties/{$duty->id}", $filename, 'public');

        DutySubmission::updateOrCreate(
            ['user_id' => $userId, 'duty_id' => $duty->id],
            ['path_file' => $path, 'nama_file_asli' => $originalName]
        );

        return redirect()->back()
                // ->with('status', 'File uploaded successfully.')
                ->with('success', 'File berhasil diupload.')
                ->withFragment('tab-tugas');
    }

    /**
     * Download file tugas yang diupload admin (attachment_path).
     */
    public function downloadAttachment(Duty $duty)
    {
        // Pastikan user login (route sudah pakai auth middleware, ini sekadar aman)
        if (!Auth::check()) {
            abort(403);
        }

        if (!$duty->attachment_path || !Storage::disk('public')->exists($duty->attachment_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($duty->attachment_path);
    }

    /**
     * Download file submission user.
     */
    public function downloadSubmission(DutySubmission $submission)
    {
        // 1. Pastikan User Login
        if (!Auth::check()) {
            abort(403, 'Anda harus login.');
        }

        $user = Auth::user();

        // 2. LOGIC IZIN:
        // Izinkan jika User adalah PEMILIK file --ATAU-- User adalah ADMIN
        // Asumsi kolom admin di tabel users bernama 'is_admin' (boolean)
        if ($submission->user_id !== $user->id && !$user->is_admin) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        // 3. Cek File Fisik
        if (!$submission->path_file || !Storage::disk('public')->exists($submission->path_file)) {
            abort(404, 'File fisik tidak ditemukan di server.');
        }

        // 4. Download
        $downloadName = $submission->nama_file_asli ?: basename($submission->path_file);
        return Storage::disk('public')->download($submission->path_file, $downloadName);
    }
}
