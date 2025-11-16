@extends('layouts.base')

@section('body')
@php($activeSidebar = $activeSidebar ?? '')
@php($activeNav = $activeNav ?? '')
<div class="flex min-h-screen bg-slate-100 text-slate-900">
    <aside id="dashboard-sidebar"
           class="fixed inset-y-0 left-0 z-40 flex w-72 flex-col border-r border-emerald-100 bg-emerald-600 text-white transition-transform duration-300 ease-in-out lg:static lg:translate-x-0"
           data-sidebar>
        <div class="flex items-center justify-between gap-3 px-6 py-5 border-b border-white/10">
            <a href="{{ route('courses') }}" class="flex items-center gap-3">
                <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo Halal"
                     class="h-12 w-12 rounded-xl border border-white/30 bg-white/10 object-contain p-1.5">
                <div>
                    <p class="text-xs uppercase tracking-widest text-emerald-100/80">Pelatihan</p>
                    <p class="text-sm font-semibold leading-tight">Pendamping Proses Produk Halal</p>
                </div>
            </a>
            <button type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/40 text-white/80 hover:border-white hover:text-white lg:hidden"
                    data-sidebar-close>
                <i class="fas fa-xmark text-lg"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-6">
            <ul class="space-y-2 text-sm font-medium">
                <li>
                    <a href="{{ route('courses') }}"
                       class="@class([
                           'group flex items-center gap-3 rounded-xl px-4 py-3 transition',
                           $activeSidebar === 'courses' ? 'bg-white text-emerald-600 shadow-lg shadow-emerald-900/20' : 'text-white/80 hover:bg-white/10'
                       ])">
                        <i class="fas fa-graduation-cap text-base"></i>
                        <span>Courses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('my-courses') }}"
                       class="@class([
                           'group flex items-center gap-3 rounded-xl px-4 py-3 transition',
                           $activeSidebar === 'my-courses' ? 'bg-white text-emerald-600 shadow-lg shadow-emerald-900/20' : 'text-white/80 hover:bg-white/10'
                       ])">
                        <i class="fas fa-book-open text-base"></i>
                        <span>My Courses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('account') }}"
                       class="@class([
                           'group flex items-center gap-3 rounded-xl px-4 py-3 transition',
                           $activeSidebar === 'account' ? 'bg-white text-emerald-600 shadow-lg shadow-emerald-900/20' : 'text-white/80 hover:bg-white/10'
                       ])">
                        <i class="fas fa-user-circle text-base"></i>
                        <span>Account</span>
                    </a>
                </li>
                @yield('sidebar-extra')
            </ul>
        </nav>

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

    <div class="flex min-h-screen w-full flex-1 flex-col lg:pl-0">
        <header class="sticky top-0 z-30 border-b border-slate-200/70 bg-white/80 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-4">
                <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 shadow-sm transition hover:border-emerald-200 hover:text-emerald-600 lg:hidden"
                        data-sidebar-open>
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <nav class="ml-auto">
                    <ul class="flex flex-wrap items-center gap-2 rounded-full border border-slate-200/70 bg-white px-2 py-1 text-xs font-semibold uppercase tracking-wide text-slate-500 shadow-sm">
                        <li>
                            <a href="{{ url('/') }}"
                               class="@class(['inline-flex items-center rounded-full px-4 py-2 transition', $activeNav === 'home' ? 'bg-emerald-600 text-white shadow' : 'hover:bg-emerald-50 hover:text-emerald-600'])">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses') }}"
                               class="@class(['inline-flex items-center rounded-full px-4 py-2 transition', $activeNav === 'courses' ? 'bg-emerald-600 text-white shadow' : 'hover:bg-emerald-50 hover:text-emerald-600'])">
                                Courses
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}"
                               class="@class(['inline-flex items-center rounded-full px-4 py-2 transition', $activeNav === 'about' ? 'bg-emerald-600 text-white shadow' : 'hover:bg-emerald-50 hover:text-emerald-600'])">
                                About
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="flex-1">
            <div class="mx-auto w-full max-w-6xl px-4 py-8">
                @yield('content')
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.querySelector('[data-sidebar]');
        const openBtn = document.querySelector('[data-sidebar-open]');
        const closeBtn = document.querySelector('[data-sidebar-close]');
        if (!sidebar || !openBtn) return;

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
        }

        sidebar.classList.add('-translate-x-full');
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
        }

        openBtn.addEventListener('click', () => {
            openSidebar();
        });

        closeBtn?.addEventListener('click', () => {
            closeSidebar();
        });

        document.addEventListener('click', (event) => {
            if (window.innerWidth >= 1024) return;
            if (!sidebar.contains(event.target) && !openBtn.contains(event.target)) {
                closeSidebar();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
</script>
@endpush

