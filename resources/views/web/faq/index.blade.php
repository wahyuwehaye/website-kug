@extends('layouts.web')

@php($title = trans('web.faqs'))

@section('content')
    <section class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ trans('web.faqs') }}</p>
                <h1 class="page-hero__title">{{ __('Pertanyaan & Solusi Layanan Keuangan') }}</h1>
                <p class="page-hero__subtitle">{{ __('Panduan singkat mengenai prosedur pengajuan dana, SPJ, konsultasi, dan layanan lainnya.') }}</p>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="faq-accordion">
            @foreach($faqs as $faq)
                <div class="faq-card" data-faq-card>
                    <button type="button" class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left text-sm font-semibold text-slate-900" data-faq-trigger>
                        <span>{{ $faq->getTranslation('question', $activeLocale) }}</span>
                        <svg class="h-5 w-5 text-red-500 transition" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a.75.75 0 01.75.75v3.5h3.5a.75.75 0 010 1.5h-3.5v3.5a.75.75 0 01-1.5 0v-3.5h-3.5a.75.75 0 010-1.5h3.5v-3.5A.75.75 0 0110 5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="faq-body" data-faq-body>
                        {!! $faq->getTranslation('answer', $activeLocale) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
