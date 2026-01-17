@extends('layouts.public')

@section('title', 'Pelatihan - Halal Center')

@section('content')
@php($activeNav = 'courses')

{{-- Header Section --}}
<section class="relative flex min-h-[15vh] items-center justify-center bg-white py-8">
    <div class="relative z-10 mx-auto max-w-4xl px-4 text-center text-slate-900">
        <h1 class="mb-4 text-4xl font-bold leading-tight sm:text-5xl">
            Pelatihan Kami
        </h1>
        <p class="text-lg leading-relaxed text-slate-600">
            Pelajari berbagai pelatihan tentang produk halal dari Halal Center UIN SUKA
        </p>
    </div>
</section>

{{-- Course Section --}}
<div class="max-w-7xl mx-auto space-y-8 px-4 pb-12">
        {{-- Course Grid --}}
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($courses as $course)
                    @php($cover = $course->image_path ? asset('storage/'.$course->image_path) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80')
                    <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-200/70 bg-white shadow-md hover:shadow-xl transition-all duration-300 h-full group">
                        {{-- Image Container --}}
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100">
                            <img src="{{ $cover }}" 
                                 alt="Gambar {{ $course->title }}" 
                                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-1 flex-col gap-4 p-5">
                            {{-- Breadcrumb --}}
                            <div class="text-xs text-slate-500">
                                <p class="text-emerald-600 font-semibold">Pelatihan</p>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-lg font-bold text-slate-900 line-clamp-2">{{ $course->title }}</h3>

                            {{-- Description --}}
                            <p class="text-sm text-slate-600 line-clamp-3 flex-1">
                                {{ $course->short_description ? strip_tags($course->short_description) : strip_tags($course->description) }}
                            </p>

                            {{-- Button Section --}}
                            <div class="flex gap-2 pt-4 mt-auto">
                                <button type="button"
                                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-full border border-emerald-600 text-emerald-600 px-3 py-2.5 text-sm font-semibold transition hover:bg-emerald-50 cursor-pointer"
                                        onclick="showCourseDetail({{ $course->id }}, '{{ addslashes($course->title) }}', '{{ addslashes($course->description) }}')">
                                    <span>Info Detail</span>
                                </button>
                                <a href="{{ route('login') }}"
                                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 text-white px-3 py-2.5 text-sm font-semibold shadow-lg shadow-emerald-600/30 transition hover:bg-emerald-700">
                                    <span>Daftar</span>
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
    {{-- removed stray extra closing div --}}

{{-- Modal Detail Pelatihan --}}
<div id="courseModal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6 bg-black/50" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="w-full max-w-3xl sm:max-w-4xl bg-white rounded-2xl sm:rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="shrink-0 bg-white border-b border-slate-200 px-6 sm:px-8 py-5 flex items-center justify-between">
            <div>
                <p class="text-sm text-emerald-600 font-semibold mb-1">Pelatihan Halal</p>
                <h2 id="modalTitle" class="text-2xl sm:text-3xl font-bold text-slate-900"></h2>
            </div>
            <button type="button" onclick="closeCourseDetail()" class="text-slate-400 hover:text-slate-600 transition p-2" aria-label="Tutup dialog">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body (scrollable) -->
        <div class="flex-1 overflow-y-auto overscroll-contain px-6 sm:px-8 py-6 space-y-6">
            {{-- Info Stats --}}
            <div class="flex items-center gap-6 text-sm text-slate-600 pb-4 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <i class="fas fa-clock text-emerald-600"></i>
                    <span><strong>10 Jam</strong> Belajar</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-users text-emerald-600"></i>
                    <span><strong>200+</strong> Siswa</span>
                </div>
            </div>

            {{-- Description --}}
            <div id="modalDescription" class="text-slate-600 space-y-4 prose prose-sm max-w-none text-base leading-relaxed"></div>

            {{-- Tags --}}
            <div class="flex flex-wrap gap-2 pt-4 border-t border-slate-200">
                <span class="inline-flex items-center rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-600 border border-emerald-200">
                    Pelatihan Halal
                </span>
                <span class="inline-flex items-center rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 border border-blue-200">
                    Learning Path
                </span>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="shrink-0 flex gap-3 px-6 sm:px-8 py-4 border-t border-slate-200 bg-white">
            <button type="button" onclick="closeCourseDetail()" class="flex-1 inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-400 hover:bg-slate-50">
                <i class="fas fa-arrow-left"></i>
                Tutup
            </button>
            <a href="{{ route('login') }}" class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 text-white px-6 py-3 text-sm font-semibold shadow-lg shadow-emerald-600/40 transition hover:bg-emerald-700">
                <i class="fas fa-arrow-right"></i>
                Daftar Pelatihan
            </a>
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
(function() {
    const overlay = document.getElementById('courseModal');
    overlay?.addEventListener('click', function(e) {
        if (e.target === this) closeCourseDetail();
    });
})();
// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeCourseDetail();
});
</script>
@endsection
