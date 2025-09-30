@extends('layouts.web')

@php($title = trans('web.news.title'))

@section('content')
    <section class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ trans('web.news.title') }}</p>
                <h1 class="page-hero__title">{{ __('Sorotan Berita Direktorat Keuangan') }}</h1>
                <p class="page-hero__subtitle">{{ __('Rangkuman inisiatif, publikasi, dan informasi terkini terkait tata kelola keuangan Telkom University.') }}</p>
            </div>
            <form method="get" class="filter-shell">
                <select name="category" class="filter-input">
                    <option value="">{{ trans('web.news.category_all') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ $activeCategory && $category->slug === $activeCategory->slug ? 'selected' : '' }}>
                            {{ $category->getTranslation('name', $activeLocale) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="filter-button">{{ __('Filter') }}</button>
            </form>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($posts as $post)
                <article class="card-elevated overflow-hidden p-0">
                    @if($post->cover_image_path)
                        <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="h-44 w-full object-cover" />
                    @endif
                    <div class="space-y-3 p-6">
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <span class="rounded-full border border-slate-200 px-3 py-1 text-red-600">{{ $post->category?->getTranslation('name', $activeLocale) ?? trans('web.news.title') }}</span>
                            <span class="text-slate-400">{{ $post->published_at?->translatedFormat('d F Y') }}</span>
                        </div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ $post->getTranslation('title', $activeLocale) }}</h2>
                        <p class="text-sm text-slate-600">{{ $post->getTranslation('excerpt', $activeLocale) }}</p>
                        <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $post]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 transition hover:text-red-500">
                            {{ trans('web.read_more') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-slate-200 bg-white p-6 text-sm text-slate-600">{{ trans('web.news.empty') }}</p>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            {{ $posts->onEachSide(1)->links() }}
        </div>
    </section>
@endsection
