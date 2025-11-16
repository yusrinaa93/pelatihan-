@extends('layouts.base')

@section('title', 'Form Pendaftaran Course')

@section('body_class', 'bg-slate-100 text-slate-900 antialiased font-sans')

@section('body')
<div class="flex min-h-screen items-center justify-center px-4 py-12">
    <div class="w-full max-w-xl space-y-8 rounded-3xl border border-slate-200 bg-white/95 p-8 shadow-xl shadow-slate-200/60 backdrop-blur">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">Formulir Pendaftaran</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">Daftar Course</h1>
            </div>
            <a href="{{ route('courses') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-slate-500 hover:border-emerald-200 hover:text-emerald-600">
                <i class="fas fa-arrow-left text-xs"></i> Kembali
            </a>
        </div>

        <form id="registrationForm" action="{{ route('course.register.store') }}" method="POST" class="space-y-4 text-sm text-slate-600">
            @csrf
            <div class="space-y-2">
                <label for="course_id" class="font-semibold text-slate-600">Pilih Pelatihan</label>
                <select id="course_id"
                        name="course_id"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                    <option value="" disabled {{ empty($selected_course_id) ? 'selected' : '' }}>Pilih pelatihan</option>
                    @foreach(($courses ?? []) as $course)
                        <option value="{{ $course->id }}" {{ (isset($selected_course_id) && $selected_course_id == $course->id) ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <label class="space-y-2">
                    <span class="font-semibold text-slate-600">Nama Lengkap</span>
                    <input type="text"
                           id="nama"
                           name="nama"
                           value="{{ $user->name ?? '' }}"
                           required
                           class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                </label>
                <label class="space-y-2">
                    <span class="font-semibold text-slate-600">Email</span>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ $user->email ?? '' }}"
                           readonly
                           class="w-full cursor-not-allowed rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500">
                </label>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <label class="space-y-2">
                    <span class="font-semibold text-slate-600">Tempat Lahir</span>
                    <input type="text"
                           id="tempat_lahir"
                           name="tempat_lahir"
                           required
                           class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                </label>
                <label class="space-y-2">
                    <span class="font-semibold text-slate-600">Tanggal Lahir</span>
                    <input type="date"
                           id="tanggal_lahir"
                           name="tanggal_lahir"
                           required
                           class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                </label>
            </div>

            <label class="space-y-2">
                <span class="font-semibold text-slate-600">Nomor WhatsApp</span>
                <input type="text"
                       id="nomor_wa"
                       name="nomor_wa"
                       placeholder="+62..."
                       required
                       class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
            </label>

            <label class="space-y-2">
                <span class="font-semibold text-slate-600">Alamat Domisili</span>
                <textarea id="alamat"
                          name="alamat"
                          rows="3"
                          required
                          class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                          placeholder="Tulis alamat lengkap Anda"></textarea>
            </label>

            <button type="submit"
                    class="w-full rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                Daftar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const actionUrl = this.getAttribute('action');

        fetch(actionUrl, {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json' }
        })
        .then(response => {
            if (response.status === 422 || response.status === 500) {
                return response.json().then(data => {
                    const error = new Error(data.message || 'Terjadi error.');
                    error.response = data;
                    throw error;
                });
            }
            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    text: 'Selamat! Anda telah terdaftar pada kursus ini.',
                    confirmButtonText: 'Lanjutkan ke Halaman My Course',
                    confirmButtonColor: '#10b981'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/my-courses';
                    }
                });
            }
        })
        .catch(error => {
            let title = 'Terjadi Error!';
            let htmlContent = 'Silakan coba beberapa saat lagi.';
            if (error.response && error.response.errors) {
                title = 'Data Tidak Valid!';
                htmlContent = '<ul class="list-disc space-y-1 pl-5 text-left">' +
                    Object.values(error.response.errors).map(e => `<li>${e[0]}</li>`).join('') +
                    '</ul>';
            } else if (error.response) {
                htmlContent = error.response.message;
            }
            Swal.fire({
                icon: 'error',
                title: title,
                html: htmlContent,
            });
            console.error("Error:", error);
        });
    });
</script>
@endpush