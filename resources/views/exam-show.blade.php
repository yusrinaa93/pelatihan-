@php($activeSidebar = 'my-courses')
@php($activeNav = 'courses')
@extends('layouts.dashboard')

@section('title', 'Kerjakan Ujian - ' . $exam->title)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-500">Kerjakan Ujian</p>
                <h1 class="text-2xl font-bold text-slate-900">{{ $exam->title }}</h1>
                <p class="mt-2 text-sm text-slate-500">{{ $exam->description ?? 'Jawab seluruh pertanyaan berikut dengan teliti.' }}</p>

                @if($exam->deadline)
                    <div class="mt-4 inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-semibold
                        {{ $exam->is_deadline_passed ? 'bg-rose-100 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                        <i class="fas {{ $exam->is_deadline_passed ? 'fa-circle-xmark' : 'fa-clock' }}"></i>
                        <span>
                            Deadline: {{ $exam->deadline->translatedFormat('l, d F Y') }} • {{ $exam->deadline->format('H:i') }} WIB
                        </span>
                    </div>
                @endif
            </div>
        </div>

        @if($exam->is_deadline_passed)
            <div class="rounded-3xl border border-rose-200 bg-rose-50/80 px-6 py-4 text-sm text-rose-700">
                <div class="flex items-start gap-3">
                    <i class="fas fa-triangle-exclamation mt-0.5"></i>
                    <div>
                        <p class="font-semibold">Ujian sudah ditutup.</p>
                        <p class="mt-1">Deadline sudah terlewati, Anda tidak dapat mengumpulkan jawaban.</p>
                    </div>
                </div>
            </div>
        @endif

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
                            @if($exam->is_deadline_passed) disabled @endif
                            class="inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg transition focus:outline-none focus:ring-2 focus:ring-emerald-200
                                {{ $exam->is_deadline_passed ? 'bg-slate-300 cursor-not-allowed shadow-slate-200/0' : 'bg-emerald-500 shadow-emerald-500/40 hover:bg-emerald-400' }}">
                        <i class="fas fa-paper-plane"></i>
                        Kumpulkan Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection