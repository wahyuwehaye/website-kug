@extends('layouts.web')

@php($title = trans('web.news.title'))

@section('content')
    <section class="bg-white py-14">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">{{ trans('web.news.title') }}</h1>
                    <p class="mt-2 text-sm text-slate-600">{{ __('Rangkuman aktivitas, publikasi, dan informasi terbaru Direktorat Keuangan.') }}</p>
                </div>
                <form method="get" class="flex flex-wrap items-center gap-3">
                    <select name="category" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm focus:border-primary-500 focus:outline-none">
                        <option value="">{{ trans('web.news.category_all') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ $activeCategory && $category->slug === $activeCategory->slug ? 'selected' : '' }}>
                                {{ $category->getTranslation('name', $activeLocale) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-full bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500">Filter</button>
                </form>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($posts as $post)
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        @if($post->cover_image_path)
                            <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="h-44 w-full object-cover" />
                        @endif
                        <div class="space-y-3 p-6">
                            <div class="flex items-center gap-2 text-xs text-primary-600">
                                <span class="rounded-full bg-primary-100 px-3 py-1">{{ $post->category?->getTranslation('name', $activeLocale) ?? trans('web.news.title') }}</span>
                                <span>{{ $post->published_at?->translatedFormat('d F Y') }}</span>
                            </div>
                            <h2 class="text-lg font-semibold text-slate-900 line-clamp-2">{{ $post->getTranslation('title', $activeLocale) }}</h2>
                            <p class="text-sm text-slate-600 line-clamp-3">{{ $post->getTranslation('excerpt', $activeLocale) }}</p>
                            <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $post]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-500">
                                {{ trans('web.read_more') }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25l4.5 4.5-4.5 4.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full rounded-3xl bg-slate-50 p-6 text-sm text-slate-600 shadow">{{ trans('web.news.empty') }}</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $posts->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
