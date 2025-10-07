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

<div class="login-shell">
    <div class="login-card">
        <div class="login-illustration"></div>
        <div class="login-panel">
            <div class="login-header">
                <img src="{{ asset('assets/images/logo-kug-panjang.png') }}" alt="Direktorat Keuangan" class="h-12">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">Welcome Back!</h1>
                    <p class="text-sm text-slate-500">Masuk ke portal Direktorat Keuangan Telkom University.</p>
                </div>
            </div>

            {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

            <x-filament-panels::form id="form" wire:submit="authenticate" class="login-form">
                {{ $this->form }}

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="true"
                />
            </x-filament-panels::form>

            {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

            <div class="login-footer">
                <p>Finance Care — {{ $email }} · {{ $phone }}</p>
                <p>© {{ now()->year }} Direktorat Keuangan Telkom University.</p>
            </div>
        </div>
    </div>
</div>

{{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
