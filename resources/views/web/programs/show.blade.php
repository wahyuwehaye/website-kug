@extends('layouts.web')

@php($title = $program->getTranslation('name', $activeLocale))

@section('content')
    <section class="bg-white py-12">
        <div class="mx-auto max-w-5xl px-4">
            <nav class="text-xs text-slate-500">
                <a href="{{ route('home', ['locale' => $activeLocale]) }}" class="hover:text-primary-600">Home</a>
                <span class="mx-1">/</span>
                <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="hover:text-primary-600">{{ trans('web.programs.title') }}</a>
                <span class="mx-1">/</span>
                <span class="text-slate-700">{{ $program->getTranslation('name', $activeLocale) }}</span>
            </nav>

            <header class="mt-6 rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 p-8 text-white shadow">
                <p class="text-xs uppercase tracking-wide text-primary-100">{{ trans('web.program_types.' . $program->type) }}</p>
                <h1 class="mt-2 text-3xl font-bold">{{ $program->getTranslation('name', $activeLocale) }}</h1>
                @if($program->getTranslation('summary', $activeLocale))
                    <p class="mt-3 text-sm text-primary-100">{{ $program->getTranslation('summary', $activeLocale) }}</p>
                @endif
                <div class="mt-4 flex flex-wrap gap-3 text-xs">
                    @if($program->external_url)
                        <a href="{{ $program->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-white/20 px-3 py-1 font-semibold text-white hover:bg-white/30">
                            {{ __('Portal Layanan') }}
                        </a>
                    @endif
                    @if($program->is_featured)
                        <span class="rounded-full bg-white/15 px-3 py-1 font-semibold">Featured</span>
                    @endif
                </div>
            </header>

            <article class="prose prose-slate mt-8 max-w-none prose-headings:text-slate-900">
                {!! $program->getTranslation('body', $activeLocale) !!}
            </article>

            @if($relatedPrograms->isNotEmpty())
                <section class="mt-12 border-t border-slate-200 pt-8">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('Program terkait') }}</h2>
                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        @foreach($relatedPrograms as $related)
                            <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $related]) }}" class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 hover:border-primary-200 hover:text-primary-600">
                                <p class="text-xs uppercase tracking-wide text-primary-600">{{ trans('web.program_types.' . $related->type) }}</p>
                                <p class="mt-1 font-semibold">{{ $related->getTranslation('name', $activeLocale) }}</p>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>
@endsection
