@php($activeSidebar = 'my-certificates')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Gagal Unduh Sertifikat')

{{-- 
  Ini adalah konten halaman yang diubah menjadi modal pop-up.
--}}
@section('content')
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
        
        {{-- Ini adalah kotak modal putihnya --}}
        <div class="w-full max-w-md transform rounded-2xl bg-white p-6 shadow-2xl transition-all sm:p-8">
            
            {{-- Ikon Gagal (Merah) --}}
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-rose-100 text-rose-500">
                <i class="fas fa-times fa-2x"></i>
            </div>

            {{-- Judul dan Subjudul dari kode Anda --}}
            <div class="mt-4 space-y-2 text-center">
                <h1 class="text-2xl font-bold text-slate-900">Maaf, Anda Belum Memenuhi Syarat</h1>
                <p class="text-sm text-slate-500">
                    Sertifikat belum dapat diunduh karena beberapa persyaratan berikut belum terpenuhi:
                </p>
            </div>

            {{-- Daftar Alasan Gagal (dari kode Anda) --}}
            <ul class="mt-5 w-full space-y-2 rounded-xl border border-rose-200 bg-rose-50/80 px-4 py-4 text-left text-sm text-rose-700">
                @foreach ($reasons as $reason)
                    <li class="flex items-start gap-2">
                        <i class="fas fa-circle-xmark mt-1 text-xs"></i>
                        <span>{{ $reason }}</span>
                    </li>
                @endforeach
            </ul>

            {{-- Tombol Kembali (di-styling agar penuh) --}}
            <a href="{{ route('certificate.index') }}"
                class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

    </div>
@endsection