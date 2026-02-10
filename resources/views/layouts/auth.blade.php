@extends('layouts.base')

@section('body')
@php($activeNav = $activeNav ?? '')

{{-- CONTAINER UTAMA: Grid Split --}}
<div class="flex min-h-screen flex-col bg-slate-50 lg:grid lg:grid-cols-[45%_55%]">

    {{-- BAGIAN KIRI: GAMBAR (Hanya muncul di Desktop 'lg:block') --}}
    <div class="relative hidden h-full overflow-hidden lg:block">
        <img src="{{ asset('gambar/fotologin.png') }}"
             alt="Pelatihan Halal"
             class="absolute inset-0 h-full w-full object-cover transition-transform duration-1000 hover:scale-105">
        <div class="absolute inset-0 bg-emerald-900/60 mix-blend-multiply"></div>

        {{-- Hiasan Teks di atas gambar (Opsional, agar tidak kosong) --}}
        <div class="absolute bottom-0 left-0 p-12 text-white">
            <h2 class="text-3xl font-bold">Halal Center UIN SUKA</h2>
            <p class="mt-2 text-emerald-100">Platform Pelatihan Penyelia Halal Terpercaya.</p>
        </div>
    </div>

    {{-- BAGIAN KANAN: KONTEN & NAVBAR --}}
    <div class="flex flex-col relative w-full bg-slate-50 transition-all">

        {{-- === HEADER === --}}
        <header class="relative z-20 w-full px-6 py-6 lg:pr-10 lg:pt-8">
            <div class="flex items-center justify-between lg:justify-end">

                {{-- Logo Mobile (Hanya muncul di HP agar user tahu ini web apa) --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2 lg:hidden">
                    <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo" class="h-10 w-auto">
                    <span class="text-xs font-bold uppercase tracking-wide text-slate-700">Halal Center</span>
                </a>

                {{-- TOMBOL HAMBURGER (Mobile Only) --}}
                <button id="auth-menu-btn" class="block rounded-md p-2 text-slate-600 hover:bg-slate-200 focus:outline-none lg:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                {{-- NAVIGASI DESKTOP (Hidden di Mobile, Flex di LG) --}}
                <nav class="hidden lg:block">
                    <ul class="flex items-center gap-3 rounded-full bg-white px-3 py-2 shadow-sm text-xs font-semibold uppercase tracking-wide border border-slate-100">
                        <li>
                            <a href="{{ url('/') }}"
                               class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'home' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses') }}"
                               class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'courses' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                                Pelatihan
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}"
                               class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'about' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                                Tentang
                            </a>
                        </li>
                        <li>
                            @if(request()->routeIs('login') || request()->routeIs('register'))
                                <span class="inline-flex items-center rounded-full bg-emerald-600 px-4 py-2 text-white shadow-sm cursor-default">
                                    {{ request()->routeIs('register') ? 'Daftar' : 'Masuk' }}
                                </span>
                            @else
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center rounded-full px-4 py-2 transition text-slate-700 hover:text-emerald-600">
                                    Masuk
                                </a>
                            @endif
                        </li>
                    </ul>
                </nav>
            </div>

            {{-- MENU MOBILE (Slide Down) --}}
            <div id="auth-mobile-menu" class="hidden absolute left-0 right-0 top-full z-30 mt-2 origin-top transform bg-white shadow-xl lg:hidden mx-4 rounded-xl border border-slate-100 transition-all">
                <div class="flex flex-col p-2 text-sm font-medium">
                    <a href="{{ url('/') }}" class="rounded-md px-4 py-3 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">
                        Beranda
                    </a>
                    <a href="{{ route('courses') }}" class="rounded-md px-4 py-3 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">
                        Pelatihan
                    </a>
                    <a href="{{ url('/about') }}" class="rounded-md px-4 py-3 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">
                        Tentang
                    </a>
                    <div class="my-1 border-t border-slate-100"></div>
                    @if(request()->routeIs('register'))
                         <a href="{{ route('login') }}" class="rounded-md px-4 py-3 text-emerald-600 hover:bg-emerald-50">
                            Sudah punya akun? <strong>Masuk</strong>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-md px-4 py-3 text-emerald-600 hover:bg-emerald-50">
                            Belum punya akun? <strong>Daftar</strong>
                        </a>
                    @endif
                </div>
            </div>
        </header>

        {{-- AREA FORM --}}
        <main class="flex flex-1 items-center justify-center px-6 py-8 sm:px-12 lg:px-16">
            <div class="w-full max-w-[420px] space-y-6">
                {{-- Form Content --}}
                @yield('form')
            </div>
        </main>

        {{-- Footer --}}
        <div class="py-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} Halal Center UIN SUKA
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('auth-menu-btn');
        const menu = document.getElementById('auth-mobile-menu');

        if(btn && menu) {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });

            // Tutup menu jika klik di luar
            document.addEventListener('click', (e) => {
                if (!menu.contains(e.target) && !btn.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush
