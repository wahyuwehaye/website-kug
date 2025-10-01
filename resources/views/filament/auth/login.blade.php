@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;
    use App\Models\SiteSetting;

    $siteSetting = cache()->remember('filament_login_site_setting', now()->addMinutes(10), fn () => SiteSetting::query()->first());
    $about = $siteSetting?->getTranslation('short_description', app()->getLocale()) ?? 'Portal administrasi modern untuk mengelola konten Direktorat Keuangan secara cepat dan tepat.';
    $phone = $siteSetting?->phone ?? '0811-2162-204';
    $email = $siteSetting?->email ?? 'finance@telkomuniversity.ac.id';
@endphp

<div class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-slate-100 via-white to-slate-100 px-4 py-8 text-slate-800 md:px-6">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-36 top-12 h-64 w-64 rounded-full bg-red-200/30 blur-[140px]"></div>
        <div class="absolute right-[-18%] top-1/3 h-72 w-72 rounded-full bg-sky-200/25 blur-[150px]"></div>
        <div class="absolute bottom-[-25%] left-1/2 h-60 w-60 -translate-x-1/2 rounded-full bg-amber-200/25 blur-[130px]"></div>
    </div>

    <div class="relative w-full max-w-4xl">
        <div class="grid gap-6 rounded-[32px] border border-slate-200/80 bg-white/95 p-8 shadow-[0_32px_90px_-55px_rgba(15,23,42,0.45)] backdrop-blur-md md:grid-cols-[1.1fr,0.9fr] md:p-10">
            <section class="flex flex-col justify-between gap-6">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-red-50 shadow-inner">
                            <img src="{{ asset('assets/images/kug.png') }}" alt="Direktorat Keuangan" class="h-10 w-10 object-contain">
                        </span>
                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-slate-100 shadow-inner">
                            <img src="{{ asset('assets/images/Logo-Tel-U-glow.png') }}" alt="Telkom University" class="h-11 w-11 object-contain">
                        </span>
                    </div>
                    <div class="space-y-3">
                        <span class="text-[11px] font-semibold uppercase tracking-[0.32em] text-red-500">Portal Administrator</span>
                        <h1 class="text-[1.8rem] font-semibold leading-snug text-slate-900">
                            {{ $siteSetting?->getTranslation('name', app()->getLocale()) ?? 'Direktorat Keuangan Telkom University' }}
                        </h1>
                        <p class="text-sm text-slate-500">
                            {{ $about }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="glass-card p-4 text-left">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-red-500">Realtime</p>
                        <p class="mt-1 text-base font-semibold text-slate-900">Panel Terpadu</p>
                        <p class="mt-1 text-xs text-slate-500">Kelola layanan dan konten dalam satu dasbor.</p>
                    </div>
                    <div class="glass-card p-4 text-left">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-red-500">Monitoring</p>
                        <p class="mt-1 text-base font-semibold text-slate-900">Insight Instan</p>
                        <p class="mt-1 text-xs text-slate-500">Status publikasi tersaji secara real-time.</p>
                    </div>
                    <div class="glass-card p-4 text-left">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-red-500">Keamanan</p>
                        <p class="mt-1 text-base font-semibold text-slate-900">Akses Terkontrol</p>
                        <p class="mt-1 text-xs text-slate-500">Gunakan kredensial Tel-U dengan audit trail.</p>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200/80 bg-slate-50/80 p-5 text-xs text-slate-500 sm:text-sm">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                            Sistem beroperasi 24/7 dengan audit trail terjaga.
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-slate-600">
                            <a href="mailto:{{ $email }}" class="font-medium hover:text-red-500">{{ $email }}</a>
                            <span class="hidden h-1 w-1 rounded-full bg-slate-300 sm:inline"></span>
                            <span class="font-medium">{{ $phone }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="flex flex-col justify-center">
                <div class="rounded-[28px] border border-slate-200/80 bg-white p-6 shadow-[0_28px_75px_-55px_rgba(15,23,42,0.45)] md:p-8">
                    <div class="mb-6 space-y-2 text-center">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-red-500">Masuk</p>
                        <h2 class="text-xl font-semibold text-slate-900">Portal Direktorat Keuangan</h2>
                        <p class="text-xs text-slate-500">Gunakan email institusi untuk mengakses panel administrasi.</p>
                    </div>

                    {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

                    <x-filament-panels::form id="form" wire:submit="authenticate" class="space-y-5">
                        {{ $this->form }}

                        <x-filament-panels::form.actions
                            :actions="$this->getCachedFormActions()"
                            :full-width="$this->hasFullWidthFormActions()"
                        />
                    </x-filament-panels::form>

                    {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

                    <p class="mt-6 text-center text-xs text-slate-500">Butuh bantuan? Hubungi Finance Care atau Helpdesk Direktorat Keuangan.</p>
                </div>
            </section>
        </div>
    </div>
</div>

{{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
