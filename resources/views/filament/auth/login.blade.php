@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;
    use App\Models\SiteSetting;

    $setting = cache()->remember('filament_login_setting', now()->addMinutes(10), fn () => SiteSetting::query()->first());
    $title = $setting?->getTranslation('name', app()->getLocale()) ?? 'Direktorat Keuangan Telkom University';
    $tagline = $setting?->getTranslation('tagline', app()->getLocale()) ?? 'Layanan keuangan terintegrasi bagi seluruh sivitas.';
    $email = $setting?->email ?? 'finance@telkomuniversity.ac.id';
    $phone = $setting?->phone ?? '0811-2162-204';
@endphp

<div class="flex min-h-screen items-center justify-center bg-white text-slate-800">
    <div class="flex h-[640px] w-full max-w-5xl overflow-hidden rounded-[32px] border border-slate-200 shadow-[0_25px_70px_-40px_rgba(15,23,42,0.4)]">
        <div class="hidden h-full w-2/5 bg-cover bg-center bg-no-repeat md:block" style="background-image: linear-gradient(160deg, rgba(191,18,28,0.85), rgba(191,18,28,0.6)), url('{{ asset('assets/images/telu1.webp') }}');"></div>
        <div class="flex h-full w-full flex-1 flex-col items-center justify-center gap-6 px-8 text-center md:w-3/5 md:px-16">
            <div class="flex flex-col items-center gap-4">
                <img src="{{ asset('assets/images/logo-kug-panjang.png') }}" alt="Direktorat Keuangan" class="h-12">
                <div class="space-y-1">
                    <h1 class="text-2xl font-semibold text-slate-900">Welcome Back!</h1>
                    <p class="text-sm text-slate-500">Masuk ke portal Direktorat Keuangan Telkom University.</p>
                </div>
            </div>

            {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

            <x-filament-panels::form id="form" wire:submit="authenticate" class="w-full max-w-sm space-y-5 text-left">
                {{ $this->form }}

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="true"
                />
            </x-filament-panels::form>

            {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

            <div class="space-y-1 text-xs text-slate-500">
                <p>Finance Care — {{ $email }} · {{ $phone }}</p>
                <p>© {{ now()->year }} Direktorat Keuangan Telkom University.</p>
            </div>
        </div>
    </div>
</div>

{{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
