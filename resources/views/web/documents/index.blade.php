@extends('layouts.web')

@php($title = trans('web.documents_list.title'))

@section('content')
    <section class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ trans('web.documents_list.title') }}</p>
                <h1 class="page-hero__title">{{ __('Repositori Dokumen Keuangan Telkom University') }}</h1>
                <p class="page-hero__subtitle">{{ __('Filter berdasarkan kategori, tahun, atau kata kunci untuk menemukan laporan audit, RBA, pedoman, dan dokumen pengawasan lainnya.') }}</p>
            </div>
            <form method="get" class="filter-shell">
                <input type="search" name="q" value="{{ $search }}" placeholder="{{ trans('web.documents_filters.search_placeholder') }}" class="filter-input w-56">
                <select name="category" class="filter-input">
                    <option value="">{{ trans('web.documents_filters.category') }}</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ $activeCategory === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="year" class="filter-input">
                    <option value="">{{ trans('web.documents_filters.year') }}</option>
                    @foreach($years as $yearOption)
                        <option value="{{ $yearOption }}" {{ (int) $activeYear === (int) $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                    @endforeach
                </select>
                <button type="submit" class="filter-button">{{ __('Filter') }}</button>
            </form>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($documents as $document)
                <article class="card-elevated flex h-full flex-col gap-4">
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span class="rounded-full border border-slate-200 px-3 py-1 text-red-600">{{ trans('web.document_categories.' . $document->category) }}</span>
                        <span>{{ $document->year ?? $document->published_at?->year }}</span>
                    </div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ $document->getTranslation('title', $activeLocale) }}</h2>
                    <p class="flex-1 text-sm text-slate-600">{{ $document->getTranslation('description', $activeLocale) }}</p>
                    <dl class="space-y-1 text-xs text-slate-500">
                        @if($document->document_number)
                            <div><span class="font-semibold text-slate-700">No. Dokumen:</span> {{ $document->document_number }}</div>
                        @endif
                        @if($document->effective_at)
                            <div><span class="font-semibold text-slate-700">Efektif:</span> {{ $document->effective_at->translatedFormat('d F Y') }}</div>
                        @endif
                    </dl>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('documents.show', ['locale' => $activeLocale, 'document' => $document]) }}" class="inline-flex items-center gap-2 rounded-full bg-red-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-500">
                            {{ trans('web.documents_list.view') }}
                        </a>
                        @if($document->external_url)
                            <a href="{{ $document->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:border-red-300 hover:text-red-600">
                                {{ trans('web.documents_list.external') }}
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-slate-200 bg-white p-6 text-sm text-slate-600">{{ trans('web.documents_list.empty') }}</p>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            {{ $documents->onEachSide(1)->links() }}
        </div>
    </section>
@endsection
