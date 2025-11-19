@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Hasil Ujian - ' . $result->exam->title)

{{-- 
  Blok @section('sidebar-extra') telah dihapus
  karena rute-rute tersebut sudah tidak digunakan lagi.
--}}

@section('content')
    <div class="flex flex-col items-center justify-center gap-6 text-center">
        <div class="space-y-3">
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Hasil Ujian</p>
            <h1 class="text-3xl font-bold text-slate-900">{{ $result->exam->title }}</h1>
            <p class="text-sm text-slate-500">Terima kasih telah menyelesaikan ujian ini. Berikut skor yang Anda peroleh.</p>
        </div>

        <div class="flex h-48 w-48 items-center justify-center rounded-full border-8 border-emerald-100 bg-emerald-500/10 shadow-lg shadow-emerald-200">
            <span class="text-5xl font-bold text-emerald-600">{{ $result->score }}</span>
        </div>

        <a href="{{ route('my-courses.show', $result->exam->course_id) }}#tab-ujian"
            class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Materi Pelatihan
        </a>
    </div>
@endsection