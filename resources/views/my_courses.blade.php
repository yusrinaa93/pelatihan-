@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'My Courses - Pelatihan Halal')

@section('content')
    <div class="space-y-8">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Progress Belajar</p>
            <h1 class="text-2xl font-bold text-slate-900">My Courses</h1>
            <p class="mt-2 text-sm text-slate-500">Lanjutkan perjalanan belajar Anda pada kursus yang sudah terdaftar.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @forelse ($courses as $course)
                <article class="flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200/70 bg-white/95 shadow-lg shadow-slate-200/60">
                    <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80" alt="Course Image" class="h-48 w-full object-cover">
                    <div class="flex flex-1 flex-col gap-5 p-6">
                        <div class="space-y-2">
                            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Pelatihan Pendamping</p>
                            <h2 class="text-xl font-bold text-slate-900">{{ $course->title }}</h2>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wide text-slate-400">
                                <span>Progress</span>
                                <span>0%</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full w-0 bg-emerald-500"></div>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('my-courses.show', $course->id) }}"
                               class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400">
                                <i class="fas fa-play-circle"></i>
                                Lanjutkan Belajar
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white/80 p-10 text-center text-sm text-slate-500">
                    Belum ada kursus yang Anda ambil.
                </div>
            @endforelse
        </div>
    </div>
@endsection