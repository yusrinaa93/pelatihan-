@php($activeNav = 'about')
@extends('layouts.public')

@section('title', 'Tentang Program - Pelatihan Penyelia Halal')

@section('content')

<section class="relative overflow-hidden bg-gradient-to-b from-white to-slate-100 py-12 pt-16 lg:pt-20">
    <div class="absolute inset-0 -z-10 opacity-30">
        <div class="absolute -top-20 -left-10 h-64 w-64 rounded-full bg-emerald-200/40 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-72 w-72 rounded-full bg-emerald-300/30 blur-3xl"></div>
    </div>

    <div class="mx-auto flex w-full max-w-5xl flex-col gap-10 px-4 lg:flex-row lg:items-start">
        <div class="lg:w-1/3">
            <div class="overflow-hidden rounded-3xl border border-emerald-100 bg-white/90 p-6 shadow-xl shadow-emerald-100/60">
                <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo LP3H"
                     class="mx-auto h-40 w-full max-w-[220px] object-contain">
                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                            <i class="fas fa-certificate"></i>
                        </span>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Registrasi</p>
                            <p class="font-semibold text-slate-700">2112200002</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                            <i class="fas fa-building-columns"></i>
                        </span>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">Didirikan</p>
                            <p class="font-semibold text-slate-700">17 November 2021</p>
                            <p class="mt-1 text-xs text-slate-500">BPJPH Kementerian Agama RI</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:w-2/3">
            <div class="space-y-6 rounded-3xl border border-slate-200 bg-white/80 p-8 shadow-lg shadow-slate-200/60 backdrop-blur">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-emerald-500">Tentang Kami</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Lembaga Pendamping Proses Produk Halal</h1>
                </div>
                <div class="space-y-4 text-sm leading-relaxed text-slate-600 sm:text-base">
                    <p>
                        LP3H (Lembaga Pendamping Proses Produk Halal) UIN Sunan Kalijaga Yogyakarta merupakan lembaga resmi yang tersertifikasi oleh
                        BPJPH (Badan Penyelenggara Jaminan Produk Halal) Kementerian Agama Republik Indonesia.
                        LP3H hadir sebagai mitra strategis untuk mendampingi pelaku usaha dalam menyiapkan proses sertifikasi halal secara profesional.
                    </p>
                    <p>
                        Sejak berdiri pada 17 November 2021 dengan nomor registrasi 2112200002, LP3H UIN Sunan Kalijaga Yogyakarta terus berperan
                        aktif dalam pengembangan ekosistem halal nasional. Kami menjadi LP3H pertama di Indonesia dari unsur Perguruan Tinggi
                        Keagamaan Islam Negeri (PTKIN), bersama LP3H lain seperti UIN Syarif Hidayatullah Jakarta, UIN Sunan Gunung Djati Bandung,
                        UIN Walisongo Semarang, UIN Maulana Malik Ibrahim Malang, dan UIN Sunan Ampel Surabaya.
                    </p>
                    <p>
                        Dengan dukungan tenaga ahli bersertifikat, kurikulum komprehensif, dan jaringan nasional,
                        LP3H UIN Sunan Kalijaga berkomitmen menghadirkan pendampingan terbaik untuk memastikan produk halal Indonesia semakin berdaya saing.
                    </p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4 text-center">
                        <p class="text-sm font-semibold text-emerald-600">Pendamping Tersertifikasi</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-700">+120</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4 text-center">
                        <p class="text-sm font-semibold text-emerald-600">Pelaku Usaha Terbina</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-700">+850</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4 text-center">
                        <p class="text-sm font-semibold text-emerald-600">Kemitraan Nasional</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-700">+35</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection