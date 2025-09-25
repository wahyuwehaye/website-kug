@extends('layouts.web')

@php($title = $program->getTranslation('name', $activeLocale))

@section('content')
    <section class="section-shell max-w-5xl">
        <nav class="text-xs text-slate-400">
            <a href="{{ route('home', ['locale' => $activeLocale]) }}" class="hover:text-amber-200">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="hover:text-amber-200">{{ trans('web.programs.title') }}</a>
            <span class="mx-1">/</span>
            <span class="text-slate-300">{{ $program->getTranslation('name', $activeLocale) }}</span>
        </nav>

        <header class="glass-panel mt-6 space-y-4 p-8">
            <p class="text-xs uppercase tracking-[0.35em] text-amber-200">{{ trans('web.program_types.' . $program->type) }}</p>
            <h1 class="text-3xl font-semibold text-white">{{ $program->getTranslation('name', $activeLocale) }}</h1>
            @if($program->getTranslation('summary', $activeLocale))
                <p class="text-sm text-slate-200">{{ $program->getTranslation('summary', $activeLocale) }}</p>
            @endif
            <div class="flex flex-wrap gap-3 text-xs">
                @if($program->external_url)
                    <a href="{{ $program->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-3 py-1 font-semibold text-slate-900 transition hover:bg-amber-300">
                        {{ __('Portal Layanan') }}
                    </a>
                @endif
                @if($program->is_featured)
                    <span class="rounded-full border border-white/20 px-3 py-1 font-semibold text-slate-200">Featured</span>
                @endif
            </div>
        </header>

        <article class="prose-invert mt-8">
            {!! $program->getTranslation('body', $activeLocale) !!}
        </article>

        @if($relatedPrograms->isNotEmpty())
            <section class="mt-12 border-t border-white/10 pt-8">
                <h2 class="text-xl font-semibold text-white">{{ __('Program terkait') }}</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    @foreach($relatedPrograms as $related)
                        <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $related]) }}" class="glass-tile hover-raise border-white/10 bg-white/5 p-4 text-sm text-slate-200">
                            <p class="text-xs uppercase tracking-[0.35em] text-amber-200">{{ trans('web.program_types.' . $related->type) }}</p>
                            <p class="mt-1 font-semibold text-white">{{ $related->getTranslation('name', $activeLocale) }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </section>
@endsection
