@php($activeSidebar = 'my-certificates')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'My Certificates - Pelatihan Halal')

@section('content')
    <div class="space-y-8">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Pengelolaan Sertifikat</p>
            <h1 class="text-2xl font-bold text-slate-900">Sertifikat Saya</h1>
            <p class="mt-2 text-sm text-slate-500">
                Pantau status sertifikat untuk setiap pelatihan yang Anda ikuti dan unduh ketika sudah tersedia.
            </p>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200/70 bg-white/95 shadow-lg shadow-slate-200/60">
            @if($courses->isEmpty())
                <div class="p-10 text-center text-sm text-slate-500">
                    Anda belum memiliki kursus yang terdaftar atau sertifikat belum tersedia.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                            <tr>
                                <th class="px-4 py-3 text-left">Nama Pelatihan</th>
                                <th class="px-4 py-3 text-left">Status Sertifikat</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                            @foreach ($courses as $course)
                                @continue(is_null($course))
                                @php(
                                    $alreadyPrinted = \App\Models\Certificate::where('user_id', auth()->id())
                                        ->where('pelatihan_id', $course->id)
                                        ->exists()
                                )
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-slate-800">
                                        {{ $course->judul }}
                                    </td>
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
                                        @if ($course->is_certificate_active)
                                            @if ($alreadyPrinted)
                                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-400" title="Sertifikat sudah pernah dicetak.">
                                                    <i class="fas fa-check"></i>
                                                    Sudah Cetak
                                                </span>
                                            @else
                                                <a href="{{ route('certificate.check', $course->id) }}"
                                                   class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-emerald-400">
                                                    <i class="fas fa-download"></i>
                                                    Lihat / Unduh
                                                </a>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                <i class="fas fa-ban"></i>
                                                Belum tersedia
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

