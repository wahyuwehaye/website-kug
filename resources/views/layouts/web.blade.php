<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trim(($title ?? '') . ' | ' . ($siteSetting?->getTranslation('name', $activeLocale) ?? trans('web.site_title'))) }}</title>
    <meta name="description" content="{{ $metaDescription ?? $siteSetting?->getTranslation('meta_description', $activeLocale) }}">
    <meta name="keywords" content="{{ $metaKeywords ?? $siteSetting?->getTranslation('meta_keywords', $activeLocale) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha512-p0VfM9Gx7cN1NQikprADH+fB1S7yXp8uDKBoHyN6Sze1onrCq0Q2nv6N36CBuhwP/d9vyJqBiZ9p2J6kR7YCAw=="
        crossorigin=""
    >
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha512-VgXQymJmq9Z3rroWAtxEvsC0BpvyEukgqS0bkkCm1cWg5kyRjO6jwxKF1u9IiVbGi4ZTSdKCbFf8cpL4qkY7/Q=="
        crossorigin=""
        defer
    ></script>

    @php
        use Illuminate\Support\Str;

        $resolveAsset = function (?string $path) {
            if (! $path) {
                return null;
            }

            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }

            if (Str::startsWith($path, '/')) {
                return url(ltrim($path, '/'));
            }

            if (Str::startsWith($path, 'assets/')) {
                return asset($path);
            }

            return asset('storage/' . ltrim($path, '/'));
        };

        $resolveUrl = function (?string $url) use ($activeLocale) {
            if (! $url) {
                return '#';
            }

            if (Str::startsWith($url, '#')) {
                return route('home', ['locale' => $activeLocale]) . $url;
            }

            if (Str::contains($url, ':locale')) {
                return str_replace(':locale', $activeLocale, $url);
            }

            if (Str::startsWith($url, '/')) {
                return url($activeLocale . '/' . ltrim($url, '/'));
            }

            return $url;
        };

        $favicon = asset('assets/images/kug.png');
        $primaryLogo = asset('assets/images/logo-kug-panjang.png');
    @endphp

    <link rel="icon" type="image/png" href="{{ $favicon }}">
