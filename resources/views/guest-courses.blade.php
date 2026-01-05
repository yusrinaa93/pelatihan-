@extends('layouts.auth')

@section('title', 'Pelatihan - Halal Center')

@section('body')
@php($activeNav = 'courses')

<div class="min-h-screen bg-slate-50">
    {{-- NAVBAR --}}
    <header class="flex w-full items-center justify-between py-6 px-8">
        <div class="flex items-center gap-3">
            <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo" class="h-10 w-10">
            <h1 class="text-xl font-bold text-emerald-600">Halal Center</h1>
        </div>
        
        <nav>
            <ul class="flex items-center gap-3 rounded-full bg-white px-3 py-2 shadow-sm text-xs font-semibold uppercase tracking-wide">
                <li>
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center rounded-full px-4 py-2 transition text-slate-700 hover:text-emerald-600">
                        BERANDA
                    </a>
                </li>
                <li>
                    <span class="inline-flex items-center rounded-full bg-emerald-600 px-4 py-2 text-white shadow-sm">
                        PELATIHAN
                    </span>
                </li>
                <li>
                    <a href="{{ url('/about') }}"
                       class="inline-flex items-center rounded-full px-4 py-2 transition text-slate-700 hover:text-emerald-600">
                        TENTANG
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center rounded-full px-4 py-2 transition text-slate-700 hover:text-emerald-600">
                        Masuk
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="px-6 py-12 sm:px-10">
        <div class="max-w-6xl mx-auto space-y-8">
            {{-- Header --}}
            <div class="text-center space-y-2">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Daftar Pelatihan</p>
                <h2 class="text-4xl font-bold text-slate-900">Pelatihan Kami</h2>
                <p class="mt-4 text-lg text-slate-600">Pelajari berbagai pelatihan tentang produk halal dari Halal Center UIN SUKA</p>
            </div>

            {{-- Course Grid --}}
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 mt-12">
                @forelse ($courses as $course)
                    @php($cover = $course->image_path ? asset('storage/'.$course->image_path) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80')
                    <article class="flex flex-col overflow-hidden rounded-3xl border border-slate-200/70 bg-white shadow-lg shadow-slate-200/60 hover:shadow-xl hover:shadow-slate-200/80 transition-all duration-300 h-full group">
                        {{-- Image Container --}}
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $cover }}" 
                                 alt="Gambar {{ $course->title }}" 
                                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-1 flex-col gap-4 p-6">
                            <div class="space-y-2 flex-1">
                                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Pelatihan</p>
                                <h3 class="text-xl font-bold text-slate-900">{{ $course->title }}</h3>
                                <p class="text-sm text-slate-600 line-clamp-3">{!! strip_tags($course->description) !!}</p>
                            </div>

                            {{-- Button Section --}}
                            <div class="flex gap-3 pt-4 border-t border-slate-200">
                                <button type="button"
                                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-200 cursor-pointer"
                                        onclick="showCourseDetail({{ $course->id }}, '{{ addslashes($course->title) }}', '{{ addslashes(strip_tags($course->description)) }}')">
                                    <i class="fas fa-info-circle"></i>
                                    Info Detail
                                </button>
                                <a href="{{ route('login') }}"
                                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400">
                                    <i class="fas fa-clipboard-check"></i>
                                    Daftar
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white/80 p-10 text-center text-slate-500">
                        <i class="fas fa-inbox text-4xl mb-4 opacity-50"></i>
                        <p>Belum ada pelatihan yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="mt-20 border-t border-slate-200 py-8 text-center text-sm text-slate-500">
        &copy; {{ date('Y') }} Halal Center UIN SUKA. All rights reserved.
    </footer>
</div>

{{-- Modal Detail Pelatihan --}}
<div id="courseModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-slate-200 px-8 py-6 flex items-center justify-between">
            <h2 id="modalTitle" class="text-2xl font-bold text-slate-900"></h2>
            <button type="button" 
                    onclick="closeCourseDetail()"
                    class="text-slate-400 hover:text-slate-600 transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <div class="px-8 py-6 space-y-4">
            <div id="modalDescription" class="text-slate-600 space-y-4 prose prose-sm max-w-none"></div>

            <div class="mt-8 flex gap-3 pt-6 border-t border-slate-200">
                <button type="button"
                        onclick="closeCourseDetail()"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-400 hover:bg-slate-50">
                    <i class="fas fa-arrow-left"></i>
                    Tutup
                </button>
                <a href="{{ route('login') }}"
                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400">
                    <i class="fas fa-clipboard-check"></i>
                    Daftar Pelatihan
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function showCourseDetail(courseId, title, description) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').innerHTML = description;
    document.getElementById('courseModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCourseDetail() {
    document.getElementById('courseModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('courseModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeCourseDetail();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCourseDetail();
    }
});
</script>
@endsection
