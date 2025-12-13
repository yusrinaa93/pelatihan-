@extends('layouts.base')

@section('body')
@php($activeNav = $activeNav ?? '')

<div class="grid min-h-screen bg-slate-100 lg:grid-cols-[45%_55%]">
    
    {{-- BAGIAN KIRI: GAMBAR (TETAP) --}}
    <div class="relative hidden overflow-hidden lg:block">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1600"
             alt="Pelatihan Halal"
             class="absolute inset-0 h-full w-full object-cover transition-transform duration-1000 hover:scale-105">
        <div class="absolute inset-0 bg-emerald-900/60 mix-blend-multiply"></div>
    </div>

    {{-- BAGIAN KANAN: KONTEN & NAVBAR --}}
    <div class="flex flex-col bg-slate-50 relative">
        
        {{-- === NAVBAR === --}}
        <header class="flex w-full items-center justify-end py-6 pr-8 sm:pr-8">
            <nav>
                <ul class="flex items-center gap-3 rounded-full bg-white px-3 py-2 shadow-sm text-xs font-semibold uppercase tracking-wide">
                    
                    {{-- Link: HOME --}}
                    <li>
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'home' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                            BERANDA
                        </a>
                    </li>

                    {{-- Link: COURSES --}}
                    <li>
                        <a href="{{ route('courses') }}"
                           class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'courses' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                            PELATIHAN
                        </a>
                    </li>

                    {{-- Link: ABOUT --}}
                    <li>
                        <a href="{{ url('/about') }}"
                           class="inline-flex items-center rounded-full px-4 py-2 transition {{ $activeNav === 'about' ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:text-emerald-600' }}">
                            TENTANG
                        </a>    
                    </li>

                    {{-- Link: LOGIN --}}
                    <li>
                        @if(request()->routeIs('login') || request()->routeIs('register'))
                            <span class="inline-flex items-center rounded-full bg-emerald-600 px-4 py-2 text-white shadow-sm">
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
        </header>

        {{-- AREA FORM --}}
        <main class="flex flex-1 items-center justify-center px-6 py-8 sm:px-10">
            <div class="w-full max-w-md">
                @yield('form')
            </div>
        </main>

        {{-- Footer --}}
        <div class="py-4 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} Halal Center UIN SUKA
        </div>
    </div>
</div>
@endsection