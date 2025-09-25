@extends('layouts.web')

@php($title = trans('web.news.title'))

@section('content')
    <section class="section-shell">
        <div class="glass-panel p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="pill-muted">{{ trans('web.news.title') }}</p>
                    <h1 class="mt-4 text-3xl font-semibold text-white">{{ __('Sorotan Berita Direktorat Keuangan') }}</h1>
                    <p class="section-subtitle">{{ __('Rangkuman inisiatif, publikasi, dan informasi terkini terkait tata kelola keuangan Telkom University.') }}</p>
                </div>
                <form method="get" class="glass-tile flex flex-wrap items-center gap-3 border-white/10 bg-white/5 px-4 py-3 text-sm">
                    <select name="category" class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                        <option value="">{{ trans('web.news.category_all') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ $activeCategory && $category->slug === $activeCategory->slug ? 'selected' : '' }}>
                                {{ $category->getTranslation('name', $activeLocale) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">{{ __('Filter') }}</button>
                </form>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($posts as $post)
                    <article class="glass-panel hover-raise overflow-hidden border-white/10 bg-white/5">
                        @if($post->cover_image_path)
                            <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="h-44 w-full object-cover" />
                        @endif
                        <div class="space-y-3 p-6">
                            <div class="flex items-center gap-2 text-xs text-amber-200">
                                <span class="rounded-full border border-white/20 px-3 py-1">{{ $post->category?->getTranslation('name', $activeLocale) ?? trans('web.news.title') }}</span>
                                <span class="text-slate-300">{{ $post->published_at?->translatedFormat('d F Y') }}</span>
                            </div>
                            <h2 class="text-lg font-semibold text-white">{{ $post->getTranslation('title', $activeLocale) }}</h2>
                            <p class="text-sm text-slate-300">{{ $post->getTranslation('excerpt', $activeLocale) }}</p>
                            <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $post]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-amber-200 transition hover:text-amber-100">
                                {{ trans('web.read_more') }}
                                <x-ui.icon name="arrow-right" class="h-4 w-4" />
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full rounded-3xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">{{ trans('web.news.empty') }}</p>
                @endforelse
            </div>

            <div class="mt-10 text-center">
                {{ $posts->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
