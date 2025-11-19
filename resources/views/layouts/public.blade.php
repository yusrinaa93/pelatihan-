@extends('layouts.base')

@section('body')
@php($activeNav = $activeNav ?? '')
<div class="min-h-screen flex flex-col bg-slate-50 text-slate-900">
    <header class="sticky top-0 z-30 bg-white/95 shadow-sm backdrop-blur"> 
        <div class="mx-auto flex w-full flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                
                {{-- Logo Tanpa Background --}}
                <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo Halal Center" class="h-16 w-auto object-contain">
                
                <div class="text-base font-semibold leading-tight text-slate-700">
                    <span class="block uppercase tracking-wide text-slate-900">Halal</span>
                    <span class="block uppercase tracking-wide text-slate-900">Center UIN SUKA</span>
                </div>
            </a>
            <nav class="flex items-center">
                <ul class="flex items-center gap-3 rounded-full bg-white px-3 py-2 shadow-sm text-xs font-semibold uppercase tracking-wide">
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
                                    data-dropdown-target="profile-menu"
                                    aria-expanded="false"
                                    aria-label="Buka menu profil">
                                <span class="sr-only">Profil</span>
                                
                                <img class="h-full w-full rounded-full object-cover"
                                     src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=10b981&color=fff' }}"
                                     alt="{{ Auth::user()->name }}"
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff';">
                            </button>

                            <ul id="profile-menu"
                                class="dropdown-menu absolute right-0 top-12 hidden min-w-[160px] rounded-lg border border-slate-200 bg-white/95 p-2 text-sm font-medium text-slate-600 shadow-lg focus:outline-none">
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
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-12 border-t border-slate-200 bg-white/60">
        <div class="mx-auto w-full max-w-6xl px-4 py-6 text-center text-sm text-slate-500">
            © {{ now()->year }} Pelatihan Penyelia Halal. All rights reserved.
        </div>
    </footer>
</div>
@endsection

@push('scripts')
{{-- Script dropdown Anda (JANGAN DIUBAH) --}}
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
@endpush