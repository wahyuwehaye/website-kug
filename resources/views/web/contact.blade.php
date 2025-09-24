@extends('layouts.web')

@php($title = trans('web.contact.title'))

@section('content')
    <section class="bg-white py-14">
        <div class="mx-auto max-w-6xl px-4">
            <div class="rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 p-10 text-white shadow">
                <h1 class="text-3xl font-bold">{{ trans('web.contact.title') }}</h1>
                <p class="mt-2 max-w-3xl text-sm text-primary-100">{{ __('Direktorat Keuangan Telkom University mendukung transparansi, layanan keuangan, dan tata kelola anggaran yang akuntabel bagi seluruh sivitas akademika.') }}</p>
                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    <div class="space-y-4 text-sm">
                        @if($setting?->getTranslation('address', $activeLocale))
                            <div class="rounded-2xl bg-white/15 p-4">
                                <p class="text-xs uppercase tracking-wide text-primary-200">{{ trans('web.address') }}</p>
                                <p class="mt-2 text-white">{{ $setting->getTranslation('address', $activeLocale) }}</p>
                            </div>
                        @endif
                        @if($setting?->phone)
                            <div class="rounded-2xl bg-white/15 p-4">
                                <p class="text-xs uppercase tracking-wide text-primary-200">Telepon</p>
                                <p class="mt-2 text-white">{{ $setting->phone }}</p>
                            </div>
                        @endif
                        @if($setting?->hotline)
                            <div class="rounded-2xl bg-white/15 p-4">
                                <p class="text-xs uppercase tracking-wide text-primary-200">Hotline</p>
                                <p class="mt-2 text-white">{{ $setting->hotline }}</p>
                            </div>
                        @endif
                        @if($setting?->office_hours)
                            <div class="rounded-2xl bg-white/15 p-4">
                                <p class="text-xs uppercase tracking-wide text-primary-200">{{ trans('web.contact.operational_hours') }}</p>
                                <p class="mt-2 text-white">{{ $setting->office_hours }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4">
                        @if($setting?->map_embed)
                            <div class="aspect-square w-full overflow-hidden rounded-2xl">
                                {!! $setting->map_embed !!}
                            </div>
                        @else
                            <div class="flex h-full items-center justify-center rounded-2xl border border-dashed border-white/40 text-sm text-primary-100">
                                {{ __('Embed peta belum diatur.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2">
                @foreach($channels as $channel)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">{{ ucfirst($channel->type) }}</p>
                        <h2 class="mt-2 text-lg font-semibold text-slate-900">{{ $channel->getTranslation('name', $activeLocale) }}</h2>
                        <p class="mt-2 text-sm text-slate-600">{{ $channel->value }}</p>
                        @if($channel->getTranslation('notes', $activeLocale))
                            <p class="mt-1 text-xs text-slate-500">{{ $channel->getTranslation('notes', $activeLocale) }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-12 rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <h2 class="text-xl font-semibold text-slate-900">{{ trans('web.announcements') }}</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-700">
                    @forelse($announcements as $announcement)
                        <li class="rounded-2xl bg-white p-4 shadow-sm">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-slate-900">{{ $announcement->getTranslation('title', $activeLocale) }}</p>
                                <span class="text-xs text-slate-500">{{ $announcement->starts_at?->translatedFormat('d F Y') }}</span>
                            </div>
                            @if($announcement->getTranslation('body', $activeLocale))
                                <p class="mt-2 text-xs text-slate-600 line-clamp-2">{{ strip_tags($announcement->getTranslation('body', $activeLocale)) }}</p>
                            @endif
                        </li>
                    @empty
                        <li class="rounded-2xl bg-white p-4 text-xs text-slate-500 shadow-sm">{{ __('Belum ada pengumuman aktif.') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
@endsection
