@php($activeSidebar = 'courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Courses - Pelatihan Halal')

@section('content')
    <div class="space-y-8 relative">
        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Daftar Pelatihan</p>
                <h1 class="text-2xl font-bold text-slate-900">Courses</h1>
                <p class="mt-2 text-sm text-slate-500">Pilih pelatihan terbaik dan mulai perjalanan belajar Anda.</p>
            </div>
        </div>

        {{-- Grid Card Kursus --}}
        <div class="grid gap-6 md:grid-cols-2">
            @forelse ($courses as $course)
                @php($cover = $course->image_path ? asset('storage/'.$course->image_path) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80')
                <article class="flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200/70 bg-white/95 shadow-lg shadow-slate-200/60">
                    <img src="{{ $cover }}" alt="Gambar Pelatihan" class="h-48 w-full object-cover">
                    <div class="flex flex-1 flex-col gap-4 p-6">
                        <div class="space-y-2">
                            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Pelatihan Pendamping</p>
                            <h2 class="text-xl font-bold text-slate-900">{{ $course->title }}</h2>
                        </div>
                        <div class="prose prose-sm max-w-none text-slate-600">{!! $course->description !!}</div>
                        <div class="mt-auto">
                            @if (isset($registeredCourseIds) && $registeredCourseIds->contains($course->id))
                                <span class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-slate-500">
                                    <i class="fas fa-circle-check text-emerald-500"></i>
                                    Anda sudah terdaftar
                                </span>
                            @else
                                <a href="{{ route('course.register.form', ['course' => $course->id]) }}"
                                   class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400">
                                    <i class="fas fa-clipboard-check"></i>
                                    Register Course
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
    </div>

    {{-- MODAL NOTIFIKASI SUKSES DENGAN BLUR --}}
    @if(session('success'))
        <div id="successModal" 
             class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-900/40 px-4 backdrop-blur-sm transition-opacity duration-300">
            
            {{-- Card Modal --}}
            <div class="relative w-full max-w-md transform overflow-hidden rounded-3xl bg-white p-6 text-center shadow-2xl shadow-emerald-500/20 ring-1 ring-slate-900/5 transition-all duration-300 scale-100">
                
                {{-- Icon Sukses Animasi --}}
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-50 ring-4 ring-emerald-100">
                    <i class="fas fa-check text-4xl text-emerald-500 animate-pulse"></i>
                </div>

                {{-- Text --}}
                <h3 class="mb-2 text-2xl font-bold text-slate-900">Berhasil Terdaftar!</h3>
                <p class="text-slate-500 mb-8">
                    {{ session('success') }}
                </p>

                {{-- Tombol Tutup --}}
                <button type="button" onclick="closeSuccessModal()" 
                        class="w-full rounded-full bg-emerald-500 px-5 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-400 hover:shadow-emerald-500/50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Lihat Materi
                </button>
            </div>
        </div>

        {{-- Script Khusus Modal --}}
        <script>
            function closeSuccessModal() {
                const modal = document.getElementById('successModal');
                // Efek fade out sebelum menghapus
                modal.style.opacity = '0';
                modal.style.pointerEvents = 'none';
                setTimeout(() => {
                    modal.remove();
                }, 300); // Sesuaikan dengan duration transition css
            }

            // Opsional: Tutup jika klik di luar card (area blur)
            document.getElementById('successModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSuccessModal();
                }
            });
        </script>
    @endif

@endsection