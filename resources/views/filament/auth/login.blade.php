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

<div class="ssr-login">
    <div class="ssr-banner"></div>
    <div class="ssr-panel">
        <div class="ssr-panel-inner">
            <div class="ssr-header">
                <img src="{{ asset('assets/images/kug.png') }}" alt="KUG" class="ssr-logo">
                <h1 class="ssr-title">Welcome Back!</h1>
                <p class="ssr-subtitle">Sign in to continue to Direktorat Keuangan Telkom University.</p>
            </div>

            {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

            <x-filament-panels::form id="form" wire:submit="authenticate" class="ssr-form">
                {{ $this->form }}

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="true"
                />
            </x-filament-panels::form>

            {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

            <div class="ssr-footer">
                <p>Finance Care — {{ $email }} · {{ $phone }}</p>
                <p>© {{ now()->year }} Direktorat Keuangan Telkom University.</p>
            </div>
        </div>
    </div>
</div>

{{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
