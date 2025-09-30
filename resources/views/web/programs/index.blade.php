@extends('layouts.web')

@php($title = trans('web.programs.title'))

@section('content')
    <section class="section-shell">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ trans('web.programs.title') }}</p>
                <h1 class="page-hero__title">{{ __('Inisiatif Strategis & Layanan Direktorat Keuangan') }}</h1>
                <p class="page-hero__subtitle">{{ __('Eksplor program transformasi digital, layanan operasional, serta kebijakan tata kelola keuangan Telkom University.') }}</p>
            </div>
            <form method="get" class="filter-shell">
                <select name="type" class="filter-input">
                    <option value="">{{ trans('web.programs.filter_all') }}</option>
                    @foreach($types as $typeKey => $label)
                        <option value="{{ $typeKey }}" {{ $activeType === $typeKey ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="filter-button">{{ __('Filter') }}</button>
            </form>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($programs as $program)
                <article class="card-elevated flex h-full flex-col gap-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">{{ trans('web.program_types.' . $program->type) }}</p>
                    <div class="space-y-2">
                        <h2 class="text-xl font-semibold text-slate-900">{{ $program->getTranslation('name', $activeLocale) }}</h2>
                        <p class="text-sm text-slate-600">{{ $program->getTranslation('summary', $activeLocale) }}</p>
                    </div>
                    <div class="mt-auto flex flex-wrap gap-2 text-xs">
                        @if($program->external_url)
                            <span class="rounded-full border border-slate-200 px-3 py-1 text-slate-500">Digital</span>
                        @endif
                        @if($program->is_featured)
                            <span class="rounded-full bg-gradient-to-r from-red-600/10 to-amber-400/20 px-3 py-1 text-red-600">Featured</span>
                        @endif
                    </div>
                    <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $program]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 transition hover:text-red-500">
                        {{ trans('web.read_more') }}
                        <x-ui.icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-slate-200 bg-white p-6 text-sm text-slate-600">
                    {{ trans('web.programs.empty') }}
                </p>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            {{ $programs->onEachSide(1)->links() }}
        </div>
    </section>
@endsection
