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

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        $filename = time() . '_' . Str::random(6) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $path = $file->storeAs("duties/{$duty->id}", $filename, 'public');

        $submission = \App\Models\DutySubmission::updateOrCreate(
            ['user_id' => $userId, 'duty_id' => $duty->id],
            ['file_path' => $path, 'original_filename' => $originalName]
        );

        // --- BAGIAN INI YANG DIUBAH ---
        // Tambahkan ->withFragment('tab-tugas') agar setelah reload langsung membuka tab tugas
        return redirect()->back()
                ->with('status', 'File uploaded successfully.')
                ->withFragment('tab-tugas');
    }
}