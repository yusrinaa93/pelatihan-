@php($activeSidebar = 'courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Courses - Pelatihan Halal')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Daftar Pelatihan</p>
                <h1 class="text-2xl font-bold text-slate-900">Pelatihan</h1>
                <p class="mt-2 text-sm text-slate-500">Pilih dan Daftar pelatihan terbaik.</p>
            </div>
        </div>

        {{-- Warning jika profil belum lengkap --}}
        @if (Auth::check() && !Auth::user()->profile_completed)
            <div class="rounded-2xl border border-amber-200 bg-amber-50/80 px-4 py-3 text-sm text-amber-700">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>Perhatian!</strong> Silakan
                <a href="{{ route('account') }}" class="font-semibold underline hover:text-amber-900">lengkapi profil Anda</a>
                terlebih dahulu sebelum mendaftar pelatihan.
            </div>
        @endif

        {{-- Grid Pelatihan --}}
        <div class="grid gap-6 md:grid-cols-2">
            @forelse ($courses as $course)
                @php($cover = $course->path_gambar ? \Illuminate\Support\Facades\Storage::disk('public')->url($course->path_gambar) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80')

                <article class="flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200/70 bg-white/95 shadow-lg shadow-slate-200/60 transition hover:shadow-xl">
                    <img src="{{ $cover }}" alt="Gambar Pelatihan" class="h-48 w-full object-cover">
                    <div class="flex flex-1 flex-col gap-4 p-6">
                        <div class="space-y-2">
                            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Pelatihan Pendamping Produk Halal</p>
                            <h2 class="text-xl font-bold text-slate-900">{{ $course->title }}</h2>

                            @if($course->end_date)
                                <div class="mt-2 flex items-center gap-2 text-xs font-medium text-slate-500">
                                    <i class="fas fa-calendar-alt text-emerald-500"></i>
                                    <span>
                                        Batas Daftar: {{ \Carbon\Carbon::parse($course->end_date)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Deskripsi --}}
                        <div class="prose prose-sm max-w-none text-slate-600 line-clamp-3">
                            {!! $course->short_description ? $course->short_description : $course->description !!}
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-auto pt-4">
                            @if (isset($registeredCourseIds) && $registeredCourseIds->contains($course->id))
                                <span class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-slate-500">
                                    <i class="fas fa-circle-check text-emerald-500"></i>
                                    Anda sudah terdaftar
                                </span>
                            @elseif ($course->registration_ended)
                                <button type="button"
                                        disabled
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-rose-100 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-rose-600 cursor-not-allowed">
                                    <i class="fas fa-ban"></i>
                                    Pendaftaran telah berakhir
                                </button>
                            @elseif (Auth::check() && !Auth::user()->profile_completed)
                                <button type="button"
                                        disabled
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-200 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-slate-400 cursor-not-allowed"
                                        title="Lengkapi profil terlebih dahulu">
                                    <i class="fas fa-lock"></i>
                                    Lengkapi Profil Dulu
                                </button>
                            @else
                                <a href="{{ route('course.register.form', ['course' => $course->id]) }}"
                                   class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400">
                                    <i class="fas fa-clipboard-check"></i>
                                    Daftar Pelatihan
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white/80 p-10 text-center text-sm text-slate-500">
                    Belum ada kursus yang tersedia saat ini.
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $courses->links() }}
        </div>

    </div>
@endsection
