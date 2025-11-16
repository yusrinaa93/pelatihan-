@extends('layouts.base')

@section('body')
@php($activeNav = $activeNav ?? '')
<div class="grid min-h-screen bg-slate-100 lg:grid-cols-[45%_55%]">
    <div class="relative hidden overflow-hidden lg:block">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1600"
             alt="Pelatihan Halal"
             class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-emerald-900/70 mix-blend-multiply"></div>
        <div class="relative z-10 flex h-full flex-col justify-between p-10 text-white">
            <div class="space-y-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-lg font-semibold">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white/10 backdrop-blur">
                        <i class="fas fa-leaf"></i>
                    </span>
                    <span>Pelatihan Pendamping Halal</span>
                </a>
                <p class="max-w-sm text-sm leading-relaxed text-emerald-100">
                    Bergabunglah bersama ratusan pendamping proses produk halal yang tersebar di seluruh Indonesia.
                    Akses materi pelatihan, ujian, dan sertifikasi dalam satu platform terpadu.
                </p>
            </div>
            <div class="text-xs uppercase tracking-[0.4em] text-emerald-200/80">
                Komitmen untuk Produk Halal Terpercaya
            </div>
        </div>
    </div>

    <div class="flex flex-col bg-white">
        <header class="border-b border-slate-200/70">
            <nav class="mx-auto flex w-full max-w-3xl items-center justify-end px-6 py-4">
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
        </header>

        <main class="flex flex-1 items-center justify-center px-6 py-10 sm:px-10">
            <div class="w-full max-w-md">
                @yield('form')
            </div>
        </main>
    </div>
</div>
@endsection

