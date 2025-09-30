@extends('layouts.web')

@php($title = trans('web.documents_list.title'))

@section('content')
    <section class="section-shell">
        <div class="glass-panel p-8">
            <header class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="pill-muted">{{ trans('web.documents_list.title') }}</p>
                    <h1 class="mt-4 text-3xl font-semibold text-white">{{ __('Repositori Dokumen Keuangan Telkom University') }}</h1>
                    <p class="section-subtitle">{{ __('Filter berdasarkan kategori, tahun, atau kata kunci untuk menemukan laporan audit, RBA, pedoman, dan dokumen pengawasan lainnya.') }}</p>
                </div>
                <form method="get" class="glass-tile flex flex-wrap items-center gap-3 border-white/10 bg-white/5 px-4 py-3 text-sm">
                    <input type="search" name="q" value="{{ $search }}" placeholder="{{ trans('web.documents_filters.search_placeholder') }}" class="w-56 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-white placeholder:text-slate-400 focus:border-amber-300 focus:outline-none">
                    <select name="category" class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                        <option value="">{{ trans('web.documents_filters.category') }}</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ $activeCategory === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="year" class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                        <option value="">{{ trans('web.documents_filters.year') }}</option>
                        @foreach($years as $yearOption)
                            <option value="{{ $yearOption }}" {{ (int) $activeYear === (int) $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">{{ __('Filter') }}</button>
                </form>
            </header>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($documents as $document)
                    <article class="glass-tile hover-raise flex h-full flex-col gap-4 border-white/10 bg-white/5 p-6">
                        <div class="flex items-center justify-between text-xs text-slate-300">
                            <span class="rounded-full border border-white/20 px-3 py-1 text-amber-200">{{ trans('web.document_categories.' . $document->category) }}</span>
                            <span>{{ $document->year ?? $document->published_at?->year }}</span>
                        </div>
                        <h2 class="text-lg font-semibold text-white">{{ $document->getTranslation('title', $activeLocale) }}</h2>
                        <p class="flex-1 text-sm text-slate-300">{{ $document->getTranslation('description', $activeLocale) }}</p>
                        <dl class="space-y-1 text-xs text-slate-400">
                            @if($document->document_number)
                                <div><span class="font-semibold text-slate-200">No. Dokumen:</span> {{ $document->document_number }}</div>
                            @endif
                            @if($document->effective_at)
                                <div><span class="font-semibold text-slate-200">Efektif:</span> {{ $document->effective_at->translatedFormat('d F Y') }}</div>
                            @endif
                        </dl>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('documents.show', ['locale' => $activeLocale, 'document' => $document]) }}" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-4 py-2 text-xs font-semibold text-slate-900 transition hover:bg-amber-300">
                                {{ trans('web.documents_list.view') }}
                            </a>
                            @if($document->external_url)
                                <a href="{{ $document->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-4 py-2 text-xs font-semibold text-slate-200 transition hover:border-white">
                                    {{ trans('web.documents_list.external') }}
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="col-span-full rounded-3xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">{{ trans('web.documents_list.empty') }}</p>
                @endforelse
            </div>

            <div class="mt-10 text-center">
                {{ $documents->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
