@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Certificate - My Courses')

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
    <div class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Sertifikat Kelulusan</p>
                <h1 class="text-2xl font-bold text-slate-900">Certificate</h1>
                <p class="mt-2 text-sm text-slate-500">Unduh sertifikat yang tersedia untuk pelatihan yang sudah Anda selesaikan.</p>
            </div>
            <div class="flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                <i class="fas fa-award"></i>
                {{ $courses->count() }} pelatihan
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/70 bg-white/95 p-6 shadow-lg shadow-slate-200/60">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex w-full max-w-xs items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm shadow-sm">
                    <i class="fas fa-search text-slate-400"></i>
                    <input type="text" placeholder="Cari sertifikat..." class="w-full border-none bg-transparent text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none" />
                </div>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Daftar Sertifikat</span>
            </div>

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama Pelatihan</th>
                            <th class="px-4 py-3 text-left">Status Sertifikat</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                        @forelse ($courses as $course)
                            <tr>
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $course->title }}</td>
                                <td class="px-4 py-3">
                                    @if ($course->is_certificate_active)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">
                                            <i class="fas fa-check-circle"></i>
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-400">
                                            <i class="fas fa-clock"></i>
                                            Belum tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('certificate.check', $course->id) }}"
                                       class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-emerald-400">
                                        <i class="fas fa-download"></i>
                                        Unduh
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-sm text-slate-400">
                                    Anda belum terdaftar di pelatihan manapun.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

