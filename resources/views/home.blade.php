@php($activeNav = 'home')
@extends('layouts.public')

@section('title', 'Pelatihan Pendamping Penyelia Halal')

@section('content')

{{-- ================================================= --}}
{{-- 1. HERO SECTION --}}
{{-- ================================================= --}}
<section class="relative flex min-h-[88vh] items-center justify-center bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('{{ asset('gambar/fotohomepage.png') }}');">
    <div class="relative z-10 mx-auto max-w-4xl px-4 text-center text-white">
        <h1 class="mb-4 text-5xl font-bold leading-tight">
            Pelatihan Pendamping Produk Halal
        </h1>
        <p class="mb-8 text-base leading-relaxed text-white/90">
            Pelatihan Pendamping dan Pelatihan Penyelia Bagi Calon Penggiat Halal untuk memahami dan mendampingi pelaku usaha dalam memenuhi persyaratan sertifikasi halal.
        </p>

        <a href="{{ route('guest.courses') }}"
           class="inline-block rounded-full border-2 border-emerald-600 bg-emerald-600 px-8 py-4 text-base font-semibold text-white transition hover:bg-emerald-700">
            DAFTAR PELATIHAN
        </a>
    </div>
</section>

{{-- ================================================= --}}
{{-- 2. COURSE SECTION (PELATIHAN) --}}
{{-- ================================================= --}}
<section class="bg-[#F7F9F7] py-16">
    <div class="mx-auto w-full max-w-6xl px-4">
        {{-- Course Section Header --}}
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-emerald-700">
                    Pelatihan
                </span>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">Pelatihan Kami</h2>
            </div>

            <div class="shrink-0">
                @auth
                    <a href="{{ route('courses') }}" class="inline-flex items-center gap-2 text-md font-semibold text-emerald-600 underline transition hover:text-emerald-800">
                        Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                @else
                    <a href="{{ route('guest.courses') }}" class="inline-flex items-center gap-2 text-md font-semibold text-emerald-600 underline transition hover:text-emerald-800">
                        Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                @endauth
            </div>
        </div>

        {{-- Course Grid --}}
        <div class="max-w-7xl mx-auto space-y-8 pb-12">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
                @forelse ($courses as $course)
                    @php($cover = $course->path_gambar ? \Illuminate\Support\Facades\Storage::disk('public')->url($course->path_gambar) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80')
                    <a href="{{ route('guest.courses') }}" class="block h-full">
                        <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-200/70 bg-white shadow-md hover:shadow-xl transition-all duration-300 h-full group">
                            {{-- Image Container --}}
                            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100">
                                <img src="{{ $cover }}" alt="Gambar {{ $course->judul }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                            </div>
                            {{-- Content --}}
                            <div class="flex flex-1 flex-col gap-4 p-5">
                                <div class="text-xs text-slate-500">
                                    <p class="text-emerald-600 font-semibold">Pelatihan</p>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 line-clamp-2">{{ $course->judul }}</h3>

                                {{-- Samakan dengan halaman pelatihan: gunakan end_date / tanggal_selesai --}}
                                <div class="text-xs">
                                    @if($course->end_date)
                                        <div class="mt-2 flex items-center gap-2 text-xs font-medium text-slate-500">
                                            <i class="fas fa-calendar-alt text-emerald-500"></i>
                                            <span>
                                                Batas Daftar: {{ \Carbon\Carbon::parse($course->end_date)->translatedFormat('d F Y') }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="mt-2 flex items-center gap-2 text-xs font-medium text-slate-500">
                                            <i class="fas fa-calendar-alt text-slate-400"></i>
                                            <span>Batas Daftar: -</span>
                                        </div>
                                    @endif
                                </div>

                                <p class="text-sm text-slate-600 max-h-20 overflow-y-auto pr-2 hide-scrollbar">
                                    {{ $course->deskripsi_singkat ? strip_tags($course->deskripsi_singkat) : strip_tags($course->deskripsi) }}
                                </p>
                            </div>
                        </article>
                    </a>
                @empty
                    <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white/80 p-10 text-center text-slate-500">
                        <i class="fas fa-inbox text-4xl mb-4 opacity-50"></i>
                        <p>Belum ada pelatihan yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Modal Detail Pelatihan --}}
        <div id="courseModal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6 bg-black/50" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="w-full max-w-3xl sm:max-w-4xl bg-white rounded-2xl sm:rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden">
                <div class="shrink-0 bg-white border-b border-slate-200 px-6 sm:px-8 py-5 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-emerald-600 font-semibold mb-1">Pelatihan Halal</p>
                        <h2 id="modalTitle" class="text-2xl sm:text-3xl font-bold text-slate-900"></h2>
                    </div>
                    <button type="button" onclick="closeCourseDetail()" class="text-slate-400 hover:text-slate-600 transition p-2" aria-label="Tutup dialog">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto overscroll-contain px-6 sm:px-8 py-6 space-y-6">
                    <div id="modalDescription" class="text-slate-600 space-y-4 prose prose-sm max-w-none text-base leading-relaxed"></div>
                </div>
                <div class="shrink-0 flex gap-3 px-6 sm:px-8 py-4 border-t border-slate-200 bg-white">
                    <button type="button" onclick="closeCourseDetail()" class="flex-1 inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-400 hover:bg-slate-50">Tutup</button>
                    <a href="{{ route('login') }}" class="flex-1 inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 text-white px-6 py-3 text-sm font-semibold shadow-lg shadow-emerald-600/40 transition hover:bg-emerald-700">Daftar Pelatihan</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================= --}}
{{-- 3. CONTACT SECTION (KONTAK & MAP) --}}
{{-- ================================================= --}}
<section class="bg-gradient-to-b from-emerald-50 via-emerald-50/40 to-white py-20">
    <div class="mx-auto w-full max-w-6xl px-4">

        {{-- Header Section --}}
        <div class="text-center mb-10">
            <span class="rounded-full bg-emerald-100 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-emerald-700">Contact Us</span>
            <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900">Hubungi Kami</h2>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            {{-- KOLOM KIRI: Grid Kartu Informasi (2 Baris x 2 Kolom) --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 h-full content-start">

                {{-- Address --}}
                <a href="#map-section" class="h-full">
                    <div class="group h-full rounded-xl border border-emerald-100 bg-white p-6 text-center shadow-md transition hover:-translate-y-1 hover:shadow-xl flex flex-col items-center justify-center">
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <h3 class="mb-1 text-base font-bold text-slate-900">Alamat</h3>
                        <p class="text-sm text-slate-600">Papringan, Caturtunggal, Depok, Sleman</p>
                    </div>
                </a>

                {{-- Contact --}}
                <a href="https://wa.me/6289504440443" target="_blank" class="h-full">
                    <div class="group h-full rounded-xl border border-emerald-100 bg-white p-6 text-center shadow-md transition hover:-translate-y-1 hover:shadow-xl flex flex-col items-center justify-center">
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">
                            <i class="fas fa-phone-alt text-xl"></i>
                        </div>
                        <h3 class="mb-1 text-base font-bold text-slate-900">Kontak</h3>
                        <p class="text-sm text-slate-600">089504440443</p>
                    </div>
                </a>

                {{-- Email --}}
                <a href="mailto:kontak@pelatihanhalal.com" class="h-full">
                    <div class="group h-full rounded-xl border border-emerald-100 bg-white p-6 text-center shadow-md transition hover:-translate-y-1 hover:shadow-xl flex flex-col items-center justify-center">
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <h3 class="mb-1 text-base font-bold text-slate-900">Email</h3>
                        <p class="text-sm text-slate-600 truncate w-full">kontak@pelatihanhalal.com</p>
                    </div>
                </a>

                {{-- Instagram --}}
                <a href="https://www.instagram.com/halalcenter.uinsk" class="h-full">
                    <div class="group h-full rounded-xl border border-emerald-100 bg-white p-6 text-center shadow-md transition hover:-translate-y-1 hover:shadow-xl flex flex-col items-center justify-center">
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">
                            <i class="fab fa-instagram text-xl"></i>
                        </div>
                        <h3 class="mb-1 text-base font-bold text-slate-900">Instagram</h3>
                        <p class="text-sm text-slate-600">@halalcenter.uinsk</p>
                    </div>
                </a>
            </div>

            {{-- KOLOM KANAN: Peta --}}
            <div id="map-section" class="h-full min-h-[300px] w-full rounded-2xl border border-emerald-100 bg-white p-2 shadow-lg">
                <iframe
                    src="https://maps.google.com/maps?q=Halal%20Center%20UIN%20Sunan%20Kalijaga&t=&z=15&ie=UTF8&iwloc=&output=embed"
                    width="100%"
                    height="100%"
                    style="border:0; border-radius: 12px; min-height: 100%;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

@endsection
