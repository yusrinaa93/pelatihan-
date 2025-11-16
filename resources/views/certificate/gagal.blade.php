@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Gagal Unduh Sertifikat')

@section('sidebar-extra')
    <li>
        <a href="{{ route('duty') }}"
           class="group flex items-center gap-3 rounded-xl px-4 py-3 transition text-white/80 hover:bg-white/10">
            <i class="fas fa-tasks text-base"></i>
            <span>Duty</span>
        </a>
    </li>
    <li>
        <a href="{{ route('exam') }}"
           class="group flex items-center gap-3 rounded-xl px-4 py-3 transition text-white/80 hover:bg-white/10">
            <i class="fas fa-pencil-alt text-base"></i>
            <span>Exam</span>
        </a>
    </li>
    <li>
        <a href="{{ route('certificate.index') }}"
           class="group flex items-center gap-3 rounded-xl px-4 py-3 transition bg-white text-emerald-600 shadow-lg shadow-emerald-900/20">
            <i class="fas fa-certificate text-base"></i>
            <span>Certificate</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="flex flex-col items-center gap-6 text-center">
        <div class="space-y-3">
            <p class="text-xs font-semibold uppercase tracking-widest text-rose-500">Sertifikat Belum Tersedia</p>
            <h1 class="text-3xl font-bold text-slate-900">Maaf, Anda Belum Memenuhi Syarat</h1>
            <p class="text-sm text-slate-500">Sertifikat belum dapat diunduh karena beberapa persyaratan berikut belum terpenuhi:</p>
        </div>

        <ul class="w-full max-w-lg space-y-2 rounded-2xl border border-rose-200 bg-rose-50/80 px-6 py-4 text-left text-sm text-rose-700">
            @foreach ($reasons as $reason)
                <li class="flex items-start gap-2">
                    <i class="fas fa-circle-xmark mt-1 text-xs"></i>
                    <span>{{ $reason }}</span>
                </li>
            @endforeach
        </ul>

        <p class="max-w-lg text-sm text-slate-500">
            Silakan lengkapi persyaratan tersebut atau hubungi admin apabila Anda merasa ini adalah kesalahan sistem.
        </p>

        <a href="{{ route('certificate.index') }}"
           class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
@endsection

