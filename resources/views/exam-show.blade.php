@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Kerjakan Ujian - ' . $exam->title)

{{-- 
  Blok @section('sidebar-extra') telah dihapus
  karena rute-rute tersebut sudah tidak digunakan lagi.
--}}

@section('content')
    <div class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Kerjakan Ujian</p>
                <h1 class="text-2xl font-bold text-slate-900">{{ $exam->title }}</h1>
                <p class="mt-2 text-sm text-slate-500">{{ $exam->description ?? 'Jawab seluruh pertanyaan berikut dengan teliti.' }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/70 bg-white/95 p-6 shadow-lg shadow-slate-200/60">
            <form action="{{ route('exams.submit', $exam->id) }}" method="POST" class="space-y-6">
                @csrf

                @foreach($exam->questions as $index => $question)
                    <fieldset class="rounded-2xl border border-slate-200 bg-white/90 p-5 shadow-sm shadow-slate-200/50">
                        <legend class="flex items-center gap-3 text-base font-semibold text-slate-800">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-600">
                                {{ $index + 1 }}
                            </span>
                            <span>{{ $question->question_text }}</span>
                        </legend>
                        <div class="mt-4 space-y-3">
                            @foreach($question->options as $option)
                                <label for="option-{{ $option->id }}"
                                       class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 shadow-sm transition hover:border-emerald-300">
                                    <input type="radio"
                                           id="option-{{ $option->id }}"
                                           name="answers[{{ $question->id }}]"
                                           value="{{ $option->id }}"
                                           required
                                           class="mt-1 h-4 w-4 border-slate-300 text-emerald-500 focus:ring-emerald-300">
                                    <span>{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                @endforeach

                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        <i class="fas fa-paper-plane"></i>
                        Kumpulkan Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection