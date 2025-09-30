@extends('layouts.web')

@php($title = __('Arsip'))

@section('content')
    <section class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ __('Arsip') }}</p>
                <h1 class="page-hero__title">{{ __('Arsip Informasi Keuangan Telkom University') }}</h1>
                <p class="page-hero__subtitle">{{ __('Telusuri berita, publikasi, dan dokumen keuangan berdasarkan tahun.') }}</p>
            </div>
            <form method="get" class="filter-shell">
                <select name="year" class="filter-input">
                    @foreach($years as $yearOption)
                        <option value="{{ $yearOption }}" {{ (int) $selectedYear === (int) $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                    @endforeach
                </select>
                <button type="submit" class="filter-button">{{ __('Tampilkan') }}</button>
            </form>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ __('Publikasi') }}</p>
                <h2 class="section-title">{{ __('Berita Tahun :year', ['year' => $selectedYear]) }}</h2>
            </div>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            @forelse($news as $post)
                <article class="card-elevated overflow-hidden p-0">
                    @if($post->cover_image_path)
                        <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="h-40 w-full object-cover" />
                    @endif
                    <div class="space-y-3 p-6">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $post->getTranslation('title', $activeLocale) }}</h3>
                        <p class="text-sm text-slate-600">{{ $post->getTranslation('excerpt', $activeLocale) }}</p>
                        <p class="text-xs text-slate-500">{{ $post->published_at?->translatedFormat('d F Y') }}</p>
                        <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $post]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-500">
                            {{ trans('web.read_more') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-slate-200 bg-white p-6 text-sm text-slate-600">{{ __('Belum ada berita pada tahun ini.') }}</p>
            @endforelse
        </div>
        <div class="mt-8 text-center">
            {{ $news->appends(['documents_page' => $documents->currentPage()])->links() }}
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ __('Dokumen') }}</p>
                <h2 class="section-title">{{ __('Dokumen Keuangan Tahun :year', ['year' => $selectedYear]) }}</h2>
            </div>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($documents as $document)
                <article class="card-elevated p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">{{ trans('web.document_categories.' . $document->category) }}</p>
                    <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ $document->getTranslation('title', $activeLocale) }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $document->getTranslation('description', $activeLocale) }}</p>
                    <div class="mt-3 text-xs text-slate-500">
                        <p>{{ __('Dipublikasikan') }}: {{ $document->published_at?->translatedFormat('d F Y') ?? $document->year }}</p>
                        @if($document->document_number)
                            <p>{{ __('Nomor Dokumen') }}: {{ $document->document_number }}</p>
                        @endif
                    </div>
                    <a href="{{ route('documents.show', ['locale' => $activeLocale, 'document' => $document]) }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-500">
                        {{ trans('web.documents_list.view') }}
                        <x-ui.icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-slate-200 bg-white p-6 text-sm text-slate-600">{{ __('Belum ada dokumen pada tahun ini.') }}</p>
            @endforelse
        </div>
        <div class="mt-8 text-center">
            {{ $documents->appends(['news_page' => $news->currentPage()])->links() }}
        </div>
    </section>
@endsection
