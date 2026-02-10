@php($activeSidebar = 'my-certificates')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Konfirmasi Data - ' . $course->judul)

@section('content')
    {{-- 
       1. Kita biarkan konten dashboard kosong atau minimal, 
          karena akan tertutup overlay.
    --}}
    
    {{-- 
       2. OVERLAY MODAL (Style diambil dari gagal.blade.php)
       z-50 agar muncul di atas Sidebar (z-40) dan Header (z-30).
    --}}
    <div class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
        
        {{-- KOTAK PUTIH MODAL --}}
        <div class="w-full max-w-lg transform rounded-3xl bg-white shadow-2xl transition-all">
            
            {{-- Header Modal --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Konfirmasi Cetak Sertifikat</h3>
                {{-- Tombol Close (Kembali ke Index) --}}
                <a href="{{ route('certificate.index') }}" class="text-slate-400 hover:text-rose-500 transition">
                    <i class="fas fa-times text-xl"></i>
                </a>
            </div>

            {{-- Body Form --}}
            <div class="p-6 max-h-[80vh] overflow-y-auto">
                
                <div class="mb-6 flex gap-3 rounded-xl bg-blue-50 p-4 text-sm text-blue-700 border border-blue-100">
                    <i class="fas fa-info-circle mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-semibold">Perhatian:</span>
                        Pastikan ejaan <strong>Nama</strong> dan <strong>Tanggal Lahir</strong> sudah benar. Data ini akan dicetak permanen pada sertifikat.
                    </div>
                </div>

                <form action="{{ route('certificate.generate', $course->id) }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Input Nama --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wide text-slate-500">Nama Lengkap & Gelar</label>
                        <input type="text" 
                               name="nama" 
                               value="{{ old('nama', $pendaftarData->nama ?? $user->name) }}" 
                               required
                               class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200 transition">
                    </div>

                    {{-- Grid TTL --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-500">Tempat Lahir</label>
                            <input type="text" 
                                   name="tempat_lahir" 
                                   value="{{ old('tempat_lahir', $pendaftarData->tempat_lahir ?? '') }}" 
                                   required
                                   class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200 transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-500">Tanggal Lahir</label>
                            <input type="date" 
                                   name="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir', $pendaftarData->tanggal_lahir ?? '') }}" 
                                   required
                                   class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200 transition">
                        </div>
                    </div>

                    {{-- Input WA --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wide text-slate-500">Nomor WhatsApp</label>
                        <input type="text" 
                               name="nomor_wa" 
                               value="{{ old('nomor_wa', $pendaftarData->nomor_wa ?? '') }}" 
                               required
                               class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200 transition">
                    </div>

                    {{-- Data Bank (Wajib untuk yang lulus) --}}
                    <div class="grid grid-cols-1 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-500">Nama Bank</label>
                            <input type="text"
                                   name="bank_name"
                                   value="{{ old('bank_name', $user->bank_name ?? '') }}"
                                   required
                                   class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200 transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-500">Nama Pemilik Rekening</label>
                            <input type="text"
                                   name="bank_account_name"
                                   value="{{ old('bank_account_name', $user->bank_account_name ?? '') }}"
                                   required
                                   class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200 transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-500">Nomor Rekening</label>
                            <input type="text"
                                   name="bank_account_number"
                                   value="{{ old('bank_account_number', $user->bank_account_number ?? '') }}"
                                   required
                                   inputmode="numeric"
                                   autocomplete="off"
                                   class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-200 transition">
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-8 flex items-center gap-3 pt-2">
                        <a href="{{ route('certificate.index') }}" 
                           class="inline-flex w-1/3 items-center justify-center rounded-full border border-slate-200 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex w-2/3 items-center justify-center gap-2 rounded-full bg-emerald-500 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 hover:bg-emerald-400 hover:shadow-emerald-500/50 transition">
                            <i class="fas fa-print"></i>
                            Cetak PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection