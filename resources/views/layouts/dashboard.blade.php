@extends('layouts.base')

@section('body')
@php($activeSidebar = $activeSidebar ?? '')
@php($activeNav = $activeNav ?? 'courses')

{{-- Layout Container --}}
<div class="flex min-h-screen bg-slate-100 text-slate-900 lg:h-screen lg:overflow-hidden">

    <div id="sidebar-backdrop"
         class="fixed inset-0 z-30 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 lg:hidden"
         data-sidebar-close>
    </div>

    <aside id="dashboard-sidebar"
           class="fixed inset-y-0 left-0 z-40 flex w-72 flex-col border-r border-emerald-100 bg-emerald-600 text-white transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen"
           data-sidebar>

        {{-- Header Sidebar --}}
        <div class="flex items-center justify-between gap-3 px-6 py-5 ">
            <a href="{{ route('courses') }}" class="flex items-center gap-3">
                <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo Halal Center"
                     class="h-16 w-auto object-contain brightness-0 invert">
                <div class="text-base font-semibold leading-tight">
                    <span class="block uppercase tracking-wide text-white">Halal</span>
                    <span class="block uppercase tracking-wide text-white">Center UIN SUKA</span>
                </div>
            </a>
            {{-- Tombol Close (Hanya di HP) --}}
            <button type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/40 text-white/80 hover:border-white hover:text-white lg:hidden"
                    data-sidebar-close>
                <i class="fas fa-xmark text-lg"></i>
            </button>
        </div>

        {{-- Menu Navigasi Sidebar --}}
        <nav class="flex-1 overflow-y-auto p-6">
            <ul class="space-y-2 text-sm font-medium">
                {{-- AKUN SAYA --}}
                <li>
                    <a href="{{ route('account') }}"
                       @class(['group flex items-center gap-3 rounded-xl px-4 py-3 transition', $activeSidebar === 'account' ? 'bg-white text-emerald-600' : 'text-white/80 hover:bg-white/10'])>
                        <i class="fas fa-user-circle text-base"></i>
                        <span>Akun Saya</span>
                    </a>
                </li>
                <li class="my-2 border-t border-white/10"></li>

                <li>
                    <a href="{{ route('courses') }}"
                       @class(['group flex items-center gap-3 rounded-xl px-4 py-3 transition', $activeSidebar === 'courses' ? 'bg-white text-emerald-600' : 'text-white/80 hover:bg-white/10'])>
                        <i class="fas fa-graduation-cap text-base"></i>
                        <span>Daftar Pelatihan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('my-courses') }}"
                       @class(['group flex items-center gap-3 rounded-xl px-4 py-3 transition', $activeSidebar === 'my-courses' ? 'bg-white text-emerald-600' : 'text-white/80 hover:bg-white/10'])>
                        <i class="fas fa-book-open text-base"></i>
                        <span>Pelatihan Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('certificate.index') }}"
                       @class(['group flex items-center gap-3 rounded-xl px-4 py-3 transition', $activeSidebar === 'my-certificates' ? 'bg-white text-emerald-600' : 'text-white/80 hover:bg-white/10'])>
                        <i class="fas fa-award text-base"></i>
                        <span>Sertifikat Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('faq') }}"
                       @class(['group flex items-center gap-3 rounded-xl px-4 py-3 transition', $activeSidebar === 'faq' ? 'bg-white text-emerald-600' : 'text-white/80 hover:bg-white/10'])>
                        <i class="fas fa-circle-question text-base"></i>
                        <span>Bantuan / FAQ</span>
                    </a>
                </li>

                <li class="mt-4 pt-4 border-t border-white/10 lg:hidden">
                    <span class="px-4 text-xs font-semibold uppercase text-white/50">Website</span>
                </li>
                <li class="lg:hidden">
                    <a href="{{ url('/') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-white/80 hover:bg-white/10 transition">
                        <i class="fas fa-home text-base"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="lg:hidden">
                    <a href="{{ url('/about') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-white/80 hover:bg-white/10 transition">
                        <i class="fas fa-info-circle text-base"></i>
                        <span>Tentang</span>
                    </a>
                </li>

                @yield('sidebar-extra')
            </ul>
        </nav>

        {{-- Footer Sidebar --}}
        <div class="border-t border-white/10 px-6 py-5">
            <form method="POST" action="{{ route('logout') }}" class="space-y-3">
                @csrf
                <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/30 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white hover:bg-white/10">
                    <i class="fas fa-right-from-bracket text-sm"></i>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex w-full flex-1 flex-col overflow-y-auto">

        {{-- Navbar Atas --}}
        <div class="sticky top-0 z-30 bg-white/95 shadow-sm backdrop-blur lg:bg-slate-100 lg:shadow-none lg:backdrop-blur-none">
            <div class="mx-auto flex w-full items-center justify-between px-4 py-6 sm:justify-end">

                {{-- TOMBOL HAMBURGER (KIRI - MOBILE) --}}
                <button type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-emerald-600 shadow-sm border border-slate-100 lg:hidden"
                        data-sidebar-open>
                    <i class="fas fa-bars"></i>
                    <span>Menu</span>
                </button>

                <nav class="flex items-center w-full lg:w-auto">

                    {{--
                        === PERBAIKAN DI SINI (PROFILE MOBILE) ===
                        Sekarang menggunakan <button> dan struktur Dropdown,
                        bukan hanya gambar diam.
                    --}}
                    @auth
                    <div class="relative lg:hidden ml-auto">
                        <button type="button"
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white transition hover:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                data-dropdown-target="mobile-profile-menu">
                            <img class="h-full w-full rounded-full object-cover"
                                 src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=10b981&color=fff' }}"
                                 alt="Avatar">
                        </button>

                        {{-- Dropdown Menu Khusus Mobile --}}
                        <ul id="mobile-profile-menu"
                            class="dropdown-menu absolute right-0 top-12 hidden min-w-[200px] rounded-xl border border-slate-200 bg-white p-2 text-sm font-medium text-slate-600 shadow-xl focus:outline-none z-50 origin-top-right">

                            {{-- Info User Singkat --}}
                            <li class="px-3 py-2 border-b border-slate-100 mb-1">
                                <span class="block text-xs text-slate-400">Halo,</span>
                                <span class="block font-bold text-slate-800 truncate">{{ Auth::user()->name }}</span>
                            </li>

                            <li>
                                <a href="{{ route('account') }}" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left transition hover:bg-emerald-50 hover:text-emerald-600">
                                    <i class="fas fa-user-circle text-base"></i>
                                    <span>Akun Saya</span>
                                </a>
                            </li>

                            {{-- Divider --}}
                            <li class="my-1 border-t border-slate-100"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-red-600 transition hover:bg-red-50">
                                        <i class="fas fa-right-from-bracket text-sm"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endauth

                    {{--
                        NAVBAR DESKTOP (TIDAK BERUBAH)
                        Tetap hidden di mobile (lg:flex).
                    --}}
                    <ul class="hidden lg:flex items-center gap-3 rounded-full bg-white px-3 py-2 shadow-sm text-xs font-semibold uppercase tracking-wide ml-auto">
                        <li>
                            <a href="{{ url('/') }}"
                               @class(['inline-flex items-center rounded-full px-4 py-2 transition', $activeNav === 'home' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600'])>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses') }}"
                               @class(['inline-flex items-center rounded-full px-4 py-2 transition', $activeNav === 'courses' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600'])>
                                Pelatihan
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}"
                               @class(['inline-flex items-center rounded-full px-4 py-2 transition', $activeNav === 'about' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600'])>
                                Tentang
                            </a>
                        </li>

                        @auth
                            <li class="relative">
                                <button type="button"
                                        class="profile-trigger inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 transition hover:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1"
                                        data-dropdown-target="desktop-profile-menu">
                                    <img class="h-full w-full rounded-full object-cover"
                                         src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=10b981&color=fff' }}"
                                         alt="{{ Auth::user()->name }}">
                                </button>

                                <ul id="desktop-profile-menu"
                                    class="dropdown-menu absolute right-0 top-12 hidden min-w-[160px] rounded-lg border border-slate-200 bg-white/95 p-2 text-sm font-medium text-slate-600 shadow-lg focus:outline-none z-50">
                                    <li>
                                        <a href="{{ route('account') }}">
                                            <button type="button" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left transition hover:bg-emerald-50 hover:text-emerald-600">
                                                <i class="fas fa-user-circle text-base"></i>
                                                <span>Akun Saya</span>
                                            </button>
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
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}"
                                   @class(['inline-flex items-center rounded-lg px-4 py-2 transition', $activeNav === 'login' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600'])>
                                    Masuk
                                </a>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>

        {{-- Area Konten --}}
        <main class="flex-1">
            <div class="mx-auto w-full max-w-6xl px-4 py-8">
                @yield('content')
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
{{-- Script Dropdown (Sama) --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const triggers = document.querySelectorAll('[data-dropdown-target]');
        triggers.forEach(trigger => {
            const menuId = trigger.getAttribute('data-dropdown-target');
            const menu = document.getElementById(menuId);
            if (!menu) return;

            function closeMenu() {
                menu.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
            }

            trigger.addEventListener('click', (event) => {
                event.stopPropagation();
                const isHidden = menu.classList.contains('hidden');
                document.querySelectorAll('.dropdown-menu').forEach(item => item.classList.add('hidden'));
                document.querySelectorAll('[data-dropdown-target]').forEach(btn => btn.setAttribute('aria-expanded', 'false'));
                if (isHidden) {
                    menu.classList.remove('hidden');
                    trigger.setAttribute('aria-expanded', 'true');
                } else {
                    closeMenu();
                }
            });

            document.addEventListener('click', (event) => {
                if (!menu.contains(event.target) && event.target !== trigger) {
                    closeMenu();
                }
            });
        });
    });
</script>

{{-- Script Sidebar (Perbaikan untuk menghindari 'flash' layout) --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.querySelector('[data-sidebar]');
        const backdrop = document.getElementById('sidebar-backdrop');
        const openBtn = document.querySelector('[data-sidebar-open]');
        const closeBtns = document.querySelectorAll('[data-sidebar-close]');

        if (!sidebar || !openBtn) return;

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            if(backdrop) {
                backdrop.classList.remove('hidden');
                setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
            }
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            if(backdrop) {
                backdrop.classList.add('opacity-0');
                setTimeout(() => backdrop.classList.add('hidden'), 300);
            }
        }

        openBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            openSidebar();
        });

        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => closeSidebar());
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                if(backdrop) backdrop.classList.add('hidden', 'opacity-0');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
</script>
@endpush
