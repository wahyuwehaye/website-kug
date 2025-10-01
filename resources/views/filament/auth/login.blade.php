@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;
    use App\Models\SiteSetting;

    $siteSetting = cache()->remember('filament_login_site_setting', now()->addMinutes(10), fn () => SiteSetting::query()->first());
    $title = $siteSetting?->getTranslation('name', app()->getLocale()) ?? 'Direktorat Keuangan Telkom University';
    $tagline = $siteSetting?->getTranslation('tagline', app()->getLocale()) ?? 'Layanan Keuangan Terintegrasi Telkom University';
    $email = $siteSetting?->email ?? 'finance@telkomuniversity.ac.id';
    $phone = $siteSetting?->phone ?? '0811-2162-204';
@endphp

<div class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-[#fee2e2] via-white to-[#f1f5f9] px-4 py-10 text-slate-800">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-20 top-10 h-52 w-52 rounded-full bg-red-300/20 blur-[120px]"></div>
        <div class="absolute bottom-0 right-[-10%] h-72 w-72 rounded-full bg-sky-200/25 blur-[150px]"></div>
    </div>

    <div class="relative w-full max-w-lg">
        <div class="rounded-[28px] border border-slate-200/70 bg-white/95 p-8 shadow-[0_28px_80px_-50px_rgba(15,23,42,0.45)] backdrop-blur-md md:p-10">
            <div class="flex flex-col items-center gap-6 text-center">
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
                    <h1 class="text-2xl font-semibold text-slate-900 md:text-[1.85rem]">{{ $title }}</h1>
                    <p class="text-sm text-slate-500">{{ $tagline }}</p>
                </div>
            </div>

            <div class="mt-8">
                {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

                <x-filament-panels::form id="form" wire:submit="authenticate" class="space-y-5 text-left">
                    {{ $this->form }}

                    <x-filament-panels::form.actions
                        :actions="$this->getCachedFormActions()"
                        :full-width="$this->hasFullWidthFormActions()"
                    />
                </x-filament-panels::form>

                {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
            </div>

            <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50/90 p-4 text-xs text-slate-500 sm:text-sm">
                <p class="font-medium text-slate-600">Butuh bantuan?</p>
                <p class="mt-1">Hubungi Finance Care Direktorat Keuangan Tel-U.</p>
                <div class="mt-3 flex flex-wrap items-center justify-center gap-3 font-medium text-slate-600">
                    <a href="mailto:{{ $email }}" class="hover:text-red-500">{{ $email }}</a>
                    <span class="hidden h-1 w-1 rounded-full bg-slate-300 sm:inline"></span>
                    <span>{{ $phone }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
