@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Materi Pelatihan - ' . $course->title)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Materi Pelatihan</p>
                <h1 class="text-2xl font-bold text-slate-900">{{ $course->title }}</h1>
                <p class="mt-2 text-sm text-slate-500">Akses jadwal, presensi, tugas, ujian, dan sertifikat Anda dalam satu tempat.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                <i class="fas fa-layer-group text-sm"></i>
                Batch Aktif
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200/70 bg-white/95 shadow-lg shadow-slate-200/60">
            <nav class="flex flex-wrap gap-2 border-b border-slate-200/70 bg-white/80 px-4 py-3 text-sm font-semibold">
                <button type="button"
                        class="tab-link inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-white shadow-sm"
                        data-tab-target="tab-zoom">
                    <i class="fas fa-video text-xs"></i>
                    Jadwal & Zoom
                </button>
                <button type="button"
                        class="tab-link inline-flex items-center gap-2 rounded-full px-4 py-2 text-slate-500 transition hover:bg-emerald-50 hover:text-emerald-600"
                        data-tab-target="tab-presensi">
                    <i class="fas fa-clipboard-check text-xs"></i>
                    Presensi
                </button>
                <button type="button"
                        class="tab-link inline-flex items-center gap-2 rounded-full px-4 py-2 text-slate-500 transition hover:bg-emerald-50 hover:text-emerald-600"
                        data-tab-target="tab-tugas">
                    <i class="fas fa-tasks text-xs"></i>
                    Tugas
                </button>
                <button type="button"
                        class="tab-link inline-flex items-center gap-2 rounded-full px-4 py-2 text-slate-500 transition hover:bg-emerald-50 hover:text-emerald-600"
                        data-tab-target="tab-ujian">
                    <i class="fas fa-file-signature text-xs"></i>
                    Ujian
                </button> 
            </nav>

            <div class="tab-panels space-y-8 p-6">
                <div id="tab-zoom" class="tab-panel space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Jadwal Zoom Meeting</h2>
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                                <tr>
                                    <th class="px-4 py-3 text-left">No</th>
                                    <th class="px-4 py-3 text-left">Tanggal</th>
                                    <th class="px-4 py-3 text-left">Waktu</th>
                                    <th class="px-4 py-3 text-left">Kategori</th>
                                    <th class="px-4 py-3 text-left">Zoom</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">{{ $schedule->start_time?->translatedFormat('l, d F Y') }}</td>
                                        <td class="px-4 py-3">
                                            {{ $schedule->start_time?->format('H:i') }} - {{ $schedule->end_time?->format('H:i') }}
                                        </td>
                                        <td class="px-4 py-3">{{ $schedule->category }}</td>
                                        <td class="px-4 py-3">
                                            @if($schedule->zoom_link)
                                                <a href="{{ $schedule->zoom_link }}" target="_blank"
                                                   class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-sky-400">
                                                    <i class="fas fa-video"></i>
                                                    Join Zoom
                                                </a>
                                            @else
                                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Belum tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-400">Belum ada jadwal.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="tab-presensi" class="tab-panel hidden space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Presensi</h2>
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                                <tr>
                                    <th class="px-4 py-3 text-left">No</th>
                                    <th class="px-4 py-3 text-left">Tanggal</th>
                                    <th class="px-4 py-3 text-left">Waktu</th>
                                    <th class="px-4 py-3 text-left">Materi</th>
                                    <th class="px-4 py-3 text-left">Jam Presensi</th>
                                    <th class="px-4 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">{{ $schedule->start_time?->translatedFormat('l, d F Y') }}</td>
                                        <td class="px-4 py-3">{{ $schedule->start_time?->format('H:i') }} - {{ $schedule->end_time?->format('H:i') }}</td>
                                        <td class="px-4 py-3">{{ $schedule->category }}</td>
                                        <td class="px-4 py-3">{{ $schedule->start_time?->format('H:i') }} - {{ $schedule->end_time?->format('H:i') }}</td>
                                        <td class="px-4 py-3">
                                            @if($schedule->has_attended)
                                                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">
                                                    <i class="fas fa-check-circle"></i>
                                                    Sudah Presensi
                                                </span>
                                            @elseif($schedule->is_presence_active)
                                                <button type="button"
                                                        class="btn-presence inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-emerald-400"
                                                        data-schedule-id="{{ $schedule->id }}">
                                                    Presensi
                                                </button>
                                            @else
                                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                    Presensi Ditutup
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-400">Belum ada materi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="tab-tugas" class="tab-panel hidden space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h2 class="text-lg font-semibold text-slate-900">Tugas</h2>
                    </div>
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                                <tr>
                                    <th class="px-4 py-3 text-left">No</th>
                                    <th class="px-4 py-3 text-left">Nama</th>
                                    <th class="px-4 py-3 text-left">Deskripsi</th>
                                    <th class="px-4 py-3 text-left">File Tugas</th>
                                    <th class="px-4 py-3 text-left">Deadline</th>
                                    <th class="px-4 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                                @forelse ($duties as $duty)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 font-semibold text-slate-700">{{ $duty->name }}</td>
                                        <td class="px-4 py-3">
                                            @if($duty->description)
                                                <div class="prose prose-sm max-w-none text-slate-600">{!! $duty->description !!}</div>
                                            @else
                                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                    Tidak ada deskripsi
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($duty->attachment_path)
                                                <a href="{{ Storage::disk('public')->url($duty->attachment_path) }}"
                                                   target="_blank"
                                                   class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-sky-400">
                                                    <i class="fas fa-file-arrow-down"></i>
                                                    Unduh Tugas
                                                </a>
                                            @else
                                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                    Belum ada file
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $duty->deadline->translatedFormat('l, d F Y') }}</td>
                                        <td class="px-4 py-3">
                                            @if(!empty($duty->submission) && !empty($duty->submission->file_path))
                                                <div class="flex flex-col gap-2">
                                                    <a href="{{ Storage::disk('public')->url($duty->submission->file_path) }}"
                                                       target="_blank"
                                                       class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-sky-400">
                                                        <i class="fas fa-cloud-arrow-down"></i>
                                                        Download
                                                    </a>
                                                    <span class="truncate text-xs font-medium text-slate-500">
                                                        {{ $duty->submission->original_filename }}
                                                    </span>
                                                </div>
                                            @else
                                                <button type="button"
                                                        class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-emerald-400"
                                                        data-upload-trigger
                                                        data-duty-id="{{ $duty->id }}">
                                                    <i class="fas fa-cloud-arrow-up"></i>
                                                    Upload
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-400">Belum ada tugas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="tab-ujian" class="tab-panel hidden space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Ujian</h2>
                    <div class="space-y-4">
                        @forelse($exams as $exam)
                            <div class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-slate-200 px-5 py-4 shadow-sm shadow-slate-200/50">
                                <div>
                                    <h3 class="text-base font-semibold text-slate-800">{{ $exam->title }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ $exam->description ?? 'Tidak ada deskripsi.' }}</p>
                                    <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        {{ $exam->questions_count }} Soal
                                    </p>
                                </div>
                                <div>
                                    @if ($exam->is_completed)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                                            <i class="fas fa-circle-check"></i>
                                            Selesai
                                        </span>
                                    @else
                                        <a href="{{ route('exams.show', $exam->id) }}"
                                           class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-emerald-400">
                                            <i class="fas fa-play"></i>
                                            Mulai Ujian
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="rounded-2xl border border-dashed border-slate-300 px-5 py-6 text-center text-sm text-slate-400">
                                Tidak ada ujian yang tersedia saat ini.
                            </p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="uploadModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-2xl shadow-slate-900/20">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Upload Tugas</h3>
                <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:border-emerald-200 hover:text-emerald-600" data-modal-close>
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <form id="uploadForm" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <label class="flex flex-col gap-2 text-sm font-medium text-slate-600">
                    Pilih berkas
                    <input type="file" name="file" required
                           class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                </label>
                <div class="flex items-center justify-end gap-3">
                    <button type="button"
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-500 transition hover:border-slate-300"
                            data-modal-close>
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-emerald-400">
                        <i class="fas fa-cloud-arrow-up"></i>
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ACTIVE_CLASSES = ['bg-emerald-500', 'text-white', 'shadow-sm'];
        const INACTIVE_CLASSES = ['bg-transparent', 'text-slate-500', 'hover:bg-emerald-50', 'hover:text-emerald-600'];

        const tabLinks = Array.from(document.querySelectorAll('.tab-link'));
        const panels = Array.from(document.querySelectorAll('.tab-panel'));

        function activateTab(link) {
            tabLinks.forEach(btn => {
                btn.classList.remove(...ACTIVE_CLASSES);
                btn.classList.add(...INACTIVE_CLASSES);
            });
            link.classList.add(...ACTIVE_CLASSES);
            link.classList.remove(...INACTIVE_CLASSES);
        }

        function showPanel(id) {
            panels.forEach(panel => panel.classList.add('hidden'));
            const target = document.getElementById(id);
            target?.classList.remove('hidden');
        }

        if (tabLinks.length) {
            const hash = window.location.hash ? window.location.hash.substring(1) : null;
            const initialLink = hash
                ? document.querySelector(`.tab-link[data-tab-target="${hash}"]`)
                : tabLinks[0];

            if (initialLink) {
                activateTab(initialLink);
                showPanel(initialLink.dataset.tabTarget);
            }

            tabLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    const targetId = link.dataset.tabTarget;
                    if (!targetId) return;
                    activateTab(link);
                    showPanel(targetId);
                    history.replaceState(null, null, `#${targetId}`);
                });
            });
        }

        document.addEventListener('click', (event) => {
            const presenceButton = event.target.closest('.btn-presence');
            if (!presenceButton) return;
            

            event.preventDefault();
            const scheduleId = presenceButton.dataset.scheduleId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!scheduleId || !csrfToken) return;

            presenceButton.disabled = true;
            presenceButton.classList.add('opacity-70', 'cursor-not-allowed');

            fetch("{{ route('presence.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ schedule_id: scheduleId })
            })
            .then(res => {
                if (!res.ok) throw new Error('Server error');
                return res.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    presenceButton.outerHTML = `
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">
                            <i class="fas fa-check-circle"></i>
                            Sudah Presensi
                        </span>
                    `;
                } else {
                    alert(data.message || 'Gagal presensi');
                }
            })
            .catch(() => {
                alert('Tidak dapat terhubung ke server.');
                presenceButton.disabled = false;
                presenceButton.classList.remove('opacity-70', 'cursor-not-allowed');
            });
        });

        const modal = document.getElementById('uploadModal');
        const uploadForm = document.getElementById('uploadForm');
        const fileInput = uploadForm?.querySelector('input[type="file"]');

        function openModal() {
            modal?.classList.remove('hidden');
            modal?.classList.add('flex');
        }

        function closeModal() {
            modal?.classList.add('hidden');
            modal?.classList.remove('flex');
            if (fileInput) fileInput.value = '';
        }

        document.querySelectorAll('[data-upload-trigger]').forEach(trigger => {
            trigger.addEventListener('click', () => {
                const dutyId = trigger.dataset.dutyId;
                if (!uploadForm || !dutyId) return;
                uploadForm.action = `/duty/${dutyId}/upload`;
                openModal();
            });
        });

        document.querySelectorAll('[data-modal-close]').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        modal?.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>
@endpush