</head>
<body class="min-h-screen">
    <header class="sticky top-0 z-40">
        <div class="relative bg-gradient-to-r from-[#BF121C] via-[#D62C3C] to-[#8F111F] text-[11px] uppercase tracking-[0.32em] text-rose-50 shadow-[0_12px_32px_-18px_rgba(127,17,28,0.65)] backdrop-blur">
            <div class="container-shell flex flex-wrap items-center justify-between gap-4 py-3">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 rounded-2xl bg-white px-4 py-2 shadow-lg shadow-red-900/20">
                        <img src="{{ $primaryLogo }}" alt="Logo Direktorat Keuangan Telkom University" class="h-9 w-auto max-w-[220px] sm:h-10" loading="lazy">
                    </div>
                    <div class="hidden flex-col text-white md:flex">
                        <span class="font-semibold tracking-[0.32em]">{{ Str::upper($siteSetting?->getTranslation('tagline', $activeLocale) ?? 'Finance Directorate Telkom University') }}</span>
                        <span class="mt-1 text-[10px] normal-case tracking-[0.2em] text-white/80">{{ __('Transparansi • Integritas • Layanan Terintegrasi') }}</span>
                    </div>
                </div>
                <div class="flex flex-1 items-center justify-end gap-3 text-[10px] md:justify-between">
                    <div class="hidden items-center gap-2 md:flex">
                        @foreach($topNavigation as $link)
                            <a href="{{ $resolveUrl($link->url) }}" class="btn-ghost" @if($link->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                {{ $link->getTranslation('title', $activeLocale) }}
                            </a>
                        @endforeach
                    </div>
                    <div class="inline-flex items-center gap-1 rounded-full border border-white/15 bg-white/5 px-2 py-1">
                        <span class="px-2 text-[10px] font-semibold text-slate-200">{{ trans('web.language') }}</span>
                        @foreach($availableLocales as $code => $label)
                            @php
                                $routeName = Illuminate\Support\Facades\Route::currentRouteName();
                                $parameters = request()->route()?->parameters() ?? [];
                                $query = request()->query();
                                $parameters['locale'] = $code;
                                $targetUrl = $routeName ? route($routeName, array_merge($parameters, $query)) : url($code);
                            @endphp
                            <a href="{{ $targetUrl }}" class="rounded-full px-2 py-0.5 text-[10px] font-semibold transition {{ $activeLocale === $code ? 'bg-white text-slate-900' : 'text-slate-200 hover:text-white' }}">
                                {{ Str::upper($code) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white/95 shadow-sm shadow-slate-200/60 backdrop-blur">
            <div class="container-shell flex items-center justify-between gap-6 py-4">
                <a href="{{ route('home', ['locale' => $activeLocale]) }}" class="flex flex-col gap-1 text-left">
                    <span class="text-xs font-semibold uppercase tracking-[0.4em] text-red-600">Telkom University</span>
                    <span class="text-xl font-semibold text-slate-900 md:text-2xl">{{ $siteSetting?->getTranslation('name', $activeLocale) ?? trans('web.site_title') }}</span>
                    @if($strapline = $siteSetting?->getTranslation('short_description', $activeLocale))
                        <span class="text-xs text-slate-500 md:text-sm">{{ $strapline }}</span>
                    @endif
                </a>
                <nav class="hidden items-center gap-2 text-sm font-semibold text-slate-700 lg:flex">
                    @foreach($mainNavigation as $item)
                        <div class="relative" data-nav-item>
                            <a href="{{ $resolveUrl($item->url) }}" class="inline-flex items-center gap-2 rounded-full px-5 py-3 transition hover:bg-red-50 hover:text-red-600" @if($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                <span>{{ $item->getTranslation('title', $activeLocale) }}</span>
                                @if($item->children->isNotEmpty())
                                    <x-ui.icon name="arrow-right" class="h-3 w-3 rotate-90 text-slate-400 transition" />
                                @endif
                            </a>
                            @if($item->children->isNotEmpty())
                                <div class="pointer-events-none absolute left-1/2 top-[calc(100%+0.75rem)] z-30 w-[320px] -translate-x-1/2 rounded-3xl border border-slate-100 bg-white p-5 opacity-0 shadow-[0_25px_60px_-35px_rgba(15,23,42,0.4)] transition" data-nav-menu>
                                    <div class="grid gap-2">
                                        @foreach($item->children as $child)
                                            <a href="{{ $resolveUrl($child->url) }}" class="flex items-start gap-3 rounded-2xl px-4 py-3 text-sm text-slate-600 transition hover:bg-red-50 hover:text-red-600" @if($child->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                                <span class="mt-1 h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                <div class="space-y-1">
                                                    <p class="font-semibold">{{ $child->getTranslation('title', $activeLocale) }}</p>
                                                    @if($child->description ?? false)
                                                        <p class="text-xs text-slate-400">{{ $child->description }}</p>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </nav>
                <button id="mobile-menu-toggle" type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm lg:hidden">
                    <svg class="h-6 w-6 text-slate-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="container-shell mb-4 hidden flex-col gap-3 rounded-3xl border border-slate-100 bg-white px-4 py-4 text-sm text-slate-700 shadow-[0_28px_80px_-48px_rgba(15,23,42,0.4)] lg:hidden">
            @foreach($mainNavigation as $item)
                @php $collapseId = 'collapse-'.Str::slug($item->getTranslation('title', $activeLocale)); @endphp
                <div class="rounded-2xl border border-slate-200/80">
                    <button type="button" class="flex w-full items-center justify-between px-4 py-3 text-left font-semibold" data-collapse-trigger="{{ $collapseId }}">
                        <span>{{ $item->getTranslation('title', $activeLocale) }}</span>
                        <x-ui.icon name="arrow-right" class="h-4 w-4 text-slate-400 transition" data-collapse-icon />
                    </button>
                    <div id="{{ $collapseId }}" class="hidden border-t border-slate-200 bg-slate-50" data-collapse-target>
                        @if($item->children->isNotEmpty())
                            <div class="space-y-1 p-3">
                                @foreach($item->children as $child)
                                    <a href="{{ $resolveUrl($child->url) }}" class="flex items-center gap-2 rounded-2xl px-3 py-2 text-slate-600 transition hover:bg-red-50 hover:text-red-600" @if($child->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                        <x-ui.icon name="arrow-right" class="h-3 w-3 -rotate-45 text-red-500" />
                                        <span>{{ $child->getTranslation('title', $activeLocale) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ $resolveUrl($item->url) }}" class="block px-4 py-3 text-slate-600 transition hover:bg-red-50 hover:text-red-600" @if($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                {{ trans('web.view_all') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="flex flex-wrap gap-2 text-xs">
                @if($siteSetting?->facebook_url)
                    <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-slate-600">
                        <x-ui.icon name="globe-alt" class="h-4 w-4" /> FB
                    </a>
                @endif
                @if($siteSetting?->instagram_url)
                    <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-slate-600">
                        <x-ui.icon name="sparkles" class="h-4 w-4" /> IG
                    </a>
                @endif
                @if($siteSetting?->linkedin_url)
                    <a href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-slate-600">
                        <x-ui.icon name="link" class="h-4 w-4" /> IN
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="site-footer__top">
            <div class="site-footer__grid">
                <div class="site-footer__brand">
                    <img src="{{ asset('assets/images/Logo-Tel-U-glow.png') }}" alt="Telkom University" loading="lazy">
                    <h3 class="text-lg font-semibold text-white">{{ $siteSetting?->getTranslation('name', $activeLocale) ?? trans('web.site_title') }}</h3>
                    @if($siteSetting?->getTranslation('short_description', $activeLocale))
                        <p>{{ $siteSetting->getTranslation('short_description', $activeLocale) }}</p>
                    @endif
                    @if($siteSetting?->getTranslation('address', $activeLocale))
                        <p class="flex items-start gap-2 text-sm text-slate-400">
                            <x-ui.icon name="map-pin" class="mt-1 h-4 w-4 text-red-400" />
                            <span>{{ $siteSetting->getTranslation('address', $activeLocale) }}</span>
                        </p>
                    @endif
                </div>
                <div>
                    <p class="site-footer__heading">{{ trans('web.footer.quick_links') }}</p>
                    <div class="site-footer__links">
                        @foreach($quickLinks as $link)
                            <a href="{{ $resolveUrl($link->url) }}" @if($link->is_external) target="_blank" rel="noopener" @endif>
                                {{ $link->getTranslation('title', $activeLocale) }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <p class="site-footer__heading">{{ __('Kontak') }}</p>
                    <div class="site-footer__contact">
                        @if($siteSetting?->phone)
                            <p>{{ $siteSetting->phone }}</p>
                        @endif
                        @if($siteSetting?->whatsapp)
                            <p>{{ $siteSetting->whatsapp }}</p>
                        @endif
                        @if($siteSetting?->email)
                            <p>{{ $siteSetting->email }}</p>
                        @endif
                        @if($siteSetting?->feedback_url)
                            <a href="{{ $siteSetting->feedback_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-slate-300 hover:text-white">
                                <x-ui.icon name="link" class="h-4 w-4" /> {{ trans('web.footer.feedback') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="site-footer__bottom">
            <div class="site-footer__bottom-inner">
                <p>&copy; {{ now()->year }} {{ $siteSetting?->getTranslation('name', $activeLocale) ?? 'Finance Directorate Telkom University' }}. {{ __('All rights reserved.') }}</p>
                <div class="site-footer__socials">
                    @if($siteSetting?->facebook_url)
                        <x-ui.social-icon type="facebook" :href="$siteSetting->facebook_url" label="Facebook" />
                    @endif
                    @if($siteSetting?->instagram_url)
                        <x-ui.social-icon type="instagram" :href="$siteSetting->instagram_url" label="Instagram" />
                    @endif
                    @if($siteSetting?->linkedin_url)
                        <x-ui.social-icon type="linkedin" :href="$siteSetting->linkedin_url" label="LinkedIn" />
                    @endif
                    @if($siteSetting?->youtube_url)
                        <x-ui.social-icon type="youtube" :href="$siteSetting->youtube_url" label="YouTube" />
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <button type="button" class="chatbot-floating-button" data-chatbot-toggle>
        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12c0 6.075 4.925 11 11 11 1.093 0 2.151-.155 3.158-.447a1.125 1.125 0 01.944.124l2.602 1.56a.563.563 0 00.84-.49l-.001-2.807a1.125 1.125 0 01.318-.783A10.96 10.96 0 0022.75 12c0-6.075-4.925-11-11-11s-11 4.925-11 11z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9.75h.008v.008H8.25V9.75zm7.5 0h.008v.008h-.008V9.75zm-7.5 4.5h7.5" />
        </svg>
    </button>

    <div class="chatbot-panel hidden" data-chatbot-panel>
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">{{ __('Asisten Keuangan') }}</p>
                <p class="text-sm font-semibold text-slate-900">Finance Care Assistant</p>
            </div>
            <button type="button" class="rounded-full border border-slate-200 p-2 text-slate-500 hover:text-red-500" data-chatbot-toggle>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="space-y-3 border-b border-slate-200 px-5 py-4 text-xs text-slate-500">
            <p>{{ __('Pilih salah satu topik atau tulis pertanyaan Anda:') }}</p>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="btn-ghost !bg-red-50 !text-red-600" data-chatbot-quick="layanan">{{ __('Layanan Dana') }}</button>
                <button type="button" class="btn-ghost" data-chatbot-quick="dokumen">{{ __('Dokumen Publik') }}</button>
                <button type="button" class="btn-ghost" data-chatbot-quick="kontak">{{ __('Kontak & Hotline') }}</button>
                <button type="button" class="btn-ghost" data-chatbot-quick="faq">{{ __('FAQ Keuangan') }}</button>
            </div>
        </div>
        <div class="chatbot-messages" data-chatbot-messages></div>
        <form class="flex items-center gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4" data-chatbot-form>
            <input type="text" class="flex-1 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 focus:border-red-400 focus:outline-none" placeholder="{{ __('Tulis pesan Anda di sini...') }}" data-chatbot-input>
            <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-600 text-white shadow">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.25l13.5 6.75-13.5 6.75v-5.25l9-1.5-9-1.5z" />
                </svg>
            </button>
        </form>
    </div>
</body>
</html>
