@extends('layouts.web')

@php
    $title = $document->getTranslation('title', $activeLocale);
@endphp

@section('content')
    <section class="section-shell max-w-6xl">
        <div class="glass-panel p-10 text-white">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-3">
                    <p class="pill-muted">{{ trans('web.documents') }}</p>
                    <h1 class="text-3xl font-semibold text-white">{{ $document->getTranslation('title', $activeLocale) }}</h1>
                    <p class="max-w-2xl text-sm text-slate-200">{{ $document->getTranslation('description', $activeLocale) }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 text-xs text-slate-200">
                    <dl class="space-y-2">
                        <div>
                            <dt class="font-semibold uppercase tracking-[0.3em] text-amber-200">{{ trans('web.document_meta.category') }}</dt>
                            <dd class="mt-1">{{ trans('web.document_categories.' . $document->category) }}</dd>
                        </div>
                        @if($document->document_number)
                            <div>
                                <dt class="font-semibold uppercase tracking-[0.3em] text-amber-200">{{ trans('web.document_meta.number') }}</dt>
                                <dd class="mt-1">{{ $document->document_number }}</dd>
                            </div>
                        @endif
                        @if($document->published_at)
                            <div>
                                <dt class="font-semibold uppercase tracking-[0.3em] text-amber-200">{{ trans('web.document_meta.published_at') }}</dt>
                                <dd class="mt-1">{{ $document->published_at->translatedFormat('d F Y') }}</dd>
                            </div>
                        @endif
                        @if($document->effective_at)
                            <div>
                                <dt class="font-semibold uppercase tracking-[0.3em] text-amber-200">{{ trans('web.document_meta.effective_at') }}</dt>
                                <dd class="mt-1">{{ $document->effective_at->translatedFormat('d F Y') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
            <div class="mt-8 flex flex-wrap gap-3 text-sm">
                <a href="{{ route('documents.index', ['locale' => $activeLocale]) }}" class="btn-ghost">
                    <x-ui.icon name="arrow-right" class="h-4 w-4 -rotate-180" />
                    {{ trans('web.document_meta.back_to_list') }}
                </a>
                @if($document->external_url)
                    <a href="{{ $document->external_url }}" target="_blank" rel="noopener" class="btn-ghost">
                        <x-ui.icon name="link" class="h-4 w-4" />
                        {{ trans('web.documents_list.external') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-10 rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_25px_60px_-45px_rgba(15,23,42,0.45)]">
            @if($fileUrl)
                <div class="aspect-[4/3] overflow-hidden rounded-2xl border border-slate-200">
                    <iframe src="{{ $fileUrl }}#view=FitH" class="h-full w-full" frameborder="0"></iframe>
                </div>
                <p class="mt-4 text-xs text-slate-500">{{ trans('web.documents_list.view_notice') }}</p>
            @else
                <div class="flex h-72 items-center justify-center rounded-2xl border border-dashed border-slate-300 text-sm text-slate-500">
                    {{ trans('web.documents_list.no_preview') }}
                </div>
            @endif
        </div>
    </section>
@endsection
