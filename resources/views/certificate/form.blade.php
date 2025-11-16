@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Verifikasi Sertifikat - ' . $course->title)

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
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Verifikasi Sertifikat</p>
                <h1 class="text-2xl font-bold text-slate-900">{{ $course->title }}</h1>
                <p class="mt-2 text-sm text-slate-500">
                    Pastikan data berikut benar sebelum sertifikat dicetak. Data akan tercetak sesuai yang Anda isi.
                </p>
            </div>
            <div class="flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                <i class="fas fa-id-card"></i>
                Verifikasi Data
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/70 bg-white/95 p-6 shadow-lg shadow-slate-200/60">
            @if (isset($existingData))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-700">
                    <strong>Informasi:</strong> Anda sebelumnya telah mengunduh sertifikat ini. Isi form berikut untuk mencetak ulang.
                </div>
            @else
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-700">
                    <strong>Selamat!</strong> Anda berhak mengunduh sertifikat. Pastikan data berikut benar dan sesuai identitas.
                </div>
            @endif

            <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                <strong>Perhatian:</strong> Data akan dicetak persis seperti yang Anda tulis. Mohon periksa kembali sebelum mengirim.
            </div>

            <form action="{{ route('certificate.generate', $course->id) }}" method="POST" class="mt-6 space-y-5 text-sm text-slate-600">
                @csrf

                <label class="flex flex-col gap-2 font-semibold text-slate-600">
                    Nama Lengkap (untuk Sertifikat)
                    <input type="text"
                           id="nama_sertifikat"
                           name="nama_sertifikat"
                           value="{{ old('nama_sertifikat', $existingData->name_on_certificate ?? $pendaftarData->nama ?? $user->name) }}"
                           required
                           class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
                </label>

                <div class="grid gap-5 md:grid-cols-2">
                    <label class="flex flex-col gap-2 font-semibold text-slate-600">
                        Tempat Lahir
                        <input type="text"
                               id="tempat_lahir"
                               name="tempat_lahir"
                               value="{{ old('tempat_lahir', $existingData ? explode(',', $existingData->ttl_on_certificate)[0] : $pendaftarData->tempat_lahir ?? '') }}"
                               required
                               class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
                    </label>
                    <label class="flex flex-col gap-2 font-semibold text-slate-600">
                        Tanggal Lahir
                        <input type="date"
                               id="tanggal_lahir"
                               name="tanggal_lahir"
                               value="{{ old('tanggal_lahir', $existingData ? \Carbon\Carbon::parse(trim(explode(',', $existingData->ttl_on_certificate)[1] ?? ''))->format('Y-m-d') : ($pendaftarData->tanggal_lahir ? \Carbon\Carbon::parse($pendaftarData->tanggal_lahir)->format('Y-m-d') : '')) }}"
                               required
                               class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
                    </label>
                </div>

                <label class="flex flex-col gap-2 font-semibold text-slate-600">
                    Nomor WhatsApp
                    <input type="text"
                           id="no_hp"
                           name="no_hp"
                           value="{{ old('no_hp', $existingData->phone_on_certificate ?? $pendaftarData->nomor_wa ?? '') }}"
                           required
                           class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
                </label>

                <div class="flex flex-wrap items-center justify-between gap-3 pt-4">
                    <a href="{{ route('certificate.index') }}"
                       class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500 transition hover:border-slate-300">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-xs font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        <i class="fas fa-download"></i>
                        {{ isset($existingData) ? 'Cetak Ulang Sertifikat' : 'Setuju & Unduh Sertifikat' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

