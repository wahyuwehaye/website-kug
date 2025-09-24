@extends('layouts.web')

@php($title = trans('web.programs.title'))

@section('content')
    <section class="bg-slate-50 py-14">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">{{ trans('web.programs.title') }}</h1>
                    <p class="mt-2 text-sm text-slate-600">{{ __('Eksplor program strategis dan layanan Direktorat Keuangan.') }}</p>
                </div>
                <form method="get" class="flex flex-wrap items-center gap-3">
                    <select name="type" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm focus:border-primary-500 focus:outline-none">
                        <option value="">{{ trans('web.programs.filter_all') }}</option>
                        @foreach($types as $typeKey => $label)
                            <option value="{{ $typeKey }}" {{ $activeType === $typeKey ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-full bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500">Filter</button>
                </form>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($programs as $program)
                    <article class="group h-full rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">{{ trans('web.program_types.' . $program->type) }}</p>
                        <h2 class="mt-3 text-xl font-semibold text-slate-900">{{ $program->getTranslation('name', $activeLocale) }}</h2>
                        <p class="mt-3 text-sm text-slate-600 line-clamp-4">{{ $program->getTranslation('summary', $activeLocale) }}</p>
                        <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500">
                            @if($program->external_url)
                                <span class="rounded-full bg-primary-50 px-3 py-1 text-primary-600">Digital</span>
                            @endif
                            @if($program->is_featured)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-amber-700">Featured</span>
                            @endif
                        </div>
                        <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $program]) }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-500">
                            {{ trans('web.read_more') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25l4.5 4.5-4.5 4.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18" />
                            </svg>
                        </a>
                    </article>
                @empty
                    <p class="col-span-full rounded-3xl bg-white p-6 text-sm text-slate-600 shadow">{{ trans('web.programs.empty') }}</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $programs->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
