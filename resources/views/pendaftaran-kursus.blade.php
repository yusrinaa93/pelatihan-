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
                <label for="pelatihan_id" class="font-semibold text-slate-600">Pilih Pelatihan</label>
                <select id="pelatihan_id"
                        name="pelatihan_id"
                        required
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                    <option value="" disabled {{ empty($selected_course_id) ? 'selected' : '' }}>Pilih pelatihan</option>
                    @foreach(($courses ?? []) as $course)
                        <option value="{{ $course->id }}" {{ (isset($selected_course_id) && $selected_course_id == $course->id) ? 'selected' : '' }}>
                            {{ $course->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Data User (read-only, tidak perlu di-edit) --}}
            <div class="space-y-3 rounded-2xl bg-emerald-50 p-4 border border-emerald-200">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Informasi Peserta</p>
                <div class="grid gap-3 text-sm">
                    <div>
                        <span class="font-semibold text-slate-600">Nama:</span>
                        <span class="text-slate-700">{{ $user->name }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-600">Email:</span>
                        <span class="text-slate-700">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-600">Tempat Lahir:</span>
                        <span class="text-slate-700">{{ $user->tempat_lahir ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-600">Tanggal Lahir:</span>
                        <span class="text-slate-700">{{ $user->tanggal_lahir ? date('d M Y', strtotime($user->tanggal_lahir)) : '-' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-600">Nomor WhatsApp:</span>
                        <span class="text-slate-700">{{ $user->nomor_wa ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-600">Alamat:</span>
                        <span class="text-slate-700">{{ $user->alamat ?? '-' }}</span>
                    </div>
                </div>
                <p class="text-xs text-emerald-600 pt-2 border-t border-emerald-200">
                    <i class="fas fa-info-circle mr-1"></i>
                    Untuk mengubah data, silakan ke menu <strong>"Akun Saya"</strong>
                </p>
            </div>
            {{-- Hidden input untuk nama dan email --}}
            <input type="hidden" name="nama" value="{{ $user->name }}">
            <input type="hidden" name="email" value="{{ $user->email }}">

            {{-- TOMBOL SUBMIT DENGAN EFEK LOADING --}}
            <button type="submit"
                    id="btn-submit"
                    class="w-full rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-70">
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
        
        // 1. AMBIL TOMBOL & SIMPAN TEKS ASLI
        const btn = document.getElementById('btn-submit');
        const originalText = btn.innerHTML;

        // 2. UBAH JADI LOADING & DISABLE
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...';

        const formData = new FormData(this);
        const actionUrl = this.getAttribute('action');

        fetch(actionUrl, {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json' }
        })
        .then(response => {
            // Handle jika responsenya bukan JSON sukses langsung (misal 422 atau 500)
            if (!response.ok && response.status !== 422 && response.status !== 500) {
                 throw new Error('Network response was not ok.');
            }
            return response.json().then(data => {
                // Jika status code error (4xx/5xx), kita throw error manual biar masuk catch
                if (!response.ok) {
                     const error = new Error(data.message || 'Terjadi error.');
                     error.response = data;
                     throw error;
                }
                return data;
            });
        })
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    text: 'Selamat! Anda telah terdaftar pada kursus ini.',
                    confirmButtonText: 'Lanjutkan ke Halaman My Course',
                    confirmButtonColor: '#10b981',
                    allowOutsideClick: false // Biar user gak close sembarangan saat redirect
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/my-courses';
                    }
                });
                // Tombol TETAP DISABLED karena mau pindah halaman
            } else {
                // Jika logic sukses tapi status bukan 'success' (jarang terjadi)
                throw new Error(data.message || 'Gagal mendaftar.');
            }
        })
        .catch(error => {
            // 3. JIKA ERROR, KEMBALIKAN TOMBOL SEPERTI SEMULA
            btn.disabled = false;
            btn.innerHTML = originalText;

            let title = 'Terjadi Error!';
            let htmlContent = 'Silakan coba beberapa saat lagi.';
            
            // Cek apakah error validasi form (422)
            if (error.response && error.response.errors) {
                title = 'Data Tidak Valid!';
                htmlContent = '<ul class="list-disc space-y-1 pl-5 text-left text-sm">' +
                    Object.values(error.response.errors).map(e => `<li>${e[0]}</li>`).join('') +
                    '</ul>';
            } else if (error.response) {
                htmlContent = error.response.message;
            } else if (error.message) {
                htmlContent = error.message;
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