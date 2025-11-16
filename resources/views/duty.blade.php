@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Duty - My Courses')

@section('sidebar-extra')
    <li>
        <a href="{{ route('duty') }}"
           class="group flex items-center gap-3 rounded-xl px-4 py-3 transition bg-white text-emerald-600 shadow-lg shadow-emerald-900/20">
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
        <a href="{{ route('certificate') }}"
           class="group flex items-center gap-3 rounded-xl px-4 py-3 transition text-white/80 hover:bg-white/10">
            <i class="fas fa-certificate text-base"></i>
            <span>Certificate</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Tugas Pelatihan</p>
                <h1 class="text-2xl font-bold text-slate-900">Duty</h1>
                <p class="mt-2 text-sm text-slate-500">Unggah dan kelola pengumpulan tugas Anda di halaman ini.</p>
            </div>
            <div class="flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-600">
                <i class="fas fa-clipboard-list"></i>
                <span>{{ $duties->count() }} tugas</span>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/70 bg-white/95 p-6 shadow-lg shadow-slate-200/60">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex w-full max-w-xs items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm shadow-sm">
                    <i class="fas fa-search text-slate-400"></i>
                    <input type="text" placeholder="Cari tugas..." class="w-full border-none bg-transparent text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none" />
                </div>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Riwayat Tugas</span>
            </div>

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Deskripsi</th>
                            <th class="px-4 py-3 text-left">Deadline</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-slate-600">
                        @forelse ($duties as $duty)
                            <tr>
                                <td class="px-4 py-3 font-semibold text-slate-800">#{{ $duty->id }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-700">{{ $duty->name }}</td>
                                <td class="px-4 py-3">
                                    <div class="prose prose-sm max-w-none text-slate-600">{!! $duty->description !!}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $duty->deadline->translatedFormat('l, d F Y') }}</td>
                                <td class="px-4 py-3">
                                    @if(!empty($duty->submission) && !empty($duty->submission->file_path))
                                        <div class="flex flex-col gap-2">
                                            <a href="{{ $duty->submission->download_url }}"
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
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-400">
                                    Belum ada tugas yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
            <p class="mt-2 text-sm text-slate-500">Pilih berkas tugas Anda. Maksimum ukuran file 10 MB.</p>
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

