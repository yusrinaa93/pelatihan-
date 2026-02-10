@extends('layouts.auth')

@section('title', 'Buat Akun - Pelatihan Pendamping Halal')

@section('form')
    <div class="space-y-8">
        <div class="space-y-2 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-700">
                Pendaftaran Peserta
            </span>
        </div>

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

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div class="space-y-2">
                <label for="name" class="text-sm font-semibold text-slate-600">Nama Lengkap</label>
                <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus-within:border-emerald-400 focus-within:ring-2 focus-within:ring-emerald-200">
                    <i class="fas fa-user text-slate-400"></i>
                    <input id="name"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           class="w-full border-none bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                           placeholder="Nama lengkap sesuai KTP">
                </div>
            </div>

            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold text-slate-600">Email</label>
                <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus-within:border-emerald-400 focus-within:ring-2 focus-within:ring-emerald-200">
                    <i class="fas fa-envelope text-slate-400"></i>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           class="w-full border-none bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                           placeholder="email@contoh.com">
                </div>
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-semibold text-slate-600">Password</label>
                <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus-within:border-emerald-400 focus-within:ring-2 focus-within:ring-emerald-200">
                    <i class="fas fa-lock text-slate-400"></i>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           class="w-full border-none bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                           placeholder="Minimal 8 karakter">
                    <button type="button"
                            class="text-slate-400 transition hover:text-emerald-500"
                            data-password-toggle="password">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-semibold text-slate-600">Konfirmasi Password</label>
                <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus-within:border-emerald-400 focus-within:ring-2 focus-within:ring-emerald-200">
                    <i class="fas fa-lock text-slate-400"></i>
                    <input id="password_confirmation"
                           type="password"
                           name="password_confirmation"
                           required
                           class="w-full border-none bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                           placeholder="Ulangi password">
                    <button type="button"
                            class="text-slate-400 transition hover:text-emerald-500"
                            data-password-toggle="password_confirmation">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="w-full rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                Buat Akun
            </button>
        </form>

        <p class="text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-500">
                Masuk sekarang
            </a>
        </p>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-password-toggle]').forEach(button => {
            const inputId = button.getAttribute('data-password-toggle');
            const input = document.getElementById(inputId);
            if (!input) return;

            button.addEventListener('click', () => {
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                button.innerHTML = isPassword
                    ? '<i class="fas fa-eye"></i>'
                    : '<i class="fas fa-eye-slash"></i>';
            });
        });
    });
</script>
@endpush