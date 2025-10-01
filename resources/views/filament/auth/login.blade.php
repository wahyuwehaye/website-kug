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

<div class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-[#fee2e2] via-white to-[#e2f3ff] px-4 py-10 text-slate-800">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-24 top-6 h-72 w-72 rounded-full bg-red-200/25 blur-[140px]"></div>
        <div class="absolute bottom-[-10%] right-[-12%] h-80 w-80 rounded-full bg-sky-200/25 blur-[160px]"></div>
    </div>

    <div class="relative w-full max-w-2xl">
        <div class="rounded-[32px] border border-white/70 bg-white/95 p-10 shadow-[0_38px_120px_-60px_rgba(15,23,42,0.4)] backdrop-blur-md">
            <div class="flex flex-col items-center gap-6 text-center">
                <div class="flex items-center gap-5">
                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-white shadow-inner ring-1 ring-red-100">
                        <img src="{{ asset('assets/images/kug.png') }}" alt="Direktorat Keuangan" class="h-12 w-12 object-contain">
                    </span>
                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-white shadow-inner ring-1 ring-slate-100">
                        <img src="{{ asset('assets/images/Logo-Tel-U-glow.png') }}" alt="Telkom University" class="h-12 w-12 object-contain">
                    </span>
                </div>
                <div class="space-y-3">
                    <span class="text-[11px] font-semibold uppercase tracking-[0.32em] text-red-500">Portal Administrator</span>
                    <h1 class="text-[2.1rem] font-semibold leading-tight text-slate-900">{{ $title }}</h1>
                    <p class="text-base text-slate-500">{{ $tagline }}</p>
                </div>
            </div>

            <div class="mt-10">
                {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

                <x-filament-panels::form id="form" wire:submit="authenticate" class="space-y-6">
                    {{ $this->form }}

                    <x-filament-panels::form.actions
                        :actions="$this->getCachedFormActions()"
                        :full-width="$this->hasFullWidthFormActions()"
                    />
                </x-filament-panels::form>

                {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
            </div>

            <div class="mt-10 rounded-3xl border border-slate-200 bg-slate-50/90 p-5 text-sm text-slate-500">
                <p class="font-semibold text-slate-700">Bantuan Finance Care</p>
                <p class="mt-1 text-xs text-slate-500">Tim siap mendampingi pada jam kerja.</p>
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
