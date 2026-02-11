@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Materi Pelatihan - ' . $course->judul)

@section('content')
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Materi Pelatihan</p>
                <h1 class="text-2xl font-bold text-slate-900">{{ $course->judul }}</h1>
                <p class="mt-2 text-sm text-slate-500">Akses jadwal, presensi, tugas dan ujian Anda.</p>
            </div>
            <div class="self-start sm:self-auto">
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                    <i class="fas fa-layer-group text-sm"></i>
                    Batch Aktif
                </div>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200/70 bg-white/95 shadow-lg shadow-slate-200/60">
            {{-- Navigation Tabs --}}
            <nav class="flex flex-wrap gap-2 border-b border-slate-200/70 bg-white/80 px-4 py-3 text-sm font-semibold">
                <button type="button"
                        class="tab-link inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-white shadow-sm transition-all"
                        data-tab-target="tab-zoom">
                    <i class="fas fa-video text-xs"></i>
                    Jadwal & Zoom
                </button>
                <button type="button"
                        class="tab-link inline-flex items-center gap-2 rounded-full px-4 py-2 text-slate-500 transition-all hover:bg-emerald-50 hover:text-emerald-600"
                        data-tab-target="tab-presensi">
                    <i class="fas fa-clipboard-check text-xs"></i>
                    Presensi
                </button>
                <button type="button"
                        class="tab-link inline-flex items-center gap-2 rounded-full px-4 py-2 text-slate-500 transition-all hover:bg-emerald-50 hover:text-emerald-600"
                        data-tab-target="tab-tugas">
                    <i class="fas fa-tasks text-xs"></i>
                    Tugas
                </button>
                <button type="button"
                        class="tab-link inline-flex items-center gap-2 rounded-full px-4 py-2 text-slate-500 transition-all hover:bg-emerald-50 hover:text-emerald-600"
                        data-tab-target="tab-ujian">
                    <i class="fas fa-file-signature text-xs"></i>
                    Ujian
                </button>
            </nav>

            <div class="tab-panels space-y-8 p-4 sm:p-6">

                {{-- TAB: JADWAL & ZOOM --}}
                <div id="tab-zoom" class="tab-panel space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Jadwal Zoom Meeting</h2>
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        {{-- Wrapper Responsif untuk Tabel --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">No</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Tanggal</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Waktu</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Kategori</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Zoom</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                                    @forelse($schedules as $schedule)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-slate-800">{{ $loop->iteration }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">{{ $schedule->waktu_mulai?->translatedFormat('l, d F Y') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                {{ $schedule->waktu_mulai?->format('H:i') }} - {{ $schedule->waktu_selesai?->format('H:i') }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3">{{ $schedule->kategori }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                @if($schedule->tautan_zoom)
                                                    <a href="{{ $schedule->tautan_zoom }}" target="_blank"
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
                </div>

                {{-- TAB: PRESENSI --}}
                <div id="tab-presensi" class="tab-panel hidden space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Presensi</h2>
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        {{-- Wrapper Responsif untuk Tabel --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">No</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Tanggal</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Waktu</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Materi</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Jam Presensi</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                                    @forelse($schedules as $schedule)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-slate-800">{{ $loop->iteration }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">{{ $schedule->waktu_mulai?->translatedFormat('l, d F Y') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">{{ $schedule->waktu_mulai?->format('H:i') }} - {{ $schedule->waktu_selesai?->format('H:i') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">{{ $schedule->kategori }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">{{ $schedule->waktu_mulai?->format('H:i') }} - {{ $schedule->waktu_selesai?->format('H:i') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
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
                </div>

                {{-- TAB: TUGAS --}}
                <div id="tab-tugas" class="tab-panel hidden space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h2 class="text-lg font-semibold text-slate-900">Tugas</h2>
                    </div>
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        {{-- Wrapper Responsif untuk Tabel --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">No</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Nama</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left min-w-[200px]">Deskripsi</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">File Tugas</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Deadline</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                                    @forelse ($duties as $duty)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-slate-800">{{ $loop->iteration }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700">{{ $duty->name }}</td>
                                            <td class="px-4 py-3 min-w-[200px]">
                                                @if($duty->description)
                                                    <div class="prose prose-sm max-w-none text-slate-600 line-clamp-2 hover:line-clamp-none">{!! $duty->description !!}</div>
                                                @else
                                                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                        Tidak ada deskripsi
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                @if($duty->attachment_path)
                                                    <a href="{{ route('duties.download', $duty) }}"
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
                                            <td class="whitespace-nowrap px-4 py-3">
                                                <div class="flex flex-col">
                                                    <span class="font-semibold text-slate-700">
                                                        {{ $duty->deadline->translatedFormat('l, d F Y') }}
                                                    </span>
                                                    <span class="text-xs text-slate-500">
                                                        Pukul {{ $duty->deadline->format('H:i') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                {{-- Cek apakah sudah ada submission dan filenya --}}
                                                @if($duty->submission && $duty->submission->path_file)
                                                    <div class="flex flex-col items-start gap-2">

                                                        {{-- TAMPILAN FILE (Klik untuk download) --}}
                                                        <a href="{{ route('duty-submissions.download', $duty->submission->id) }}"
                                                        class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 transition hover:border-emerald-300 hover:bg-emerald-50 hover:shadow-sm">

                                                            {{-- Icon File --}}
                                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white shadow-sm ring-1 ring-slate-900/5 group-hover:bg-emerald-100 group-hover:text-emerald-600">
                                                                <i class="fas fa-file-lines text-emerald-500 transition group-hover:text-emerald-600"></i>
                                                            </div>

                                                            {{-- Info File --}}
                                                            <div class="flex flex-col">
                                                                <span class="text-xs font-semibold text-slate-700 group-hover:text-emerald-800">
                                                                    {{ Str::limit($duty->submission->nama_file_asli, 25) }}
                                                                </span>
                                                                <span class="text-[10px] text-slate-400 group-hover:text-emerald-600">
                                                                    Diunggah {{ $duty->submission->updated_at->diffForHumans() }}
                                                                </span>
                                                            </div>
                                                        </a>
                                                    </div>

                                                @elseif($duty->can_submit)
                                                    {{-- Kondisi: Belum Upload (Tampilkan Tombol Upload) --}}
                                                    <form action="{{ route('duty.upload', $duty->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2" data-duty-upload-form>
                                                        @csrf
                                                        <input type="file" name="file" required class="hidden" data-duty-file-input />
                                                        <button type="button"
                                                                class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow transition hover:bg-emerald-400 hover:shadow-md"
                                                                data-duty-upload-trigger>
                                                            <i class="fas fa-cloud-arrow-up"></i>
                                                            Upload Tugas
                                                        </button>
                                                    </form>

                                                @else
                                                    {{-- Kondisi: Deadline Lewat & Belum Upload --}}
                                                    <span class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-rose-500 ring-1 ring-inset ring-rose-200">
                                                        <i class="fas fa-lock"></i>
                                                        Terkunci
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-400">Belum ada tugas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- TAB: UJIAN --}}
                <div id="tab-ujian" class="tab-panel hidden space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Ujian</h2>
                    <div class="space-y-4">
                        @forelse($exams as $exam)
                            <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 px-5 py-4 shadow-sm shadow-slate-200/50 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-slate-800">{{ $exam->judul }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ $exam->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                                    @if($exam->batas_waktu)
                                        <div class="mt-2 inline-flex flex-wrap items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold
                                            {{ $exam->is_deadline_passed ? 'bg-rose-100 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                                            <i class="fas fa-clock"></i>
                                            <span>
                                                Deadline: {{ $exam->batas_waktu->translatedFormat('d F Y') }}  {{ $exam->batas_waktu->format('H:i') }} WIB
                                            </span>
                                        </div>
                                    @endif

                                    <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        {{ $exam->questions_count }} Soal
                                    </p>
                                </div>
                                <div class="self-start sm:self-center">
                                    @if ($exam->is_completed)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                                            <i class="fas fa-circle-check"></i>
                                            Selesai
                                        </span>
                                    @elseif ($exam->is_deadline_passed)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-rose-700">
                                            <i class="fas fa-ban"></i>
                                            Ditutup
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

    {{-- Upload Modal --}}
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

        // --- 1. CEK SESSION LARAVEL (UNTUK UPLOAD TUGAS) ---
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Validasi',
                html: '<ul class="text-left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        @endif
        // ---------------------------------------------------------------------


        // --- 2. LOGIKA TABS ---
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

        // --- 3. LOGIKA PRESENSI DENGAN SWEETALERT2 (AJAX) ---
        document.addEventListener('click', (event) => {
            const presenceButton = event.target.closest('.btn-presence');
            if (!presenceButton) return;

            event.preventDefault();
            const scheduleId = presenceButton.dataset.scheduleId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!scheduleId || !csrfToken) return;

            // Tampilkan Loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang mencatat presensi Anda',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

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
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(({ status, body }) => {
                if (body.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: body.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    presenceButton.outerHTML = `
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">
                            <i class="fas fa-check-circle"></i>
                            Sudah Presensi
                        </span>
                    `;
                } else if (body.status === 'warning') {
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: body.message });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: body.message });
                }
            })
            .catch(error => {
                console.error(error);
                Swal.fire({ icon: 'error', title: 'Error Sistem', text: 'Terjadi kesalahan jaringan.' });
            })
            .finally(() => {
                if (document.body.contains(presenceButton)) {
                    presenceButton.disabled = false;
                    presenceButton.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            });
        });

        // --- 4. LOGIKA MODAL UPLOAD TUGAS ---
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

        document.querySelectorAll('[data-duty-upload-trigger]').forEach(trigger => {
            trigger.addEventListener('click', () => {
                const dutyId = trigger.dataset.dutyId; // Pastikan di HTML ada data-duty-id

                // Jika tombol trigger ada di dalam form (versi tanpa modal), biarkan logic form yang handle
                if(trigger.closest('form[data-duty-upload-form]')) return;

                if (!uploadForm) return;
                // Jika pakai modal, set actionnya
                // uploadForm.action = ...
                openModal();
            });
        });

        document.querySelectorAll('[data-modal-close]').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        modal?.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });

        // --- 5. LOGIKA SUBMIT FILE TUGAS (FORM LANGSUNG) ---
        document.querySelectorAll('form[data-duty-upload-form]').forEach((form) => {
            const input = form.querySelector('[data-duty-file-input]');
            const trigger = form.querySelector('[data-duty-upload-trigger]');

            if (!input || !trigger) return;

            // 1. Klik tombol "Upload" -> Buka File Picker
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                input.click();
            });

            // 2. Saat file dipilih -> Submit Form
            input.addEventListener('change', () => {
                const file = input.files && input.files[0] ? input.files[0] : null;
                if (!file) return;

                // Tampilkan Loading
                Swal.fire({
                    title: 'Mengunggah...',
                    text: 'Mohon tunggu sebentar...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Update UI Tombol
                trigger.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Mengunggah...`;
                trigger.disabled = true;
                trigger.classList.add('opacity-70', 'cursor-not-allowed');

                // Submit Form
                form.submit();
            });
        });

    }); // <-- INI YANG TADI HILANG (Penutup DOMContentLoaded)
</script>
@endpush
