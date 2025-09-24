@extends('layouts.web')

@php($title = trans('web.documents_list.title'))

@section('content')
    <section class="bg-slate-50 py-14">
        <div class="mx-auto max-w-7xl px-4">
            <header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">{{ trans('web.documents_list.title') }}</h1>
                    <p class="mt-2 text-sm text-slate-600">{{ __('Dokumen mengikuti standar publikasi Telkom University dan dapat disaring berdasarkan kategori serta tahun.') }}</p>
                </div>
                <form method="get" class="flex flex-wrap items-center gap-3">
                    <input type="search" name="q" value="{{ $search }}" placeholder="{{ trans('web.documents_filters.search_placeholder') }}" class="w-60 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm focus:border-primary-500 focus:outline-none">
                    <select name="category" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm focus:border-primary-500 focus:outline-none">
                        <option value="">{{ trans('web.documents_filters.category') }}</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ $activeCategory === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="year" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm focus:border-primary-500 focus:outline-none">
                        <option value="">{{ trans('web.documents_filters.year') }}</option>
                        @foreach($years as $yearOption)
                            <option value="{{ $yearOption }}" {{ (int) $activeYear === (int) $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-full bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500">Filter</button>
                </form>
            </header>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($documents as $document)
                    <article class="flex h-full flex-col rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span class="rounded-full bg-primary-100 px-3 py-1 text-primary-700">{{ trans('web.document_categories.' . $document->category) }}</span>
                            <span>{{ $document->year ?? $document->published_at?->year }}</span>
                        </div>
                        <h2 class="mt-4 text-lg font-semibold text-slate-900">{{ $document->getTranslation('title', $activeLocale) }}</h2>
                        <p class="mt-3 flex-1 text-sm text-slate-600 line-clamp-4">{{ $document->getTranslation('description', $activeLocale) }}</p>
                        <dl class="mt-4 space-y-1 text-xs text-slate-500">
                            @if($document->document_number)
                                <div><span class="font-semibold">No. Dokumen:</span> {{ $document->document_number }}</div>
                            @endif
                            @if($document->effective_at)
                                <div><span class="font-semibold">Efektif:</span> {{ $document->effective_at->translatedFormat('d F Y') }}</div>
                            @endif
                        </dl>
                        <div class="mt-6 flex flex-wrap gap-2">
                            @if($document->file_path)
                                <a href="{{ route('documents.download', ['locale' => $activeLocale, 'document' => $document]) }}" class="inline-flex items-center gap-2 rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold text-white hover:bg-primary-500">
                                    {{ trans('web.documents_list.download') }}
                                </a>
                            @endif
                            @if($document->external_url)
                                <a href="{{ $document->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-primary-200 px-4 py-2 text-xs font-semibold text-primary-600 hover:bg-primary-50">
                                    {{ trans('web.documents_list.external') }}
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="col-span-full rounded-3xl bg-white p-6 text-sm text-slate-600 shadow">{{ trans('web.documents_list.empty') }}</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $documents->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
