@php($activeSidebar = 'account')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Account - Pelatihan Halal')

@section('content')
    <div class="space-y-8">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Pengaturan Akun</p>
            <h1 class="text-2xl font-bold text-slate-900">Profil Saya</h1>
            <p class="mt-2 text-sm text-slate-500">Perbarui informasi akun Anda untuk pengalaman belajar yang lebih personal.</p>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 px-4 py-3 text-sm font-semibold text-emerald-700">
                <i class="fas fa-circle-check mr-2"></i>{{ session('status') }}
            </div>
        @endif

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

        <div class="rounded-3xl border border-slate-200/70 bg-white/95 p-8 shadow-lg shadow-slate-200/60 lg:flex lg:gap-10">
            <aside class="flex w-full flex-col items-center rounded-3xl border border-slate-200 bg-slate-50/80 p-6 text-center lg:max-w-xs">
                <img src="https://via.placeholder.com/160"
                     alt="Avatar Pengguna"
                     class="h-32 w-32 rounded-full border-4 border-white shadow-lg shadow-slate-300">
                <h2 class="mt-4 text-lg font-semibold text-slate-800">{{ Auth::user()->name }}</h2>
                <p class="text-xs uppercase tracking-wide text-slate-400">{{ Auth::user()->email }}</p>
                <button type="button"
                        class="mt-6 inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-500 transition hover:border-emerald-200 hover:text-emerald-600">
                    <i class="fas fa-camera"></i>
                    Upload Picture
                </button>
            </aside>

            <section class="mt-8 flex-1 space-y-6 lg:mt-0">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Informasi Profil</h3>
                    <p class="text-sm text-slate-500">Data ini ditampilkan pada proses administrasi pelatihan.</p>
                </div>

                <form action="{{ route('account') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid gap-5 md:grid-cols-2">
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Nama Lengkap
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', Auth::user()->name) }}"
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Alamat Email
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ Auth::user()->email }}"
                                   readonly
                                   class="cursor-not-allowed rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500">
                        </label>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Password Saat Ini
                            <input type="password"
                                   id="current_password"
                                   name="current_password"
                                   placeholder="Masukkan password saat ini"
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>
                        <label class="flex flex-col gap-2 text-sm font-semibold text-slate-600">
                            Password Baru
                            <input type="password"
                                   id="new_password"
                                   name="new_password"
                                   placeholder="Kosongkan jika tidak mengganti"
                                   class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </label>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            <i class="fas fa-save text-xs"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection