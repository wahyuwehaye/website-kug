@extends('layouts.web')

@php($title = __('Download'))

@section('content')
    <section class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ __('Download') }}</p>
                <h1 class="page-hero__title">{{ __('Formulir & Panduan Direktorat Keuangan') }}</h1>
                <p class="page-hero__subtitle">{{ __('Unduh dokumen standar layanan dana, pedoman kepatuhan, dan formulir strategis lain yang dibutuhkan unit kerja.') }}</p>
            </div>
            <form method="get" class="filter-shell">
                <select name="category" class="filter-input">
                    <option value="">{{ __('Semua Kategori') }}</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ $activeCategory === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="filter-button">{{ __('Terapkan') }}</button>
            </form>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($downloads as $document)
                <article class="card-elevated p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">{{ trans('web.document_categories.' . $document->category) }}</p>
                    <h2 class="mt-3 text-lg font-semibold text-slate-900">{{ $document->getTranslation('title', $activeLocale) }}</h2>
                    <p class="mt-2 flex-1 text-sm text-slate-600">{{ $document->getTranslation('description', $activeLocale) }}</p>
                    <div class="mt-3 text-xs text-slate-500">
                        @if($document->published_at)
                            <p>{{ __('Dipublikasikan') }}: {{ $document->published_at->translatedFormat('d F Y') }}</p>
                        @endif
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
                <p class="col-span-full rounded-3xl border border-slate-200 bg-white p-6 text-sm text-slate-600">{{ __('Belum ada dokumen yang dapat diunduh untuk kategori ini.') }}</p>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            {{ $downloads->onEachSide(1)->links() }}
        </div>
    </section>
@endsection
