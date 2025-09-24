@extends('layouts.web')

@php($title = $post->getTranslation('title', $activeLocale))

@section('content')
    <article class="bg-white py-12">
        <div class="mx-auto max-w-4xl px-4">
            <nav class="text-xs text-slate-500">
                <a href="{{ route('home', ['locale' => $activeLocale]) }}" class="hover:text-primary-600">Home</a>
                <span class="mx-1">/</span>
                <a href="{{ route('news.index', ['locale' => $activeLocale]) }}" class="hover:text-primary-600">{{ trans('web.news.title') }}</a>
                <span class="mx-1">/</span>
                <span class="text-slate-700">{{ $post->getTranslation('title', $activeLocale) }}</span>
            </nav>

            <header class="mt-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">{{ $post->category?->getTranslation('name', $activeLocale) ?? trans('web.news.title') }}</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $post->getTranslation('title', $activeLocale) }}</h1>
                <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                    <span>{{ trans('web.news.published_at') }} {{ $post->published_at?->translatedFormat('d F Y H:i') }}</span>
                    @if($post->author_name)
                        <span>Oleh {{ $post->author_name }}</span>
                    @endif
                    <span>{{ $post->read_time_minutes }} menit baca</span>
                </div>
            </header>

            @if($post->cover_image_path)
                <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="mt-8 w-full rounded-3xl object-cover shadow" />
            @endif

            <div class="prose prose-slate mt-8 max-w-none prose-headings:text-slate-900">
                {!! $post->getTranslation('body', $activeLocale) !!}
            </div>

            @if($post->attachment_path)
                <div class="mt-8 rounded-2xl bg-slate-50 p-6">
                    <h2 class="text-lg font-semibold text-slate-900">Lampiran</h2>
                    <a href="{{ asset('storage/'.$post->attachment_path) }}" class="mt-3 inline-flex items-center gap-2 rounded-full bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500" download>
                        Unduh Lampiran
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v3.75a1.5 1.5 0 01-1.5 1.5h-12a1.5 1.5 0 01-1.5-1.5v-3.75" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5l-4.5 4.5-4.5-4.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v10.5" />
                        </svg>
                    </a>
                </div>
            @endif

            @if($relatedPosts->isNotEmpty())
                <section class="mt-12 border-t border-slate-200 pt-8">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('Berita terkait') }}</h2>
                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $related]) }}" class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 hover:border-primary-200 hover:text-primary-600">
                                <p class="text-xs uppercase tracking-wide text-primary-600">{{ $related->category?->getTranslation('name', $activeLocale) }}</p>
                                <p class="mt-1 font-semibold line-clamp-2">{{ $related->getTranslation('title', $activeLocale) }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $related->published_at?->translatedFormat('d F Y') }}</p>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </article>
@endsection
