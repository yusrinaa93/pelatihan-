@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Exam - My Courses')

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
    <div class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Evaluasi Pembelajaran</p>
                <h1 class="text-2xl font-bold text-slate-900">Exam</h1>
                <p class="mt-2 text-sm text-slate-500">Ikuti ujian untuk mengukur pemahaman Anda terhadap materi pelatihan.</p>
            </div>
            <div class="flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                <i class="fas fa-hourglass-half"></i>
                {{ $exams->where('is_completed', false)->count() }} ujian aktif
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/70 bg-white/95 p-6 shadow-lg shadow-slate-200/60">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                    <i class="fas fa-clipboard-list"></i>
                </span>
                <h2 class="text-lg font-semibold text-slate-900">Ujian yang Tersedia</h2>
            </div>

            <div class="mt-6 space-y-4">
                @forelse($exams as $exam)
                    <article class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-slate-200 px-5 py-4 shadow-sm shadow-slate-200/60">
                        <div>
                            <h3 class="text-base font-semibold text-slate-800">{{ $exam->title }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $exam->description ?? 'Tidak ada deskripsi.' }}</p>
                            <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                {{ $exam->questions_count }} Soal
                            </p>
                        </div>
                        <div>
                            @if ($exam->is_completed)
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    <i class="fas fa-circle-check"></i>
                                    Selesai
                                </span>
                            @else
                                <a href="{{ route('exams.show', $exam->id) }}"
                                   class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-emerald-400">
                                    <i class="fas fa-play"></i>
                                    Mulai Ujian
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="rounded-2xl border border-dashed border-slate-300 px-5 py-6 text-center text-sm text-slate-400">
                        Tidak ada ujian yang tersedia saat ini.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

