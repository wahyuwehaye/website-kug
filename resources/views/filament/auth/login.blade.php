@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;
    use App\Models\SiteSetting;

    $setting = cache()->remember('filament_login_setting', now()->addMinutes(10), fn () => SiteSetting::query()->first());
    $title = $setting?->getTranslation('name', app()->getLocale()) ?? 'Direktorat Keuangan Telkom University';
    $tagline = $setting?->getTranslation('tagline', app()->getLocale()) ?? 'Layanan Keuangan Terintegrasi bagi Seluruh Sivitas';
    $email = $setting?->email ?? 'finance@telkomuniversity.ac.id';
    $phone = $setting?->phone ?? '0811-2162-204';
@endphp

<div class="relative flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_0%_0%,rgba(191,18,28,0.12),transparent_45%),_radial-gradient(circle_at_100%_0%,rgba(14,116,144,0.1),transparent_40%),_linear-gradient(135deg,#fef2f2,#f8fafc)] px-4 py-12 text-slate-800">
    <div class="relative mx-auto w-full max-w-3xl overflow-hidden rounded-[32px] border border-white/70 bg-white/90 shadow-[0_40px_120px_-60px_rgba(15,23,42,0.55)] backdrop-blur-lg">
        <div class="grid items-stretch gap-6 p-6 md:grid-cols-[1.1fr,0.9fr] md:p-10">
            <section class="flex flex-col gap-6">
                <div class="flex items-center gap-5">
                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-white shadow-inner ring-1 ring-red-100">
                        <img src="{{ asset('assets/images/logo-kug-panjang.png') }}" alt="Direktorat Keuangan" class="h-10 w-auto">
                    </span>
                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-white shadow-inner ring-1 ring-slate-100">
                        <img src="{{ asset('assets/images/Logo-Tel-U-glow.png') }}" alt="Telkom University" class="h-10 w-auto">
                    </span>
                </div>
                <div class="space-y-3">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.32em] text-red-500">Portal Administrator</p>
                    <h1 class="text-[2rem] font-semibold leading-tight text-slate-900">{{ $title }}</h1>
                    <p class="text-sm text-slate-500">{{ $tagline }}</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-white via-red-50/40 to-white p-5 text-sm text-slate-500 shadow-sm">
                    <p class="font-semibold text-slate-700">Panduan Singkat</p>
                    <ul class="mt-3 space-y-2 text-xs md:text-sm">
                        <li>• Gunakan email institusi Telkom University untuk autentikasi.</li>
                        <li>• Aktifkan opsi "Ingat saya" hanya pada perangkat yang tepercaya.</li>
                        <li>• Kontak Finance Care untuk reset akses atau bantuan konten.</li>
                    </ul>
                </div>
                <div class="flex flex-wrap items-center gap-3 rounded-3xl border border-slate-200 bg-slate-50/90 p-4 text-xs text-slate-500 md:text-sm">
                    <div class="flex-1">
                        <p class="font-semibold text-slate-700">Finance Care</p>
                        <p>{{ $email }}</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">{{ $phone }}</span>
                </div>
            </section>

            <section class="flex items-center">
                <div class="w-full rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_28px_80px_-60px_rgba(15,23,42,0.55)] md:p-8">
                    <div class="mb-6 space-y-2 text-center">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-red-500">Masuk</p>
                        <h2 class="text-xl font-semibold text-slate-900">Panel Direktorat Keuangan</h2>
                        <p class="text-xs text-slate-500">Masukkan kredensial SSO institusi untuk mengelola konten.</p>
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

                    <p class="mt-6 text-center text-xs text-slate-500">Dengan masuk, Anda menyetujui kebijakan keamanan Direktorat Keuangan.</p>
                </div>
            </section>
        </div>
    </div>
</div>

{{ FilamentView::renderHook(PanelsRenderHook::FOOTER, scopes: $this->getRenderHookScopes()) }}
