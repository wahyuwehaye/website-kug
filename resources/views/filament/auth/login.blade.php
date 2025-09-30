@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;
    use App\Models\SiteSetting;

    $siteSetting = cache()->remember('filament_login_site_setting', now()->addMinutes(10), fn () => SiteSetting::query()->first());
    $tagline = $siteSetting?->getTranslation('tagline', app()->getLocale()) ?? 'Transparansi Layanan Keuangan Telkom University';
    $about = $siteSetting?->getTranslation('short_description', app()->getLocale()) ?? 'Portal administrasi modern untuk mengelola konten Direktorat Keuangan secara cepat dan tepat.';
@endphp

<x-filament-panels::layout.base :livewire="$this">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-slate-950 px-6 py-12 text-slate-100">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-24 top-12 h-72 w-72 rounded-full bg-primary-500/40 blur-[120px]"></div>
            <div class="absolute right-0 top-1/3 h-96 w-96 rounded-full bg-amber-400/30 blur-[180px]"></div>
            <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-blue-500/30 blur-[140px]"></div>
        </div>

        <div class="relative w-full max-w-6xl">
            <div class="grid gap-8 lg:grid-cols-[1.05fr,0.95fr]">
                <div class="flex flex-col justify-between rounded-[28px] border border-white/10 bg-white/10 p-10 shadow-2xl backdrop-blur-xl">
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15">
                                <img src="{{ asset('assets/images/kug.png') }}" alt="Direktorat Keuangan" class="h-10 w-10 object-contain">
                            </span>
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
                                <img src="{{ asset('assets/images/Logo-Tel-U-glow.png') }}" alt="Telkom University" class="h-9 w-9 object-contain">
                            </span>
                        </div>
                        <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.4em] text-amber-200">
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                            Finance Directorate
                        </span>
                        <div class="space-y-4">
                            <h1 class="text-3xl font-bold leading-tight text-white lg:text-4xl">
                                {{ $siteSetting?->getTranslation('name', app()->getLocale()) ?? 'Direktorat Keuangan Telkom University' }}
                            </h1>
                            <p class="text-sm text-slate-200 lg:text-base">
                                {{ $about }}
                            </p>
                        </div>
                    </div>
                    <dl class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <dt class="text-[11px] uppercase tracking-[0.3em] text-slate-300">Realtime</dt>
                            <dd class="mt-2 text-lg font-semibold text-white">Panel Terintegrasi</dd>
                            <p class="mt-2 text-xs text-slate-300">Kelola navigasi, konten, media, dan publikasi dalam satu dasbor.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <dt class="text-[11px] uppercase tracking-[0.3em] text-slate-300">Monitoring</dt>
                            <dd class="mt-2 text-lg font-semibold text-white">Insight Langsung</dd>
                            <p class="mt-2 text-xs text-slate-300">Pantau status publikasi dan dokumen dengan highlight kontekstual.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <dt class="text-[11px] uppercase tracking-[0.3em] text-slate-300">Kolaborasi</dt>
                            <dd class="mt-2 text-lg font-semibold text-white">Akses Terkontrol</dd>
                            <p class="mt-2 text-xs text-slate-300">Gunakan peran aman berbasis akun terverifikasi Telkom University.</p>
                        </div>
                    </dl>
                    <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-slate-950/40 p-5 text-sm text-slate-200">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-amber-200">Support Center</p>
                            <p class="mt-1 font-semibold">{{ $siteSetting?->phone ?? '+62 22 7564 108' }}</p>
                        </div>
                        <div class="hidden h-12 w-12 items-center justify-center rounded-full border border-amber-200/40 bg-amber-200/20 text-amber-200 sm:flex">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15H19.5a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.09l-4.423-1.105a1.125 1.125 0 00-1.173.417l-.97 1.293a.75.75 0 01-1.21.038l-2.014-2.608a.75.75 0 01.063-.99l1.248-1.248a1.125 1.125 0 00.3-1.103L10.96 5.31a1.125 1.125 0 00-1.09-.852H8.5A2.25 2.25 0 006.25 6.75v0" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="relative rounded-[28px] border border-white/10 bg-slate-950/80 p-8 shadow-2xl backdrop-blur-xl sm:p-12">
                    <div class="mb-8 space-y-4">
                        <div class="flex items-center gap-3 text-amber-200">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-300/10 text-amber-200">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M12 18.75V21M21 12h-2.25M5.25 12H3m14.137-6.363-1.59 1.59M6.453 17.137l-1.59 1.59M17.137 17.137l1.59 1.59M6.453 6.453l1.59 1.59M8.25 12a3.75 3.75 0 1 0 7.5 0 3.75 3.75 0 0 0-7.5 0z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-amber-200">Portal Administrator</p>
                                <p class="text-sm text-slate-300">Direktorat Keuangan Telkom University</p>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-semibold text-white">{{ $this->getHeading() }}</h2>
                            <p class="mt-2 text-sm text-slate-300">{{ $this->getSubheading() }}</p>
                        </div>
                    </div>

                    @if (filament()->hasRegistration())
                        <div class="mb-4 rounded-2xl border border-white/10 bg-white/5 p-4 text-xs text-slate-300">
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

                    <div class="mt-8 flex flex-col gap-4 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                            Sistem siap digunakan 24/7 dengan audit trail terjaga.
                        </div>
                        <div class="flex items-center gap-3">
                            @if ($siteSetting?->email)
                                <a href="mailto:{{ $siteSetting->email }}" class="hover:text-amber-200">{{ $siteSetting->email }}</a>
                            @endif
                            @if ($siteSetting?->whatsapp)
                                <span class="hidden h-1 w-1 rounded-full bg-slate-600 sm:inline"></span>
                                <span>{{ $siteSetting->whatsapp }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::layout.base>
