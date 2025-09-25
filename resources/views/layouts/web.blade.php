<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trim(($title ?? '') . ' | ' . ($siteSetting?->getTranslation('name', $activeLocale) ?? trans('web.site_title'))) }}</title>
    <meta name="description" content="{{ $metaDescription ?? $siteSetting?->getTranslation('meta_description', $activeLocale) }}">
    <meta name="keywords" content="{{ $metaKeywords ?? $siteSetting?->getTranslation('meta_keywords', $activeLocale) }}">
    @if($siteSetting?->logo_path)
        <link rel="icon" type="image/png" href="{{ asset('storage/'.$siteSetting->logo_path) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        use Illuminate\Support\Str;

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
    @endphp
</head>
<body class="min-h-screen">
    <header class="sticky top-0 z-40 border-b border-white/10 bg-slate-950/85 shadow-[0_18px_35px_-25px_rgba(12,17,29,0.75)] backdrop-blur-xl">
        <div class="hidden border-b border-white/10 bg-white/5 text-xs text-slate-200 md:block">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2">
                <div class="flex items-center gap-4">
                    <span class="pill-muted">
                        <x-ui.icon name="sparkles" class="h-3.5 w-3.5 text-amber-300" />
                        {{ $siteSetting?->getTranslation('tagline', $activeLocale) ?? 'Telkom University Finance Directorate' }}
                    </span>
                    @foreach($topNavigation as $link)
                        <a href="{{ $resolveUrl($link->url) }}" class="hidden items-center gap-1 rounded-full px-3 py-1 text-slate-200 transition hover:bg-white/10 hover:text-white lg:flex" @if($link->is_external) target="_blank" rel="noopener noreferrer" @endif>
                            {{ $link->getTranslation('title', $activeLocale) }}
                        </a>
                    @endforeach
                </div>
                <div class="flex items-center gap-4">
                    @if($siteSetting?->phone)
                        <a href="tel:{{ $siteSetting->phone }}" class="inline-flex items-center gap-2 text-slate-200 transition hover:text-white">
                            <x-ui.icon name="phone" class="h-4 w-4" />
                            {{ $siteSetting->phone }}
                        </a>
                    @endif
                    @if($siteSetting?->email)
                        <a href="mailto:{{ $siteSetting->email }}" class="inline-flex items-center gap-2 text-slate-200 transition hover:text-white">
                            <x-ui.icon name="envelope" class="h-4 w-4" />
                            {{ $siteSetting->email }}
                        </a>
                    @endif
                    <div class="inline-flex items-center gap-1 rounded-full border border-white/20 px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.3em] text-slate-200">
                        <span>{{ trans('web.language') }}</span>
                        @foreach($availableLocales as $code => $label)
                            @php
                                $routeName = Illuminate\Support\Facades\Route::currentRouteName();
                                $parameters = request()->route()?->parameters() ?? [];
                                $query = request()->query();
                                $parameters['locale'] = $code;
                                $targetUrl = $routeName ? route($routeName, array_merge($parameters, $query)) : url($code);
                            @endphp
                            <a href="{{ $targetUrl }}" class="rounded-full px-2 py-0.5 text-xs font-semibold transition {{ $activeLocale === $code ? 'bg-white text-slate-900' : 'text-slate-200 hover:text-white' }}">
                                {{ Str::upper($code) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-5">
            <a href="{{ route('home', ['locale' => $activeLocale]) }}" class="flex items-center gap-3">
                @if($siteSetting?->logo_path)
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 shadow-lg shadow-black/40 ring-1 ring-white/20">
                        <img src="{{ asset('storage/'.$siteSetting->logo_path) }}" alt="Logo" class="h-10 w-10 object-contain">
                    </div>
                @endif
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-amber-200">Telkom University</p>
                    <h1 class="text-xl font-semibold text-white">
                        {{ $siteSetting?->getTranslation('name', $activeLocale) ?? trans('web.site_title') }}
                    </h1>
                    @if($tagline = $siteSetting?->getTranslation('short_description', $activeLocale))
                        <p class="text-xs text-slate-300">{{ $tagline }}</p>
                    @endif
                </div>
            </a>
            <div class="hidden flex-1 items-center justify-end gap-8 lg:flex">
                <nav class="glass-tile inline-flex items-center gap-2 border-white/10 bg-white/5 px-2 py-1 text-sm font-semibold text-slate-200">
                    @foreach($mainNavigation as $item)
                        <div class="group relative">
                            <a href="{{ $resolveUrl($item->url) }}" class="inline-flex items-center gap-2 rounded-full px-4 py-2 transition hover:bg-white/10 hover:text-white" @if($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                <span>{{ $item->getTranslation('title', $activeLocale) }}</span>
                                @if($item->children->isNotEmpty())
                                    <x-ui.icon name="arrow-right" class="h-3 w-3 rotate-90 text-slate-400 transition group-hover:text-amber-200" />
                                @endif
                            </a>
                            @if($item->children->isNotEmpty())
                                <div class="absolute left-1/2 top-[calc(100%+0.75rem)] z-40 hidden w-max -translate-x-1/2 group-hover:block">
                                    <div class="glass-tile min-w-[240px] border-white/10 bg-slate-950/95 p-4">
                                        <div class="space-y-1">
                                            @foreach($item->children as $child)
                                                <a href="{{ $resolveUrl($child->url) }}" class="flex items-start gap-3 rounded-2xl px-3 py-2 text-sm text-slate-200 transition hover:bg-white/5 hover:text-white" @if($child->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                                    <span class="mt-1 block h-1.5 w-1.5 rounded-full bg-amber-300"></span>
                                                    <span>{{ $child->getTranslation('title', $activeLocale) }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </nav>
                <div class="flex items-center gap-3 text-sm">
                    @if($siteSetting?->email)
                        <a href="mailto:{{ $siteSetting->email }}" class="inline-flex items-center gap-2 text-slate-200 transition hover:text-white">
                            <x-ui.icon name="envelope" class="h-5 w-5" />
                            {{ $siteSetting->email }}
                        </a>
                    @endif
                    @if($siteSetting?->hotline)
                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-400/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-amber-200">
                            <x-ui.icon name="phone" class="h-4 w-4" />
                            {{ $siteSetting->hotline }}
                        </span>
                    @endif
                </div>
            </div>
            <button id="mobile-menu-toggle" type="button" class="lg:hidden">
                <svg class="h-7 w-7 text-slate-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5" />
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="mx-4 mb-4 hidden flex-col gap-3 rounded-3xl border border-white/10 bg-slate-950/90 p-4 text-sm text-slate-200 shadow-xl shadow-black/40 lg:hidden">
            @foreach($mainNavigation as $item)
                @php $collapseId = 'collapse-'.Str::slug($item->getTranslation('title', $activeLocale)); @endphp
                <div class="glass-tile border-white/10 bg-white/5">
                    <button type="button" class="flex w-full items-center justify-between px-4 py-3 text-left text-sm font-semibold text-white" data-collapse-trigger="{{ $collapseId }}">
                        <span>{{ $item->getTranslation('title', $activeLocale) }}</span>
                        <x-ui.icon name="arrow-right" class="h-4 w-4 transition text-slate-300" data-collapse-icon />
                    </button>
                    <div id="{{ $collapseId }}" class="hidden border-t border-white/10 bg-white/5">
                        @if($item->children->isNotEmpty())
                            <div class="space-y-1 p-3">
                                @foreach($item->children as $child)
                                    <a href="{{ $resolveUrl($child->url) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-slate-200 transition hover:bg-white/10 hover:text-white" @if($child->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                        <x-ui.icon name="arrow-right" class="h-3 w-3 -rotate-45 text-amber-300" />
                                        <span>{{ $child->getTranslation('title', $activeLocale) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ $resolveUrl($item->url) }}" class="block px-4 py-3 text-sm text-slate-200 transition hover:bg-white/10 hover:text-white" @if($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                {{ trans('web.view_all') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="flex flex-wrap gap-2">
                @if($siteSetting?->facebook_url)
                    <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-3 py-1 text-xs text-slate-200">
                        <x-ui.icon name="globe-alt" class="h-4 w-4" /> FB
                    </a>
                @endif
                @if($siteSetting?->instagram_url)
                    <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-3 py-1 text-xs text-slate-200">
                        <x-ui.icon name="sparkles" class="h-4 w-4" /> IG
                    </a>
                @endif
                @if($siteSetting?->linkedin_url)
                    <a href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-3 py-1 text-xs text-slate-200">
                        <x-ui.icon name="link" class="h-4 w-4" /> IN
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main class="relative">
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-white/10 bg-slate-950/80 text-slate-200">
        <div class="section-shell grid gap-10 md:grid-cols-3">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    @if($siteSetting?->logo_path)
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10">
                            <img src="{{ asset('storage/'.$siteSetting->logo_path) }}" alt="Logo" class="h-10 w-10 object-contain">
                        </div>
                    @endif
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $siteSetting?->getTranslation('name', $activeLocale) ?? trans('web.site_title') }}</h3>
                        @if($siteSetting?->getTranslation('short_description', $activeLocale))
                            <p class="text-xs text-slate-400">{{ $siteSetting->getTranslation('short_description', $activeLocale) }}</p>
                        @endif
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    @if($siteSetting?->getTranslation('address', $activeLocale))
                        <p class="flex items-start gap-2">
                            <x-ui.icon name="map-pin" class="mt-0.5 h-5 w-5 text-amber-200" />
                            <span>{{ $siteSetting->getTranslation('address', $activeLocale) }}</span>
                        </p>
                    @endif
                    @if($siteSetting?->phone)
                        <p class="flex items-center gap-2"><x-ui.icon name="phone" class="h-5 w-5 text-amber-200" /><span>{{ $siteSetting->phone }}</span></p>
                    @endif
                    @if($siteSetting?->email)
                        <p class="flex items-center gap-2"><x-ui.icon name="envelope" class="h-5 w-5 text-amber-200" /><span>{{ $siteSetting->email }}</span></p>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    @if($siteSetting?->facebook_url)
                        <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-200 transition hover:bg-white hover:text-slate-900">FB</a>
                    @endif
                    @if($siteSetting?->instagram_url)
                        <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-200 transition hover:bg-white hover:text-slate-900">IG</a>
                    @endif
                    @if($siteSetting?->linkedin_url)
                        <a href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-200 transition hover:bg-white hover:text-slate-900">IN</a>
                    @endif
                    @if($siteSetting?->youtube_url)
                        <a href="{{ $siteSetting->youtube_url }}" target="_blank" rel="noopener" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-200 transition hover:bg-white hover:text-slate-900">YT</a>
                    @endif
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">{{ trans('web.footer.quick_links') }}</h3>
                <div class="mt-4 grid gap-2 text-sm">
                    @foreach($quickLinks as $link)
                        <a href="{{ $resolveUrl($link->url) }}" class="text-slate-300 transition hover:text-white" @if($link->is_external) target="_blank" rel="noopener" @endif>
                            {{ $link->getTranslation('title', $activeLocale) }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">{{ trans('web.feedback') }}</h3>
                <p class="mt-4 text-sm text-slate-300">{{ trans('web.newsletter_cta') }}</p>
                <form class="mt-4 flex w-full flex-col gap-3">
                    <input type="email" class="w-full rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-white placeholder:text-slate-400 focus:border-amber-300 focus:outline-none" placeholder="{{ trans('web.newsletter_placeholder') }}" />
                    <button type="submit" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">{{ trans('web.newsletter_submit') }}</button>
                </form>
                @if($siteSetting?->feedback_url)
                    <a href="{{ $siteSetting->feedback_url }}" target="_blank" rel="noopener" class="mt-3 inline-block text-sm font-semibold text-amber-200 transition hover:text-amber-100">
                        {{ trans('web.footer.feedback') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="border-t border-white/10 py-4 text-center text-xs text-slate-500">
            {{ str_replace(':year', now()->year, trans('web.footer.rights')) }}
        </div>
    </footer>

    <script>
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileToggle?.addEventListener('click', () => {
            mobileMenu?.classList.toggle('hidden');
        });

        document.querySelectorAll('[data-collapse-trigger]').forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const targetId = trigger.getAttribute('data-collapse-trigger');
                const target = document.getElementById(targetId);
                const icon = trigger.querySelector('[data-collapse-icon]');

                if (!target) return;

                const willOpen = target.classList.contains('hidden');
                target.classList.toggle('hidden');
                if (willOpen) {
                    icon?.classList.add('rotate-90');
                } else {
                    icon?.classList.remove('rotate-90');
                }
            });
        });
    </script>
</body>
</html>
