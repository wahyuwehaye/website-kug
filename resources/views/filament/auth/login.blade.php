@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;
    use App\Models\SiteSetting;

    $siteSetting = cache()->remember('filament_login_site_setting', now()->addMinutes(10), fn () => SiteSetting::query()->first());
    $about = $siteSetting?->getTranslation('short_description', app()->getLocale()) ?? 'Portal administrasi modern untuk mengelola konten Direktorat Keuangan secara cepat dan tepat.';
    $phone = $siteSetting?->phone ?? '0811-2162-204';
    $whatsapp = $siteSetting?->whatsapp ?? '0822-1416-1954';
@endphp

<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-slate-100 via-white to-slate-100 px-6 py-12 text-slate-800">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-24 top-16 h-80 w-80 rounded-full bg-red-300/20 blur-[120px]"></div>
        <div class="absolute right-[-10%] top-1/3 h-96 w-96 rounded-full bg-emerald-200/20 blur-[180px]"></div>
        <div class="absolute -bottom-28 left-1/4 h-72 w-72 rounded-full bg-amber-200/25 blur-[160px]"></div>
    </div>

    <div class="relative w-full max-w-6xl">
        <div class="grid gap-8 lg:grid-cols-[1.05fr,0.95fr]">
            <section class="rounded-[36px] border border-white/70 bg-white/90 p-10 shadow-[0_40px_100px_-60px_rgba(15,23,42,0.4)] backdrop-blur">
                <div class="flex flex-col justify-between gap-10">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-4">
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-gradient-to-br from-red-100 to-white shadow-inner">
                                <img src="{{ asset('assets/images/kug.png') }}" alt="Direktorat Keuangan" class="h-10 w-10 object-contain">
                            </span>
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-gradient-to-br from-slate-100 to-white shadow-inner">
                                <img src="{{ asset('assets/images/Logo-Tel-U-glow.png') }}" alt="Telkom University" class="h-11 w-11 object-contain">
                            </span>
                        </div>
                        <div>
                            <span class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.38em] text-red-500">
                                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                Portal Administrator
                            </span>
                            <h1 class="mt-4 text-[2rem] font-semibold leading-tight text-slate-900">
                                {{ $siteSetting?->getTranslation('name', app()->getLocale()) ?? 'Direktorat Keuangan Telkom University' }}
                            </h1>
                            <p class="mt-4 max-w-xl text-sm text-slate-600 lg:text-base">
                                {{ $about }}
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="glass-card p-5">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-red-500">Realtime</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">Panel Terpadu</p>
                            <p class="mt-2 text-xs text-slate-500">Kelola navigasi, konten, media, dan publikasi dalam satu dasbor.</p>
                        </div>
                        <div class="glass-card p-5">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-red-500">Monitoring</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">Insight Instan</p>
                            <p class="mt-2 text-xs text-slate-500">Pantau status publikasi, dokumen, dan statistik secara langsung.</p>
                        </div>
                        <div class="glass-card p-5">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-red-500">Keamanan</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">Akses Terkontrol</p>
                            <p class="mt-2 text-xs text-slate-500">Gunakan akun resmi Telkom University dengan jejak audit terjaga.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-slate-50/80 p-6 text-sm text-slate-600 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-red-500">Finance Care</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ $phone }}</p>
                            <p class="text-xs text-slate-500">Senin - Jumat, 08.00 - 16.30 WIB</p>
                        </div>
                        <div class="hidden h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-red-100 to-amber-100 text-red-500 sm:flex">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15H19.5a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.09l-4.423-1.105a1.125 1.125 0 00-1.173.417l-.97 1.293a.75.75 0 01-1.21.038l-2.014-2.608a.75.75 0 01.063-.99l1.248-1.248a1.125 1.125 0 00.3-1.103L10.96 5.31a1.125 1.125 0 00-1.09-.852H8.5A2.25 2.25 0 006.25 6.75v0" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>

            <section class="relative rounded-[36px] border border-slate-200 bg-white p-8 shadow-[0_34px_80px_-60px_rgba(15,23,42,0.55)] sm:p-12">
                <div class="mb-8 space-y-4">
                    <div class="flex items-center gap-3 text-red-500">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-3xl bg-red-50 text-red-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M12 18.75V21M21 12h-2.25M5.25 12H3m14.137-6.363-1.59 1.59M6.453 17.137l-1.59 1.59M17.137 17.137l1.59 1.59M6.453 6.453l1.59 1.59M8.25 12a3.75 3.75 0 1 0 7.5 0 3.75 3.75 0 0 0-7.5 0z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.32em]">Portal Administrator</p>
                            <p class="text-sm text-slate-500">Direktorat Keuangan Telkom University</p>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-900">{{ $this->getHeading() }}</h2>
                        <p class="mt-2 text-sm text-slate-500">{{ $this->getSubheading() }}</p>
                    </div>
                </div>

                @if (filament()->hasRegistration())
                    <div class="mb-5 rounded-3xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-500">
                        {{ __('filament-panels::pages/auth/login.actions.register.before') }}
                        {{ $this->registerAction }}
                    </div>
                @endif

                {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

                <x-filament-panels::form id="form" wire:submit="authenticate" class="space-y-6">
                    {{ $this->form }}

                    <x-filament-panels::form.actions
                        :actions="$this->getCachedFormActions()"
                        :full-width="$this->hasFullWidthFormActions()"
                    />
                </x-filament-panels::form>

                {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

                <div class="mt-10 flex flex-col gap-4 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                        Sistem siap digunakan 24/7 dengan audit trail terjaga.
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        @if ($siteSetting?->email)
                            <a href="mailto:{{ $siteSetting->email }}" class="font-medium text-slate-600 hover:text-red-500">{{ $siteSetting->email }}</a>
                        @endif
                        @if ($whatsapp)
                            <span class="hidden h-1 w-1 rounded-full bg-slate-300 sm:inline"></span>
                            <span class="font-medium text-slate-600">{{ $whatsapp }}</span>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

{{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
