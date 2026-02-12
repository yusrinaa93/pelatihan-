@php($activeSidebar = 'account')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Account - Pelatihan Halal')

@section('content')
    <div class="space-y-8">
        {{-- Header Halaman --}}
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Pengaturan Akun</p>
            <h1 class="text-2xl font-bold text-slate-900">Profil Saya</h1>
            <p class="mt-2 text-sm text-slate-500">Perbarui informasi akun Anda untuk pengalaman belajar yang lebih personal.</p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 px-4 py-3 text-sm font-semibold text-emerald-700">
                <i class="fas fa-circle-check mr-2"></i>{{ session('status') }}
            </div>
        @endif

        {{-- Notifikasi Info --}}
        @if (session('info'))
            <div class="rounded-2xl border border-blue-200 bg-blue-50/80 px-4 py-3 text-sm font-semibold text-blue-700">
                <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
            </div>
        @endif

        {{-- Notifikasi Warning --}}
        @if (session('warning'))
            <div class="rounded-2xl border border-amber-200 bg-amber-50/80 px-4 py-3 text-sm font-semibold text-amber-700">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
            </div>
        @endif

        {{-- Alert jika profil belum lengkap --}}
        @if (!Auth::user()->profile_completed)
            <div class="rounded-2xl border border-amber-300 bg-amber-100/80 px-4 py-3 text-sm font-semibold text-amber-800">
                <i class="fas fa-warning mr-2"></i>
                <strong>Penting:</strong> Profil Anda belum lengkap. Lengkapi semua data di bawah ini agar bisa mendaftar pelatihan.
            </div>
        @endif

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50/80 px-4 py-3 text-sm text-rose-700">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-start gap-2">
                            <i class="fas fa-circle-exclamation mt-0.5 text-xs"></i>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Layout Grid --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">

            {{-- KOLOM KIRI: Sidebar Tab --}}
            <aside class="lg:col-span-1">
                <nav class="space-y-2 sticky top-24">
                    {{-- Tab Profil --}}
                    <a href="#profil"
                       data-tab-toggle="profil"
                       class="tab-link group flex items-center gap-3 rounded-xl bg-emerald-100 px-4 py-3 text-emerald-700 transition">
                        <i class="fas fa-user-circle text-base"></i>
                        <span class="font-medium">Profil</span>
                    </a>
                    {{-- Tab Password --}}
                    <a href="#password"
                       data-tab-toggle="password"
                       class="tab-link group flex items-center gap-3 rounded-xl px-4 py-3 text-slate-700 transition hover:bg-slate-100">
                        <i class="fas fa-lock text-base"></i>
                        <span class="font-medium">Ganti Password</span>
                    </a>
                </nav>
            </aside>

            {{-- KOLOM KANAN: Konten Form --}}
            <div class="lg:col-span-3">

                {{-- TAB 1: FORM PROFIL --}}
                <section id="profil" class="tab-content">
                    <form action="{{ route('account.updateProfile') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="rounded-3xl border border-slate-200/70 bg-white/95 p-8 shadow-lg shadow-slate-200/60 space-y-6">
                        @csrf
                        @method('PATCH')

                        <h3 class="text-lg font-semibold text-slate-900">Informasi Profil</h3>

                        {{-- BAGIAN FOTO PROFIL --}}
                        <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                            <img id="avatar-preview"
                                src="{{ Auth::user()->avatar ? \Illuminate\Support\Facades\Storage::disk('public')->url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=10b981&color=fff' }}"
                                 alt="Avatar Pengguna"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff';"
                                 class="h-24 w-24 rounded-full border-4 border-white object-cover shadow-lg">

                            <div class="flex flex-col gap-1">
                                <div class="flex gap-3">
                                    <input type="file" name="avatar" id="avatar-upload" class="hidden" accept="image/*">
                                    <label for="avatar-upload"
                                           class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-emerald-600">
                                        <i class="fas fa-camera text-xs"></i>
                                        Ganti Foto
                                    </label>
                                </div>
                                <p class="text-xs text-slate-400 ml-1">JPG, PNG atau GIF. Maks 2MB.</p>
                            </div>
                        </div>
                        {{-- NIK --}}
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            NIK
                            <input type="text"
                                   name="nik"
                                   value="{{ old('nik', Auth::user()->nik ?? '') }}"
                                   placeholder="Nomor Induk Kependudukan"
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>

                        {{-- Input Nama --}}
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Nama Lengkap
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', Auth::user()->name) }}"
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>

                        {{-- Input Email --}}
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Alamat Email
                            <input type="email"
                                   name="email"
                                   value="{{ Auth::user()->email }}"
                                   readonly
                                   class="cursor-not-allowed rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500">
                            {{-- Catatan: 'name="email"' wajib ada meski readonly agar lolos validasi 'required' di controller --}}
                        </label>

                        {{-- DIVIDER --}}
                        <div class="border-t border-slate-200 pt-6">
                            <h4 class="text-base font-semibold text-slate-900 mb-4">Informasi Tambahan</h4>
                            <p class="text-xs text-slate-500 mb-4">Lengkapi data berikut untuk melengkapi profil Anda sebelum mendaftar pelatihan.</p>
                        </div>

                        {{-- Tempat Lahir & Tanggal Lahir --}}
                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                                Tempat Lahir
                                <input type="text"
                                       name="tempat_lahir"
                                       value="{{ old('tempat_lahir', Auth::user()->tempat_lahir ?? '') }}"
                                       placeholder="e.g. Jakarta"
                                       class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </label>
                            <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                                Tanggal Lahir
                                <input type="date"
                                       name="tanggal_lahir"
                                       value="{{ old('tanggal_lahir', Auth::user()->tanggal_lahir ?? '') }}"
                                       class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </label>
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Nomor WhatsApp
                            <input type="text"
                                   name="nomor_wa"
                                   value="{{ old('nomor_wa', Auth::user()->nomor_wa ?? '') }}"
                                   placeholder="e.g. 08123456789"
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>
                        {{-- Alamat Domisili --}}
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600"">
                            Alamat
                            <textarea name="alamat"
                                      rows="3"
                                      placeholder="Tulis alamat lengkap Anda"
                                      class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">{{ old('alamat', Auth::user()->alamat ?? '') }}</textarea>
                        </label>
                        {{-- Provinsi / Kabupaten / Kecamatan / Kode Pos --}}
                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                                Provinsi
                                <input type="text"
                                       name="provinsi"
                                       value="{{ old('provinsi', Auth::user()->provinsi ?? '') }}"
                                       placeholder="e.g. DI Yogyakarta"
                                       class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </label>

                            <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                                Kabupaten/Kota
                                <input type="text"
                                       name="kabupaten"
                                       value="{{ old('kabupaten', Auth::user()->kabupaten ?? '') }}"
                                       placeholder="e.g. Sleman"
                                       class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </label>

                            <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                                Kecamatan
                                <input type="text"
                                       name="kecamatan"
                                       value="{{ old('kecamatan', Auth::user()->kecamatan ?? '') }}"
                                       placeholder="e.g. Depok"
                                       class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </label>

                            <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                                Kode Pos
                                <input type="text"
                                       name="kodepos"
                                       value="{{ old('kodepos', Auth::user()->kodepos ?? '') }}"
                                       placeholder="e.g. 55281"
                                       class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </label>

                        </div>

                        <div class="flex items-center justify-end border-t border-slate-200 pt-6">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                <i class="fas fa-save text-xs"></i>
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </section>

                {{-- TAB 2: FORM PASSWORD --}}
                <section id="password" class="tab-content hidden">
                    <form action="{{ route('account.updatePassword') }}"
                          method="POST"
                          class="rounded-3xl border border-slate-200/70 bg-white/95 p-8 shadow-lg shadow-slate-200/60 space-y-6">
                        @csrf
                        @method('PATCH')

                        <h3 class="text-lg font-semibold text-slate-900">Ganti Password</h3>
                        <p class="text-sm text-slate-500">Pastikan Anda menggunakan password yang kuat dan mudah diingat.</p>

                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Password Saat Ini
                            <input type="password"
                                   name="current_password"
                                   placeholder="Masukkan password saat ini"
                                   required
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>

                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Password Baru
                            <input type="password"
                                   name="new_password"
                                   placeholder="Minimal 8 karakter"
                                   required
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>

                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Konfirmasi Password Baru
                            <input type="password"
                                   name="new_password_confirmation"
                                   placeholder="Ulangi password baru"
                                   required
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>

                        <div class="flex items-center justify-end border-t border-slate-200 pt-6">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                <i class="fas fa-save text-xs"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </section>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Script Preview Gambar
    document.addEventListener('DOMContentLoaded', () => {
        const avatarUpload = document.getElementById('avatar-upload');
        const avatarPreview = document.getElementById('avatar-preview');
        if (avatarUpload && avatarPreview) {
            avatarUpload.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    // Script Tab Switching
    document.addEventListener('DOMContentLoaded', () => {
        const tabLinks = document.querySelectorAll('[data-tab-toggle]');
        const tabContents = document.querySelectorAll('.tab-content');

        const activeTab = window.location.hash.substring(1) || 'profil';
        updateTabs(activeTab);

        tabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const tabId = link.getAttribute('data-tab-toggle');
                history.replaceState(null, null, ' #' + tabId);
                updateTabs(tabId);
            });
        });

        function updateTabs(tabId) {
            tabLinks.forEach(link => {
                if (link.getAttribute('data-tab-toggle') === tabId) {
                    link.classList.add('bg-emerald-100', 'text-emerald-700');
                    link.classList.remove('text-slate-700', 'hover:bg-slate-100');
                } else {
                    link.classList.remove('bg-emerald-100', 'text-emerald-700');
                    link.classList.add('text-slate-700', 'hover:bg-slate-100');
                }
            });

            tabContents.forEach(content => {
                if (content.id === tabId) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush
