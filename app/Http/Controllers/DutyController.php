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

        // --- BAGIAN INI YANG DIUBAH ---
        // Tambahkan ->withFragment('tab-tugas') agar setelah reload langsung membuka tab tugas
        return redirect()->back()
                ->with('status', 'File uploaded successfully.')
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
        if (!Auth::check()) {
            abort(403);
        }

        // Hanya pemilik submission yang boleh download
        if ((int) $submission->user_id !== (int) Auth::id()) {
            abort(403);
        }

        if (!$submission->file_path || !Storage::disk('public')->exists($submission->file_path)) {
            abort(404);
        }

        $downloadName = $submission->original_filename ?: basename($submission->file_path);

        return Storage::disk('public')->download($submission->file_path, $downloadName);
    }
}