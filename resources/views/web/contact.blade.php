@extends('layouts.web')

@php($title = trans('web.contact.title'))

@section('content')
    <section class="section-shell max-w-6xl">
        <div class="page-hero">
            <div class="page-hero__content">
                <p class="pill-muted">{{ trans('web.contact.title') }}</p>
                <h1 class="page-hero__title">{{ __('Kanal Koordinasi Direktorat Keuangan') }}</h1>
                <p class="page-hero__subtitle">{{ __('Kami mendukung transparansi, layanan keuangan, dan tata kelola anggaran Telkom University dengan respons cepat dan terukur.') }}</p>
            </div>
            <div class="filter-shell">
                @if($setting?->office_hours)
                    <div class="text-left text-xs text-slate-500">
                        <p class="font-semibold uppercase tracking-[0.3em] text-red-600">{{ trans('web.contact.operational_hours') }}</p>
                        <p class="mt-1 text-sm text-slate-700">{{ $setting->office_hours }}</p>
                    </div>
                @endif
                @if($setting?->hotline)
                    <div class="text-left text-xs text-slate-500">
                        <p class="font-semibold uppercase tracking-[0.3em] text-red-600">Hotline</p>
                        <p class="mt-1 text-base font-semibold text-slate-800">{{ $setting->hotline }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-12 grid gap-8 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="space-y-4 text-sm">
                @if($setting?->getTranslation('address', $activeLocale))
                    <div class="card-elevated card-elevated--muted p-5">
                        <p class="text-xs uppercase tracking-[0.35em] text-red-600">{{ trans('web.address') }}</p>
                        <p class="mt-2 text-slate-700">{{ $setting->getTranslation('address', $activeLocale) }}</p>
                    </div>
                @endif
                @if($setting?->phone)
                    <div class="card-elevated card-elevated--muted p-5">
                        <p class="text-xs uppercase tracking-[0.35em] text-red-600">Telepon</p>
                        <p class="mt-2 text-slate-700">{{ $setting->phone }}</p>
                    </div>
                @endif
                @if($setting?->email)
                    <div class="card-elevated card-elevated--muted p-5">
                        <p class="text-xs uppercase tracking-[0.35em] text-red-600">Email</p>
                        <p class="mt-2 text-slate-700">{{ $setting->email }}</p>
                    </div>
                @endif
                @if($setting?->whatsapp)
                    <div class="card-elevated card-elevated--muted p-5">
                        <p class="text-xs uppercase tracking-[0.35em] text-red-600">WhatsApp</p>
                        <p class="mt-2 text-slate-700">{{ $setting->whatsapp }}</p>
                    </div>
                @endif
            </div>
            <div class="card-elevated p-0">
                <x-ui.campus-map
                    :lat="$mapLocation['lat']"
                    :lng="$mapLocation['lng']"
                    :zoom="$mapLocation['zoom']"
                    :title="$mapLocation['title']"
                    :address="$mapLocation['address']"
                    :hours="$mapLocation['hours']"
                    :phone="$mapLocation['phone']"
                    :email="$mapLocation['email']"
                    :whatsapp="$mapLocation['whatsapp']"
                    :directions-url="$mapLocation['directions_url']"
                />
            </div>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2">
            @foreach($channels as $channel)
                <div class="card-elevated card-elevated--muted p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-600">{{ ucfirst($channel->type) }}</p>
                    <h2 class="mt-2 text-lg font-semibold text-slate-900">{{ $channel->getTranslation('name', $activeLocale) }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $channel->value }}</p>
                    @if($channel->getTranslation('notes', $activeLocale))
                        <p class="mt-1 text-xs text-slate-500">{{ $channel->getTranslation('notes', $activeLocale) }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-12 card-elevated p-6">
            <h2 class="text-xl font-semibold text-slate-900">{{ trans('web.announcements') }}</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                @forelse($announcements as $announcement)
                    <li class="card-elevated card-elevated--muted p-4">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-slate-900">{{ $announcement->getTranslation('title', $activeLocale) }}</p>
                            <span class="text-xs text-slate-500">{{ $announcement->starts_at?->translatedFormat('d F Y') }}</span>
                        </div>
                        @if($announcement->getTranslation('body', $activeLocale))
                            <p class="mt-2 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->getTranslation('body', $activeLocale)), 160) }}</p>
                        @endif
                    </li>
                @empty
                    <li class="card-elevated card-elevated--muted p-4 text-xs text-slate-500">{{ __('Belum ada pengumuman aktif.') }}</li>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
