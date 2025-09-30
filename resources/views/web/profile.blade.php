@extends('layouts.web')

@php($title = __('Profil Direktorat Keuangan'))

@section('content')
    <section id="vision" class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ __('Profil Direktorat Keuangan') }}</p>
                <h1 class="page-hero__title">{{ $setting?->getTranslation('name', $activeLocale) ?? __('Direktorat Keuangan Telkom University') }}</h1>
                <p class="page-hero__subtitle">{{ $setting?->getTranslation('short_description', $activeLocale) ?? __('Direktorat Keuangan menghadirkan layanan penganggaran, penatausahaan, dan pelaporan keuangan yang transparan untuk mendukung Telkom University.') }}</p>
            </div>
        </div>
    </section>

    <section id="structure" class="section-shell">
        <div class="grid gap-6 lg:grid-cols-2">
            <article class="card-elevated p-8">
                <p class="pill-muted">{{ __('Visi') }}</p>
                <h2 class="section-title">{{ __('Visi Direktorat Keuangan') }}</h2>
                <p class="mt-4 text-sm text-slate-600">{!! $setting?->getTranslation('vision', $activeLocale) ?? __('Menjadi mitra strategis yang unggul dalam tata kelola keuangan perguruan tinggi.') !!}</p>
            </article>
            <article class="card-elevated p-8">
                <p class="pill-muted">{{ __('Misi') }}</p>
                <h2 class="section-title">{{ __('Misi Utama') }}</h2>
                <p class="mt-4 text-sm text-slate-600">{!! $setting?->getTranslation('mission', $activeLocale) ?? __('Menyediakan layanan keuangan yang profesional, akuntabel, dan adaptif terhadap kebutuhan sivitas.') !!}</p>
            </article>
        </div>
    </section>

    <section id="strategic-plan" class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ __('Struktur Organisasi') }}</p>
                <h2 class="page-hero__title">{{ __('Tim Kepemimpinan & Organisasi') }}</h2>
                <p class="page-hero__subtitle">{{ __('Struktur organisasi yang adaptif memastikan setiap layanan keuangan bergerak selaras dengan tujuan strategis universitas.') }}</p>
            </div>
            <div class="filter-shell">
                <div class="text-left text-xs text-slate-500">
                    <p class="font-semibold uppercase tracking-[0.3em] text-red-600">{{ __('Facts & Figures') }}</p>
                    <p class="mt-1 text-sm text-slate-700">{{ __('+120 pegawai profesional · 4 divisi utama · 1 platform keuangan terintegrasi') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="facts" class="section-shell">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ __('Strategic Plan') }}</p>
                <h2 class="section-title">{{ __('Agenda Transformasi 2025-2027') }}</h2>
                <p class="section-subtitle">{{ __('Fokus pada digitalisasi layanan, tata kelola berbasis data, dan peningkatan pengalaman pemangku kepentingan.') }}</p>
            </div>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="card-elevated p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-600">2025</p>
                <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ __('Integrasi Data Keuangan') }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ __('Penguatan dashboard real-time, single source of truth, dan automasi validasi SPJ.') }}</p>
            </div>
            <div class="card-elevated p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-600">2026</p>
                <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ __('Service Excellence') }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ __('Omni-channel helpdesk, SLA berbasis AI assistant, dan continuous improvement layanan dana.') }}</p>
            </div>
            <div class="card-elevated p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-600">2027</p>
                <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ __('Governance & Compliance') }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ __('Audit digital, early warning system finansial, dan kolaborasi sinergis dengan unit bisnis universitas.') }}</p>
            </div>
            <div class="card-elevated p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-600">{{ __('Highlight') }}</p>
                <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ __('Strategic KPIs') }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ __('99% SLA bantuan dana, 100% kepatuhan SPJ, optimasi cashflow harian melalui integrasi perbankan.') }}</p>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ __('Program Strategis') }}</p>
                <h2 class="section-title">{{ __('Transformasi Prioritas Direktorat') }}</h2>
            </div>
            <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="btn-outline">{{ trans('web.view_all') }}</a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($strategicPrograms as $program)
                <article class="card-elevated p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">{{ trans('web.program_types.' . $program->type) }}</p>
                    <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ $program->getTranslation('name', $activeLocale) }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $program->getTranslation('summary', $activeLocale) }}</p>
                    <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $program]) }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-500">
                        {{ trans('web.read_more') }}
                        <x-ui.icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ __('Facts & Figures') }}</p>
                <h2 class="section-title">{{ __('Mengelola Keuangan Telkom University Secara Transparan') }}</h2>
                <p class="section-subtitle">{{ __('Data ringkas untuk menampilkan capaian layanan dan dampak pada seluruh pemangku kepentingan.') }}</p>
            </div>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="card-elevated p-6">
                <h3 class="text-3xl font-semibold text-red-600">{{ __('99%') }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ __('Rasio penyelesaian layanan dana tepat SLA per 2024.') }}</p>
            </div>
            <div class="card-elevated p-6">
                <h3 class="text-3xl font-semibold text-red-600">{{ __('48 Jam') }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ __('Rata-rata penyelesaian konsultasi SPJ dan perpajakan.') }}</p>
            </div>
            <div class="card-elevated p-6">
                <h3 class="text-3xl font-semibold text-red-600">{{ __('24/7') }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ __('Monitoring cashflow dan dashboard keuangan untuk pimpinan.') }}</p>
            </div>
            <div class="card-elevated p-6">
                <h3 class="text-3xl font-semibold text-red-600">{{ __('+15') }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ __('Kemitraan perbankan strategis untuk optimalisasi transaksi.') }}</p>
            </div>
        </div>
    </section>

    <section class="section-shell">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ __('Sorotan Terbaru') }}</p>
                <h2 class="section-title">{{ __('Berita & Informasi') }}</h2>
            </div>
            <a href="{{ route('news.index', ['locale' => $activeLocale]) }}" class="btn-outline">{{ trans('web.view_all') }}</a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach($latestNews as $post)
                <article class="card-elevated overflow-hidden p-0">
                    @if($post->cover_image_path)
                        <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="h-40 w-full object-cover" />
                    @endif
                    <div class="space-y-3 p-6">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $post->getTranslation('title', $activeLocale) }}</h3>
                        <p class="text-sm text-slate-600">{{ $post->getTranslation('excerpt', $activeLocale) }}</p>
                        <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $post]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-500">
                            {{ trans('web.read_more') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
