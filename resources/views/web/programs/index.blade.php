@extends('layouts.web')

@php($title = trans('web.programs.title'))

@section('content')
    <section class="section-shell">
        <div class="glass-panel p-8">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <p class="pill-muted">{{ trans('web.programs.title') }}</p>
                    <h1 class="mt-4 text-3xl font-semibold text-white">{{ __('Inisiatif Strategis & Layanan Direktorat Keuangan') }}</h1>
                    <p class="section-subtitle">{{ __('Eksplor program transformasi digital, layanan operasional, serta kebijakan tata kelola keuangan Telkom University.') }}</p>
                </div>
                <form method="get" class="glass-tile inline-flex flex-wrap items-center gap-3 border-white/10 bg-white/5 px-4 py-2 text-sm">
                    <select name="type" class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                        <option value="">{{ trans('web.programs.filter_all') }}</option>
                        @foreach($types as $typeKey => $label)
                            <option value="{{ $typeKey }}" {{ $activeType === $typeKey ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">{{ __('Filter') }}</button>
                </form>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($programs as $program)
                    <article class="glass-tile hover-raise flex h-full flex-col gap-4 p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-amber-200">{{ trans('web.program_types.' . $program->type) }}</p>
                        <div class="space-y-2">
                            <h2 class="text-xl font-semibold text-white">{{ $program->getTranslation('name', $activeLocale) }}</h2>
                            <p class="text-sm text-slate-300">{{ $program->getTranslation('summary', $activeLocale) }}</p>
                        </div>
                        <div class="mt-auto flex flex-wrap gap-2 text-xs">
                            @if($program->external_url)
                                <span class="rounded-full border border-white/15 px-3 py-1 text-slate-200">Digital</span>
                            @endif
                            @if($program->is_featured)
                                <span class="rounded-full bg-amber-400/20 px-3 py-1 text-amber-100">Featured</span>
                            @endif
                        </div>
                        <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $program]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-amber-200 transition hover:text-amber-100">
                            {{ trans('web.read_more') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </article>
                @empty
                    <p class="col-span-full rounded-3xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">{{ trans('web.programs.empty') }}</p>
                @endforelse
            </div>

            <div class="mt-10 text-center">
                {{ $programs->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
