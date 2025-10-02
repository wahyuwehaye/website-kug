@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;
    use App\Models\SiteSetting;

    $setting = cache()->remember('filament_login_setting', now()->addMinutes(10), fn () => SiteSetting::query()->first());
    $title = $setting?->getTranslation('name', app()->getLocale()) ?? 'Direktorat Keuangan Telkom University';
    $tagline = $setting?->getTranslation('tagline', app()->getLocale()) ?? 'Layanan Keuangan Terintegrasi';
    $email = $setting?->email ?? 'finance@telkomuniversity.ac.id';
    $phone = $setting?->phone ?? '0811-2162-204';
@endphp

<div class="flex min-h-screen items-center justify-center bg-[#f8fafc] px-4 py-12 text-slate-800">
    <div class="w-full max-w-md space-y-8 rounded-3xl border border-slate-200/70 bg-white px-8 py-10 text-center">
        <div class="flex flex-col items-center gap-4">
            <img src="{{ asset('assets/images/logo-kug-panjang.png') }}" alt="Direktorat Keuangan" class="h-10">
            <img src="{{ asset('assets/images/Logo-Tel-U-glow.png') }}" alt="Telkom University" class="h-10">
        </div>
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ $title }}</h1>
            <p class="mt-2 text-sm text-slate-500">{{ $tagline }}</p>
        </div>

        {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

        <x-filament-panels::form id="form" wire:submit="authenticate" class="space-y-5 text-left">
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament-panels::form>

        {{ FilamentView::renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

        <div class="space-y-1 text-xs text-slate-500">
            <p class="font-medium text-slate-600">Finance Care</p>
            <p>{{ $email }} · {{ $phone }}</p>
            <p>Hubungi kami jika mengalami kendala akses.</p>
        </div>
    </div>
</div>

{{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
