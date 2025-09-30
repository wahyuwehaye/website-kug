@extends('layouts.web')

@php($title = trans('web.contact.title'))

@section('content')
    <section class="section-shell max-w-6xl">
        <div class="glass-panel p-10">
            <div class="flex flex-wrap items-start justify-between gap-6">
                <div class="max-w-2xl space-y-3">
                    <p class="pill-muted">{{ trans('web.contact.title') }}</p>
                    <h1 class="text-3xl font-semibold text-white">{{ __('Kanal Koordinasi Direktorat Keuangan') }}</h1>
                    <p class="section-subtitle">{{ __('Kami mendukung transparansi, layanan keuangan, dan tata kelola anggaran Telkom University dengan respons cepat dan terukur.') }}</p>
                </div>
                <div class="glass-tile border-white/10 bg-white/5 p-5 text-sm text-slate-200">
                    @if($setting?->office_hours)
                        <p class="text-xs uppercase tracking-[0.35em] text-amber-200">{{ trans('web.contact.operational_hours') }}</p>
                        <p class="mt-2">{{ $setting->office_hours }}</p>
                    @endif
                    @if($setting?->hotline)
                        <p class="mt-4 text-xs uppercase tracking-[0.35em] text-amber-200">Hotline</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ $setting->hotline }}</p>
                    @endif
                </div>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-[1.1fr,0.9fr]">
                <div class="space-y-4 text-sm">
                    @if($setting?->getTranslation('address', $activeLocale))
                        <div class="glass-tile border-white/10 bg-white/5 p-5">
                            <p class="text-xs uppercase tracking-[0.35em] text-amber-200">{{ trans('web.address') }}</p>
                            <p class="mt-2 text-white">{{ $setting->getTranslation('address', $activeLocale) }}</p>
                        </div>
                    @endif
                    @if($setting?->phone)
                        <div class="glass-tile border-white/10 bg-white/5 p-5">
                            <p class="text-xs uppercase tracking-[0.35em] text-amber-200">Telepon</p>
                            <p class="mt-2 text-white">{{ $setting->phone }}</p>
                        </div>
                    @endif
                    @if($setting?->email)
                        <div class="glass-tile border-white/10 bg-white/5 p-5">
                            <p class="text-xs uppercase tracking-[0.35em] text-amber-200">Email</p>
                            <p class="mt-2 text-white">{{ $setting->email }}</p>
                        </div>
                    @endif
                    @if($setting?->whatsapp)
                        <div class="glass-tile border-white/10 bg-white/5 p-5">
                            <p class="text-xs uppercase tracking-[0.35em] text-amber-200">WhatsApp</p>
                            <p class="mt-2 text-white">{{ $setting->whatsapp }}</p>
                        </div>
                    @endif
                </div>
                <div class="glass-tile border-white/10 bg-white/5 p-0">
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
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2">
            @foreach($channels as $channel)
                <div class="glass-tile hover-raise border-white/10 bg-white/5 p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-amber-200">{{ ucfirst($channel->type) }}</p>
                    <h2 class="mt-2 text-lg font-semibold text-white">{{ $channel->getTranslation('name', $activeLocale) }}</h2>
                    <p class="mt-2 text-sm text-slate-200">{{ $channel->value }}</p>
                    @if($channel->getTranslation('notes', $activeLocale))
                        <p class="mt-1 text-xs text-slate-400">{{ $channel->getTranslation('notes', $activeLocale) }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-12 glass-panel p-6">
            <h2 class="text-xl font-semibold text-white">{{ trans('web.announcements') }}</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-200">
                @forelse($announcements as $announcement)
                    <li class="glass-tile border-white/10 bg-white/5 p-4">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-white">{{ $announcement->getTranslation('title', $activeLocale) }}</p>
                            <span class="text-xs text-slate-300">{{ $announcement->starts_at?->translatedFormat('d F Y') }}</span>
                        </div>
                        @if($announcement->getTranslation('body', $activeLocale))
                            <p class="mt-2 text-xs text-slate-400">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->getTranslation('body', $activeLocale)), 160) }}</p>
                        @endif
                    </li>
                @empty
                    <li class="glass-tile border-white/10 bg-white/5 p-4 text-xs text-slate-400">{{ __('Belum ada pengumuman aktif.') }}</li>
                @endforelse
            </ul>
        </div>
    </section>
@endsection
