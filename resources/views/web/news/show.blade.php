@extends('layouts.web')

@php($title = $post->getTranslation('title', $activeLocale))

@section('content')
    <article class="section-shell max-w-4xl">
        <nav class="text-xs text-slate-400">
            <a href="{{ route('home', ['locale' => $activeLocale]) }}" class="hover:text-amber-200">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('news.index', ['locale' => $activeLocale]) }}" class="hover:text-amber-200">{{ trans('web.news.title') }}</a>
            <span class="mx-1">/</span>
            <span class="text-slate-300">{{ $post->getTranslation('title', $activeLocale) }}</span>
        </nav>

        <header class="glass-panel mt-6 space-y-4 p-8">
            <p class="text-xs uppercase tracking-[0.35em] text-amber-200">{{ $post->category?->getTranslation('name', $activeLocale) ?? trans('web.news.title') }}</p>
            <h1 class="text-3xl font-semibold text-white">{{ $post->getTranslation('title', $activeLocale) }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-300">
                <span>{{ trans('web.news.published_at') }} {{ $post->published_at?->translatedFormat('d F Y H:i') }}</span>
                @if($post->author_name)
                    <span>{{ __('Oleh') }} {{ $post->author_name }}</span>
                @endif
                <span>{{ $post->read_time_minutes }} {{ __('menit baca') }}</span>
            </div>
        </header>

        @if($post->cover_image_path)
            <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="mt-6 w-full rounded-3xl border border-white/10 shadow-lg shadow-black/40 object-cover" />
        @endif

        <div class="prose-invert mt-8">
            {!! $post->getTranslation('body', $activeLocale) !!}
        </div>

        @if($post->attachment_path)
            <div class="mt-8 glass-tile border-white/10 bg-white/5 p-6">
                <h2 class="text-lg font-semibold text-white">Lampiran</h2>
                <a href="{{ asset('storage/'.$post->attachment_path) }}" class="mt-3 inline-flex items-center gap-2 rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-300" download>
                    {{ __('Unduh Lampiran') }}
                    <x-ui.icon name="arrow-right" class="h-4 w-4 rotate-90" />
                </a>
            </div>
        @endif

        @if($relatedPosts->isNotEmpty())
            <section class="mt-12 border-t border-white/10 pt-8">
                <h2 class="text-xl font-semibold text-white">{{ __('Berita terkait') }}</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $related]) }}" class="glass-tile hover-raise border-white/10 bg-white/5 p-4 text-sm text-slate-200">
                            <p class="text-xs uppercase tracking-[0.35em] text-amber-200">{{ $related->category?->getTranslation('name', $activeLocale) }}</p>
                            <p class="mt-1 font-semibold text-white">{{ \Illuminate\Support\Str::limit($related->getTranslation('title', $activeLocale), 90) }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $related->published_at?->translatedFormat('d F Y') }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </article>
@endsection
