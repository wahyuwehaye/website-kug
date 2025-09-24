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
<body class="antialiased bg-slate-50 text-slate-900">
    <header class="relative border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
        <div class="hidden border-b border-white/10 bg-gradient-to-r from-slate-900 to-slate-800 text-xs text-slate-100 md:block">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2">
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-2 font-medium">
                        <x-ui.icon name="sparkles" class="h-4 w-4 text-amber-300" />
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
                        <a href="tel:{{ $siteSetting->phone }}" class="flex items-center gap-2 hover:text-white">
                            <x-ui.icon name="phone" class="h-4 w-4" />
                            {{ $siteSetting->phone }}
                        </a>
                    @endif
                    @if($siteSetting?->email)
                        <a href="mailto:{{ $siteSetting->email }}" class="flex items-center gap-2 hover:text-white">
                            <x-ui.icon name="envelope" class="h-4 w-4" />
                            {{ $siteSetting->email }}
                        </a>
                    @endif
                    <div class="flex items-center gap-1 rounded-full border border-white/30 px-2 py-1">
                        <span class="font-semibold">{{ trans('web.language') }}</span>
                        @foreach($availableLocales as $code => $label)
                            @php
                                $routeName = Illuminate\Support\Facades\Route::currentRouteName();
                                $parameters = request()->route()?->parameters() ?? [];
                                $query = request()->query();
                                $parameters['locale'] = $code;
                                $targetUrl = $routeName ? route($routeName, array_merge($parameters, $query)) : url($code);
                            @endphp
                            <a href="{{ $targetUrl }}" class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $activeLocale === $code ? 'bg-white text-slate-900' : 'text-slate-200 hover:text-white' }}">
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
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-xl shadow-slate-200 ring-1 ring-white/70">
                        <img src="{{ asset('storage/'.$siteSetting->logo_path) }}" alt="Logo" class="h-10 w-10 object-contain">
                    </div>
                @endif
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">Telkom University</p>
                    <h1 class="text-xl font-bold text-slate-900">
                        {{ $siteSetting?->getTranslation('name', $activeLocale) ?? trans('web.site_title') }}
                    </h1>
                    @if($tagline = $siteSetting?->getTranslation('short_description', $activeLocale))
                        <p class="text-xs text-slate-500">{{ $tagline }}</p>
                    @endif
                </div>
            </a>
            <div class="hidden flex-1 items-center justify-end gap-8 lg:flex">
                <nav class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                    @foreach($mainNavigation as $item)
                        <div class="group relative">
                            <a href="{{ $resolveUrl($item->url) }}" class="inline-flex items-center gap-1 rounded-full px-4 py-2 transition hover:bg-primary-50 hover:text-primary-700" @if($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                <span>{{ $item->getTranslation('title', $activeLocale) }}</span>
                                @if($item->children->isNotEmpty())
                                    <x-ui.icon name="arrow-right" class="h-3 w-3 rotate-90 text-slate-400 transition group-hover:text-primary-600" />
                                @endif
                            </a>
                            @if($item->children->isNotEmpty())
                                <div class="absolute left-1/2 top-full z-40 hidden w-max -translate-x-1/2 pt-5 group-hover:block group-focus-within:block">
                                    <div class="relative rounded-2xl border border-slate-100 bg-white/95 p-5 shadow-2xl ring-1 ring-slate-100/70 backdrop-blur transition duration-200 ease-out">
                                        <div class="absolute left-1/2 top-0 h-3 w-3 -translate-x-1/2 -translate-y-1 rotate-45 bg-white"></div>
                                        <div class="relative z-10 grid min-w-[240px] gap-2">
                                            @foreach($item->children as $child)
                                                <a href="{{ $resolveUrl($child->url) }}" class="flex items-start gap-3 rounded-xl px-3 py-3 text-sm transition hover:bg-primary-50 hover:text-primary-700" @if($child->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                                    <span class="mt-1 block h-2 w-2 rounded-full bg-primary-400"></span>
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
                <div class="flex items-center gap-4 text-sm">
                    @if($siteSetting?->email)
                        <a href="mailto:{{ $siteSetting->email }}" class="inline-flex items-center gap-2 text-slate-600 transition hover:text-primary-600">
                            <x-ui.icon name="envelope" class="h-5 w-5" />
                            {{ $siteSetting->email }}
                        </a>
                    @endif
                    @if($siteSetting?->hotline)
                        <span class="inline-flex items-center gap-2 rounded-full bg-primary-50 px-3 py-1 text-primary-700">
                            <x-ui.icon name="phone" class="h-4 w-4" />
                            {{ $siteSetting->hotline }}
                        </span>
                    @endif
                </div>
                </div>
                <button id="mobile-menu-toggle" type="button" class="lg:hidden">
                    <svg class="h-7 w-7 text-slate-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5" />
                    </svg>
                </button>
            </div>
            <div id="mobile-menu" class="mt-4 hidden flex-col gap-3 border-t border-slate-200 pt-4 lg:hidden">
                @foreach($mainNavigation as $item)
                    @php $collapseId = 'collapse-'.Str::slug($item->getTranslation('title', $activeLocale)); @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white/90">
                        <button type="button" class="flex w-full items-center justify-between px-4 py-3 text-left text-sm font-semibold text-slate-800" data-collapse-trigger="{{ $collapseId }}">
                            <span>{{ $item->getTranslation('title', $activeLocale) }}</span>
                            <x-ui.icon name="arrow-right" class="h-4 w-4 transition" data-collapse-icon />
                        </button>
                        <div id="{{ $collapseId }}" class="hidden border-t border-slate-200 bg-slate-50/80">
                            @if($item->children->isNotEmpty())
                                <div class="space-y-1 p-3">
                                    @foreach($item->children as $child)
                                        <a href="{{ $resolveUrl($child->url) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-slate-600 transition hover:bg-primary-50 hover:text-primary-600" @if($child->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                            <x-ui.icon name="arrow-right" class="h-3 w-3 -rotate-45 text-primary-500" />
                                            <span>{{ $child->getTranslation('title', $activeLocale) }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <a href="{{ $resolveUrl($item->url) }}" class="block px-4 py-3 text-sm text-slate-600 transition hover:bg-primary-50 hover:text-primary-600" @if($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ trans('web.view_all') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="flex flex-wrap gap-2">
                    @if($siteSetting?->facebook_url)
                        <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-xs text-slate-600">
                            <x-ui.icon name="globe-alt" class="h-4 w-4" /> FB
                        </a>
                    @endif
                    @if($siteSetting?->instagram_url)
                        <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-xs text-slate-600">
                            <x-ui.icon name="sparkles" class="h-4 w-4" /> IG
                        </a>
                    @endif
                    @if($siteSetting?->linkedin_url)
                        <a href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-xs text-slate-600">
                            <x-ui.icon name="link" class="h-4 w-4" /> IN
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-12 bg-slate-900 text-slate-200">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 md:grid-cols-3">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    @if($siteSetting?->logo_path)
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10">
                            <img src="{{ asset('storage/'.$siteSetting->logo_path) }}" alt="Logo" class="h-10 w-10 object-contain">
                        </div>
                    @endif
                    <div>
                        <h3 class="text-lg font-semibold">{{ $siteSetting?->getTranslation('name', $activeLocale) ?? trans('web.site_title') }}</h3>
                        @if($siteSetting?->getTranslation('short_description', $activeLocale))
                            <p class="text-xs text-slate-400">{{ $siteSetting->getTranslation('short_description', $activeLocale) }}</p>
                        @endif
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    @if($siteSetting?->getTranslation('address', $activeLocale))
                        <p class="flex items-start gap-2">
                            <x-ui.icon name="map-pin" class="mt-0.5 h-5 w-5 text-primary-300" />
                            <span>{{ $siteSetting->getTranslation('address', $activeLocale) }}</span>
                        </p>
                    @endif
                    @if($siteSetting?->phone)
                        <p class="flex items-center gap-2"><x-ui.icon name="phone" class="h-5 w-5 text-primary-300" /><span>{{ $siteSetting->phone }}</span></p>
                    @endif
                    @if($siteSetting?->email)
                        <p class="flex items-center gap-2"><x-ui.icon name="envelope" class="h-5 w-5 text-primary-300" /><span>{{ $siteSetting->email }}</span></p>
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
                <h3 class="text-lg font-semibold">{{ trans('web.footer.quick_links') }}</h3>
                <div class="mt-4 grid gap-2 text-sm">
                    @foreach($quickLinks as $link)
                        <a href="{{ $resolveUrl($link->url) }}" class="text-slate-300 hover:text-white" @if($link->is_external) target="_blank" rel="noopener" @endif>
                            {{ $link->getTranslation('title', $activeLocale) }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold">{{ trans('web.feedback') }}</h3>
                <p class="mt-4 text-sm text-slate-300">{{ trans('web.newsletter_cta') }}</p>
                <form class="mt-4 flex w-full flex-col gap-3">
                    <input type="email" class="w-full rounded border border-slate-700 bg-slate-800 px-4 py-2 text-sm text-white placeholder:text-slate-500 focus:border-primary-500 focus:outline-none" placeholder="{{ trans('web.newsletter_placeholder') }}" />
                    <button type="submit" class="rounded bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500">{{ trans('web.newsletter_submit') }}</button>
                </form>
                @if($siteSetting?->feedback_url)
                    <a href="{{ $siteSetting->feedback_url }}" target="_blank" rel="noopener" class="mt-3 inline-block text-sm font-semibold text-primary-300 hover:text-primary-100">
                        {{ trans('web.footer.feedback') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">
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
