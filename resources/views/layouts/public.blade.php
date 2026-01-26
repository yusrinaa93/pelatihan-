@extends('layouts.base')

@section('body')
@php($activeNav = $activeNav ?? '')

<div class="min-h-screen flex flex-col bg-slate-50 text-slate-900 font-sans">

    {{-- Header (sticky saat scroll, gaya mengikuti auth layout) --}}
    <header class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-md shadow-sm px-6 py-4 lg:px-10 lg:py-5">
        <div class="mx-auto w-full max-w-7xl">
            <div class="flex items-center justify-between">

                {{-- Logo (tampil di semua ukuran layar, diperbesar) --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo" class="h-12 w-auto lg:h-14">
                    <div class="leading-tight">
                        <div class="text-sm font-extrabold uppercase tracking-wide text-slate-900 lg:text-base">Halal</div>
                        <div class="text-xs font-bold uppercase tracking-wide text-emerald-600 lg:text-sm">Center UIN SUKA</div>
                    </div>
                </a>

                {{-- TOMBOL HAMBURGER (Mobile Only) --}}
                <button id="public-menu-btn" class="block rounded-md p-2 text-slate-600 hover:bg-slate-200 focus:outline-none lg:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                {{-- NAVIGASI DESKTOP (mirip auth layout) --}}
                <nav class="hidden lg:block">
                    <div class="flex items-center gap-4">
                        <ul class="flex items-center gap-3 rounded-full bg-white px-3 py-2 shadow-sm text-xs font-semibold uppercase tracking-wide border border-slate-100">
                            <li>
                                <a href="{{ url('/') }}"
                                   class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'home' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                                    Beranda
                                </a>
                            </li>
                            <li>
                                @auth
                                    <a href="{{ route('courses') }}"
                                       class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'courses' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                                        Pelatihan
                                    </a>
                                @else
                                    <a href="{{ route('guest.courses') }}"
                                       class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'courses' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                                        Pelatihan
                                    </a>
                                @endauth
                            </li>
                            <li>
                                <a href="{{ url('/about') }}"
                                   class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'about' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                                    Tentang
                                </a>
                            </li>
                        </ul>

                        {{-- Desktop Profile/Login (seperti layout awal) --}}
                        <div class="pl-1 w-12 flex items-center justify-end">
                            @auth
                                @php($user = Auth::user())
                                @php($avatarUrl = $user->avatar
                                    ? asset('storage/' . $user->avatar)
                                    : ($user->profile_photo_path
                                        ? asset('storage/' . $user->profile_photo_path)
                                        : ($user->avatar_path
                                            ? asset('storage/' . $user->avatar_path)
                                            : ('https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=10b981&color=fff'))))

                                <div class="relative">
                                    <button type="button"
                                            class="profile-trigger flex h-10 w-10 items-center justify-center rounded-full border-2 border-white ring-2 ring-slate-100 transition hover:ring-emerald-400 focus:outline-none"
                                            data-dropdown-target="desktop-profile-menu">
                                        <img class="h-full w-full rounded-full object-cover"
                                             src="{{ $avatarUrl }}"
                                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=fff';"
                                             alt="{{ $user->name }}">
                                    </button>

                                    <div id="desktop-profile-menu" class="dropdown-menu absolute right-0 top-12 hidden min-w-[160px] rounded-lg border border-slate-200 bg-white/95 p-2 text-sm font-medium text-slate-600 shadow-lg focus:outline-none z-50">
                                        <ul class="space-y-1">
                                            <li>
                                                <a href="{{ route('account') }}" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left transition hover:bg-emerald-50 hover:text-emerald-600">
                                                    <i class="fas fa-user-circle text-base"></i>
                                                    <span>Akun Saya</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left transition hover:bg-emerald-50 hover:text-emerald-600">
                                                        <i class="fas fa-right-from-bracket text-xs"></i>
                                                        <span>Keluar</span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow-sm hover:bg-emerald-700 transition">
                                    Masuk
                                </a>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>

            {{-- MENU MOBILE (Slide Down, mirip auth layout) --}}
            <div id="public-mobile-menu" class="hidden absolute left-0 right-0 top-full z-30 mt-2 origin-top transform bg-white shadow-xl lg:hidden mx-4 rounded-xl border border-slate-100 transition-all">
                <div class="flex flex-col p-2 text-sm font-medium">
                    <a href="{{ url('/') }}" class="rounded-md px-4 py-3 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">
                        Beranda
                    </a>
                    @auth
                        <a href="{{ route('courses') }}" class="rounded-md px-4 py-3 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">
                            Pelatihan
                        </a>
                    @else
                        <a href="{{ route('guest.courses') }}" class="rounded-md px-4 py-3 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">
                            Pelatihan
                        </a>
                    @endauth
                    <a href="{{ url('/about') }}" class="rounded-md px-4 py-3 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600">
                        Tentang
                    </a>

                    <div class="my-1 border-t border-slate-100"></div>

                    @auth
                        <a href="{{ route('my-courses') }}" class="rounded-md px-4 py-3 text-emerald-600 hover:bg-emerald-50">
                            Ke Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left rounded-md px-4 py-3 text-rose-600 hover:bg-rose-50">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-4 py-3 text-emerald-600 hover:bg-emerald-50">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="rounded-md px-4 py-3 text-emerald-600 hover:bg-emerald-50">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-auto border-t border-slate-200 bg-white pt-10 pb-6">
        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-sm text-slate-500">
                © {{ now()->year }} <span class="font-semibold text-slate-700">Halal Center UIN SUKA</span>. All rights reserved.
            </p>
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Mobile menu logic
        const btn = document.getElementById('public-menu-btn');
        const menu = document.getElementById('public-mobile-menu');

        if(btn && menu) {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!menu.contains(e.target) && !btn.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        }

        // Desktop dropdown (avatar)
        const dropdownTriggers = document.querySelectorAll('[data-dropdown-target]');
        dropdownTriggers.forEach(trigger => {
            const menuId = trigger.getAttribute('data-dropdown-target');
            const dropdown = document.getElementById(menuId);
            if (!dropdown) return;

            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    });
</script>
@endpush
