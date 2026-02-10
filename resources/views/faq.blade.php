@php($activeSidebar = $activeSidebar ?? 'faq')
@php($activeNav = $activeNav ?? 'courses')
@extends('layouts.dashboard')

@section('title', 'FAQ - Pelatihan Halal')

@section('content')
    <div class="space-y-8">
        <div class="rounded-3xl border border-emerald-100 bg-white/95 p-8 shadow-lg shadow-emerald-100/60">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Bantuan Peserta</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">Frequently Asked Questions</h1>
            <p class="mt-3 text-sm text-slate-500 max-w-2xl">
                Temukan jawaban cepat tentang proses pendaftaran, akses materi, ujian, dan sertifikat. Jika masih membutuhkan bantuan, hubungi tim Halal Center UIN SUKA melalui WhatsApp atau email resmi.
            </p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            @foreach ($faqs as $faq)
                <article class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-md shadow-slate-100 transition hover:-translate-y-1 hover:border-emerald-100 hover:shadow-lg">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                            <i class="fas fa-circle-question"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ $faq['title'] }}</h2>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $faq['content'] }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white/95 p-6 text-center shadow-md shadow-slate-100">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Belum menemukan jawaban?</p>
            <h3 class="mt-3 text-xl font-bold text-slate-900">Hubungi Tim Support Halal Center</h3>
            <div class="mt-5 flex flex-wrap items-center justify-center gap-3">
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp
                </a>
                <a href="mailto:halalcenter@uinsuka.ac.id"
                   class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold uppercase tracking-wide text-slate-600 transition hover:border-emerald-200 hover:text-emerald-600">
                    <i class="fas fa-envelope-open-text"></i>
                    Email
                </a>
            </div>
        </div>
    </div>
@endsection

