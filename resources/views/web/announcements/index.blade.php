@extends('layouts.web')

@php($title = trans('web.announcements'))

@section('content')
    <section class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ trans('web.announcements') }}</p>
                <h1 class="page-hero__title">{{ __('Pengumuman Direktorat Keuangan') }}</h1>
                <p class="page-hero__subtitle">{{ __('Informasi kebijakan, jadwal layanan dana, dan update operasional terbaru untuk seluruh sivitas.') }}</p>
            </div>
            <form method="get" class="filter-shell">
                <select name="status" class="filter-input">
                    <option value="">{{ __('Status') }}</option>
                    <option value="draft" {{ $activeStatus === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    <option value="published" {{ $activeStatus === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                </select>
                <select name="type" class="filter-input">
                    <option value="">{{ __('Semua Tipe') }}</option>
                    <option value="public" {{ $activeType === 'public' ? 'selected' : '' }}>{{ __('Publik') }}</option>
                    <option value="alert" {{ $activeType === 'alert' ? 'selected' : '' }}>{{ __('Alert') }}</option>
                    <option value="internal" {{ $activeType === 'internal' ? 'selected' : '' }}>{{ __('Internal') }}</option>
                </select>
                <button type="submit" class="filter-button">{{ __('Terapkan') }}</button>
            </form>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($announcements as $announcement)
                <article class="card-elevated p-6">
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span class="rounded-full border border-slate-200 px-3 py-1 text-red-600">{{ strtoupper($announcement->type) }}</span>
                        <span>{{ $announcement->starts_at?->translatedFormat('d M Y') }}</span>
                    </div>
                    <h2 class="mt-3 text-lg font-semibold text-slate-900">{{ $announcement->getTranslation('title', $activeLocale) }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->getTranslation('body', $activeLocale)), 180) }}</p>
                    <div class="mt-4 text-xs text-slate-500">
                        @if($announcement->starts_at)
                            <p>{{ __('Mulai') }}: {{ $announcement->starts_at->translatedFormat('d F Y') }}</p>
                        @endif
                        @if($announcement->ends_at)
                            <p>{{ __('Selesai') }}: {{ $announcement->ends_at->translatedFormat('d F Y') }}</p>
                        @endif
                    </div>
                    @if($announcement->cta_url)
                        <a href="{{ $announcement->cta_url }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-500">
                            {{ $announcement->getTranslation('cta_label', $activeLocale) ?? trans('web.read_more') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    @endif
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-slate-200 bg-white p-6 text-sm text-slate-600">{{ __('Belum ada pengumuman saat ini.') }}</p>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            {{ $announcements->onEachSide(1)->links() }}
        </div>
    </section>
@endsection
