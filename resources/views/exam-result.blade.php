@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Hasil Ujian - ' . $result->exam->title)

@section('sidebar-extra')
    <li>
        <a href="{{ route('duty') }}"
           class="group flex items-center gap-3 rounded-xl px-4 py-3 transition text-white/80 hover:bg-white/10">
            <i class="fas fa-tasks text-base"></i>
            <span>Duty</span>
        </a>
    </li>
    <li>
        <a href="{{ route('exam') }}"
           class="group flex items-center gap-3 rounded-xl px-4 py-3 transition bg-white text-emerald-600 shadow-lg shadow-emerald-900/20">
            <i class="fas fa-pencil-alt text-base"></i>
            <span>Exam</span>
        </a>
    </li>
    <li>
        <a href="{{ route('certificate') }}"
           class="group flex items-center gap-3 rounded-xl px-4 py-3 transition text-white/80 hover:bg-white/10">
            <i class="fas fa-certificate text-base"></i>
            <span>Certificate</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="flex flex-col items-center justify-center gap-6 text-center">
        <div class="space-y-3">
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Hasil Ujian</p>
            <h1 class="text-3xl font-bold text-slate-900">{{ $result->exam->title }}</h1>
            <p class="text-sm text-slate-500">Terima kasih telah menyelesaikan ujian ini. Berikut skor yang Anda peroleh.</p>
        </div>

        <div class="flex h-48 w-48 items-center justify-center rounded-full border-8 border-emerald-100 bg-emerald-500/10 shadow-lg shadow-emerald-200">
            <span class="text-5xl font-bold text-emerald-600">{{ $result->score }}</span>
        </div>

        <a href="{{ route('my-courses.show', $result->exam->course_id) }}#tab-ujian"
           class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Materi Pelatihan
        </a>
    </div>
@endsection

