@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'My Courses - Pelatihan Halal')

@section('content')
    <div class="space-y-8">
        {{-- Header --}}
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Progress Belajar</p>
            <h1 class="text-2xl font-bold text-slate-900">Pelatihan Saya</h1>
            <p class="mt-2 text-sm text-slate-500">Lanjutkan pelatihan anda yang sudah terdaftar.</p>
        </div>

        {{-- Grid Card --}}
        <div class="grid gap-6 md:grid-cols-2">
            @forelse ($courses as $course)
                <article class="flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200/70 bg-white/95 shadow-lg shadow-slate-200/60 transition-shadow hover:shadow-xl">
                    
                    {{-- Gambar Cover --}}
                    @php($cover = $course->image_path ? asset('storage/'.$course->image_path) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80')
                    <img src="{{ $cover }}" alt="{{ $course->title }}" class="h-48 w-full object-cover">
                    
                    <div class="flex flex-1 flex-col gap-5 p-6">
                        <div class="space-y-2">
                            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Pelatihan Pendamping Produk Halal</p>
                            <h2 class="text-xl font-bold text-slate-900 line-clamp-2" title="{{ $course->title }}">
                                {{ $course->title }}
                            </h2>
                        </div>

                        {{-- === BAGIAN PROGRESS BAR (SUDAH DIPERBAIKI) === --}}
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wide text-slate-500">
                                <span>Progress</span>
                                {{-- Menggunakan ?? 0 agar tidak error jika null --}}
                                <span class="text-emerald-600">{{ $course->progress_percent ?? 0 }}%</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                                {{-- Style width dinamis --}}
                                <div class="h-full bg-emerald-500 transition-all duration-1000 ease-out" 
                                     style="width: {{ $course->progress_percent ?? 0 }}%">
                                </div>
                            </div>
                    
                        </div>

                        <div class="mt-auto pt-2">
                            <a href="{{ route('my-courses.show', $course->id) }}"
                               class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 hover:shadow-emerald-500/50">
                                <i class="fas fa-play-circle"></i>
                                Lanjutkan Pelatihan
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center gap-4 rounded-3xl border border-dashed border-slate-300 bg-white/50 p-12 text-center">
                    <div class="rounded-full bg-slate-100 p-4 text-slate-400">
                        <i class="fas fa-book-open text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Belum ada Pelatihan</h3>
                        <p class="text-sm text-slate-500">Anda belum mendaftar di pelatihan manapun.</p>
                    </div>
                    <a href="{{ route('courses') }}" class="inline-flex items-center gap-2 rounded-full bg-white border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-emerald-600">
                        Cari pelatihan
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection