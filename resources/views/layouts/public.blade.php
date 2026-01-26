@extends('layouts.base')

@section('body')
@php($activeNav = $activeNav ?? '')

<div class="min-h-screen flex flex-col bg-slate-50 text-slate-900 font-sans">

    {{-- Header FIXED --}}
    <header class="sticky top-0 z-50 bg-white/95 shadow-sm backdrop-blur-md transition-all duration-300">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">

                {{-- 1. LOGO SECTION --}}
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo Halal Center" class="h-12 w-auto object-contain sm:h-14">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold uppercase tracking-wider text-slate-900 sm:text-base">Halal</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 sm:text-xs">Center UIN SUKA</span>
                        </div>
                    </a>
                </div>

                {{-- 2. DESKTOP NAVIGATION (Hidden on Mobile) --}}
                <nav class="hidden md:flex items-center gap-2">
                    <ul class="flex items-center gap-1 rounded-full bg-slate-50/50 px-2 py-1.5 text-sm font-semibold text-slate-600">
                        <li>
                            <a href="{{ url('/') }}"
                               @class(['rounded-full px-4 py-2 transition-all duration-200', $activeNav === 'home' ? 'bg-emerald-600 text-white shadow-md' : 'hover:bg-slate-200 hover:text-emerald-700'])>
                                Beranda
                            </a>
                        </li>
                        <li>
                            @auth
                                <a href="{{ route('courses') }}"
                                   @class(['rounded-full px-4 py-2 transition-all duration-200', $activeNav === 'courses' ? 'bg-emerald-600 text-white shadow-md' : 'hover:bg-slate-200 hover:text-emerald-700'])>
                                    Pelatihan
                                </a>
                            @else
                                <a href="{{ route('guest.courses') }}"
                                   @class(['rounded-full px-4 py-2 transition-all duration-200', $activeNav === 'courses' ? 'bg-emerald-600 text-white shadow-md' : 'hover:bg-slate-200 hover:text-emerald-700'])>
                                    Pelatihan
                                </a>
                            @endauth
                        </li>
                        <li>
                            <a href="{{ url('/about') }}"
                               @class(['rounded-full px-4 py-2 transition-all duration-200', $activeNav === 'about' ? 'bg-emerald-600 text-white shadow-md' : 'hover:bg-slate-200 hover:text-emerald-700'])>
                                Tentang
                            </a>
                        </li>
                    </ul>

                    {{-- Desktop Profile/Login --}}
                    <div class="ml-4 pl-4 border-l border-slate-200">
                        @auth
                            <div class="relative">
                                <button type="button"
                                        class="profile-trigger flex h-10 w-10 items-center justify-center rounded-full border-2 border-white ring-2 ring-slate-100 transition hover:ring-emerald-400 focus:outline-none"
                                        data-dropdown-target="desktop-profile-menu">
                                    <img class="h-full w-full rounded-full object-cover"
                                         src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=10b981&color=fff' }}"
                                         alt="{{ Auth::user()->name }}">
                                </button>
                                {{-- Dropdown Desktop --}}
                                <div id="desktop-profile-menu" class="dropdown-menu absolute right-0 mt-3 hidden w-48 origin-top-right rounded-xl border border-slate-100 bg-white py-1 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="border-b border-slate-100 px-4 py-2">
                                        <p class="truncate text-sm font-medium text-slate-900">{{ Auth::user()->name }}</p>
                                        <p class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-red-600">
                                            <span>Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-2 text-sm font-medium text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                                Masuk
                            </a>
                        @endauth
                    </div>
                </nav>

                {{-- 3. MOBILE MENU BUTTON (Hamburger) --}}
                <div class="flex md:hidden">
                    <button type="button" id="mobile-menu-btn" class="inline-flex items-center justify-center rounded-md p-2 text-slate-600 hover:bg-slate-100 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500">
                        <span class="sr-only">Buka menu utama</span>
                        {{-- Icon Menu (Hamburger) --}}
                        <svg id="icon-menu-open" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        {{-- Icon Close (X) --}}
                        <svg id="icon-menu-close" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- 4. MOBILE NAVIGATION MENU (Slide Down) --}}
        <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white md:hidden shadow-lg">
            <div class="space-y-1 px-4 py-4 pb-6">
                <a href="{{ url('/') }}"
                   @class(['block rounded-lg px-3 py-2 text-base font-medium', $activeNav === 'home' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50 hover:text-emerald-600'])>
                    Beranda
                </a>

                @auth
                    <a href="{{ route('courses') }}"
                       @class(['block rounded-lg px-3 py-2 text-base font-medium', $activeNav === 'courses' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50 hover:text-emerald-600'])>
                        Pelatihan
                    </a>
                @else
                    <a href="{{ route('guest.courses') }}"
                       @class(['block rounded-lg px-3 py-2 text-base font-medium', $activeNav === 'courses' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50 hover:text-emerald-600'])>
                        Pelatihan
                    </a>
                @endauth

                <a href="{{ url('/about') }}"
                   @class(['block rounded-lg px-3 py-2 text-base font-medium', $activeNav === 'about' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50 hover:text-emerald-600'])>
                    Tentang
                </a>
            </div>

            {{-- Mobile Profile Section --}}
            <div class="border-t border-slate-200 px-4 py-4 bg-slate-50">
                @auth
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                 src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=10b981&color=fff' }}"
                                 alt="">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-slate-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-slate-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-base font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-800">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center rounded-lg bg-emerald-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-emerald-700">
                        Masuk ke Akun
                    </a>
                @endauth
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
        // --- 1. Mobile Menu Logic ---
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-menu-open');
        const iconClose = document.getElementById('icon-menu-close');

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.contains('hidden');

                if (isHidden) {
                    // Buka Menu
                    mobileMenu.classList.remove('hidden');
                    iconOpen.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                } else {
                    // Tutup Menu
                    mobileMenu.classList.add('hidden');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                }
            });
        }

        // --- 2. Desktop Dropdown Logic (User Profile) ---
        const dropdownTriggers = document.querySelectorAll('[data-dropdown-target]');

        dropdownTriggers.forEach(trigger => {
            const menuId = trigger.getAttribute('data-dropdown-target');
            const menu = document.getElementById(menuId);

            if (!menu) return;

            // Toggle klik
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });

            // Tutup jika klik di luar
            document.addEventListener('click', (e) => {
                if (!menu.contains(e.target) && !trigger.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    });
</script>
@endpush
