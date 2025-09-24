@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;

    $statCards = [
        [
            'label' => 'Total Pengumuman',
            'value' => $summary['announcements'] ?? 0,
            'hint' => 'Agenda mendatang & arsip kebijakan.',
            'icon' => 'megaphone',
        ],
        [
            'label' => 'Berita Terbit',
            'value' => $summary['news'] ?? 0,
            'hint' => 'Publikasi terbaru di landing page.',
            'icon' => 'presentation-chart-bar',
        ],
        [
            'label' => 'Dokumen Aktif',
            'value' => $summary['documents'] ?? 0,
            'hint' => 'Laporan keuangan & SOP terkini.',
            'icon' => 'document-text',
        ],
        [
            'label' => 'Program Strategis',
            'value' => $summary['programs'] ?? 0,
            'hint' => 'Inisiatif prioritas Direktorat.',
            'icon' => 'chart-bar',
        ],
        [
            'label' => 'Layanan Operasional',
            'value' => $summary['services'] ?? 0,
            'hint' => 'Helpdesk & layanan pendukung unit.',
            'icon' => 'life-buoy',
        ],
        [
            'label' => 'FAQ & Kanal Kontak',
            'value' => ($summary['faqs'] ?? 0) + ($summary['channels'] ?? 0),
            'hint' => 'Basis pengetahuan & jalur komunikasi.',
            'icon' => 'sparkles',
        ],
    ];

    $quickActions = [
        [
            'label' => 'Pengumuman Baru',
            'description' => 'Sampaikan jadwal penting ke seluruh unit.',
            'url' => route('filament.admin.resources.announcements.create'),
            'icon' => 'megaphone',
        ],
        [
            'label' => 'Berita & Artikel',
            'description' => 'Perbarui informasi publik di landing page.',
            'url' => route('filament.admin.resources.news-posts.create'),
            'icon' => 'presentation-chart-bar',
        ],
        [
            'label' => 'Unggah Dokumen',
            'description' => 'Tambahkan laporan audit atau pedoman baru.',
            'url' => route('filament.admin.resources.financial-documents.create'),
            'icon' => 'document-text',
        ],
    ];

    $statCards = array_values($statCards);
@endphp

<x-filament-panels::page>
    {{ FilamentView::renderHook(PanelsRenderHook::PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <div class="space-y-8">
        <section class="relative overflow-hidden rounded-[32px] border border-white/10 bg-white/10 p-8 shadow-[0_20px_60px_-25px_rgba(15,23,42,0.9)] backdrop-blur-xl">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -left-24 top-10 h-72 w-72 rounded-full bg-amber-400/30 blur-[120px]"></div>
                <div class="absolute right-0 top-1/3 h-80 w-80 rounded-full bg-sky-500/30 blur-[150px]"></div>
                <div class="absolute -bottom-20 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-rose-500/20 blur-[140px]"></div>
            </div>
            <div class="relative grid gap-10 lg:grid-cols-[1.6fr,1fr]">
                <div class="space-y-6">
                    <div class="flex flex-wrap items-center gap-4 text-xs uppercase tracking-[0.4em] text-amber-200">
                        <span class="inline-flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            Dashboard Direktorat Keuangan
                        </span>
                        <span class="hidden h-1 w-1 rounded-full bg-amber-200/60 md:inline"></span>
                        <span class="text-amber-100/70">{{ $now->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="space-y-3">
                        <h1 class="text-3xl font-semibold text-white lg:text-[2.6rem] lg:leading-[1.1]">{{ $this->getHeading() }}</h1>
                        <p class="max-w-2xl text-sm text-slate-200 lg:text-base">
                            {{ $this->getSubheading() }} Pantau publikasi, dokumen, dan program strategis dengan antarmuka konsisten yang mendukung koordinasi lintas unit secara realtime.
                        </p>
                    </div>
                    <dl class="grid gap-4 md:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-slate-100">
                            <p class="text-[11px] uppercase tracking-[0.3em] text-slate-300">Pengumuman Aktif</p>
                            <p class="mt-2 text-2xl font-semibold text-white">{{ number_format($summary['activeAnnouncements'] ?? 0) }}</p>
                            <p class="mt-1 text-xs text-slate-300">Sedang tayang untuk sivitas & unit kerja.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-slate-100">
                            <p class="text-[11px] uppercase tracking-[0.3em] text-slate-300">Berita Terakhir</p>
                            <p class="mt-2 text-2xl font-semibold text-white">{{ number_format($summary['news'] ?? 0) }}</p>
                            <p class="mt-1 text-xs text-slate-300">Publikasi yang tampil di laman utama.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-slate-100">
                            <p class="text-[11px] uppercase tracking-[0.3em] text-slate-300">Dokumen Siap Unduh</p>
                            <p class="mt-2 text-2xl font-semibold text-white">{{ number_format($summary['documents'] ?? 0) }}</p>
                            <p class="mt-1 text-xs text-slate-300">Audit, pedoman, dan formulir terbaru.</p>
                        </div>
                    </dl>
                </div>
                <div class="space-y-5 rounded-[26px] border border-white/10 bg-slate-950/60 p-6 text-slate-100 shadow-inner shadow-black/30">
                    <div class="flex items-center justify-between">
                        <p class="text-xs uppercase tracking-[0.3em] text-amber-200">Akses Super Cepat</p>
                        <span class="rounded-full border border-white/10 px-3 py-1 text-[11px] uppercase tracking-[0.3em] text-slate-300">Workflow</span>
                    </div>
                    <div class="space-y-3">
                        @foreach ($quickActions as $action)
                            <a href="{{ $action['url'] }}" class="dashboard-quick-action">
                                <span>
                                    <span class="block text-sm font-semibold text-white">{{ $action['label'] }}</span>
                                    <span class="block text-xs text-slate-300">{{ $action['description'] }}</span>
                                </span>
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-amber-300/15 text-amber-200">
                                    <x-ui.icon :name="$action['icon']" class="h-5 w-5" />
                                </span>
                            </a>
                        @endforeach
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-xs text-slate-200">
                        <p class="font-semibold text-white">Status Sistem</p>
                        <p class="mt-1 flex items-center gap-2 text-[11px] uppercase tracking-[0.3em] text-emerald-300">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                            Seluruh layanan panel berjalan normal.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($statCards as $stat)
                <article class="dashboard-stat-card">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-amber-300/15 text-amber-200">
                            <x-ui.icon :name="$stat['icon']" class="h-5 w-5" />
                        </span>
                        <span class="text-xs uppercase tracking-[0.3em] text-slate-300">{{ $now->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="mt-6 space-y-2">
                        <p class="text-[11px] uppercase tracking-[0.3em] text-slate-300">{{ $stat['label'] }}</p>
                        <p class="text-3xl font-semibold text-white">{{ number_format($stat['value']) }}</p>
                        <p class="text-xs text-slate-400">{{ $stat['hint'] }}</p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.8fr,1fr]">
            <div class="rounded-[28px] border border-white/10 bg-white/10 p-6 text-slate-100 shadow-[0_25px_60px_-30px_rgba(15,23,42,0.9)] backdrop-blur-xl">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Linimasa Aktivitas</h3>
                        <p class="text-xs text-slate-300">Pantau setiap update penting sebelum tayang.</p>
                    </div>
                    <a href="{{ route('filament.admin.resources.announcements.index') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-200">Kelola Konten</a>
                </div>
                <ul class="dashboard-timeline mt-6">
                    @forelse ($latestAnnouncements as $announcement)
                        <li class="rounded-2xl border border-white/10 bg-slate-950/50 p-4 shadow-inner shadow-black/30">
                            <div class="flex flex-wrap items-center justify-between gap-2 text-xs uppercase tracking-[0.3em]">
                                <span class="text-amber-200">{{ strtoupper($announcement->type) }}</span>
                                <span class="text-slate-400">{{ $announcement->starts_at?->translatedFormat('d M Y') ?? 'TBA' }}</span>
                            </div>
                            <p class="mt-2 text-sm font-semibold text-white">{{ $announcement->getTranslation('title', app()->getLocale()) }}</p>
                            <p class="mt-1 text-xs text-slate-400">{!! \Illuminate\Support\Str::limit(strip_tags($announcement->getTranslation('body', app()->getLocale())), 140) !!}</p>
                            <div class="mt-3 flex flex-wrap gap-2 text-[11px] uppercase tracking-[0.3em] text-emerald-300">
                                <span>Status: {{ strtoupper($announcement->status ?? 'draft') }}</span>
                                @if ($announcement->ends_at)
                                    <span>• Hingga {{ $announcement->ends_at->translatedFormat('d M Y') }}</span>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="rounded-2xl border border-white/10 bg-slate-950/50 p-4 text-sm text-slate-300">Belum ada pengumuman yang dipublikasikan.</li>
                    @endforelse

                    @forelse ($latestNews as $news)
                        <li class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                            <div class="flex flex-wrap items-center justify-between gap-2 text-xs uppercase tracking-[0.3em] text-slate-400">
                                <span>Berita</span>
                                <span>{{ $news->published_at?->translatedFormat('d M Y H:i') ?? 'Draft' }}</span>
                            </div>
                            <p class="mt-2 text-sm font-semibold text-white">{{ $news->getTranslation('title', app()->getLocale()) }}</p>
                            <div class="mt-2 flex flex-wrap gap-3 text-[11px] uppercase tracking-[0.3em] text-slate-400">
                                <span>Status: {{ strtoupper($news->status) }}</span>
                                @if ($news->category)
                                    <span>Kategori: {{ strtoupper($news->category->getTranslation('name', app()->getLocale())) }}</span>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="rounded-2xl border border-white/10 bg-slate-950/40 p-4 text-sm text-slate-300">Belum ada berita yang dipublikasikan.</li>
                    @endforelse
                </ul>
            </div>
            <div class="space-y-6">
                <div class="rounded-[26px] border border-white/10 bg-slate-950/60 p-6 shadow-inner shadow-black/40">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-white">Dokumen Rilis</h3>
                            <p class="text-xs text-slate-300">Repositori laporan dan pedoman terbaru.</p>
                        </div>
                        <a href="{{ route('filament.admin.resources.financial-documents.index') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-200">Lihat Semua</a>
                    </div>
                    <div class="mt-5 space-y-3 text-sm text-slate-200">
                        @forelse ($latestDocuments as $document)
                            <a href="{{ route('filament.admin.resources.financial-documents.edit', $document) }}" class="flex flex-col gap-1 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-left transition hover:border-amber-300/40 hover:bg-amber-300/10">
                                <span class="font-semibold text-white">{{ $document->getTranslation('title', app()->getLocale()) }}</span>
                                <span class="text-xs text-slate-300">{{ $document->published_at?->translatedFormat('d M Y') ?? 'Belum ditentukan' }} • {{ strtoupper($document->category) }}</span>
                            </a>
                        @empty
                            <p class="text-xs text-slate-300">Belum ada dokumen yang diunggah.</p>
                        @endforelse
                    </div>
                </div>
                <div class="rounded-[26px] border border-white/10 bg-white/10 p-6 text-xs text-slate-200 backdrop-blur-xl">
                    <p class="text-[11px] uppercase tracking-[0.3em] text-amber-200">Catatan Operasional</p>
                    <p class="mt-3 text-sm font-semibold text-white">Gunakan panel ini sebagai pusat koordinasi</p>
                    <ul class="mt-4 space-y-2 text-slate-300">
                        <li>• Pastikan konten bilingual agar konsisten dengan standar universitas.</li>
                        <li>• Tandai dokumen penting sebagai <em>featured</em> supaya menonjol di landing page.</li>
                        <li>• Manfaatkan FAQ dan kanal kontak untuk mereduksi tiket berulang dari unit kerja.</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>

    {{ FilamentView::renderHook(PanelsRenderHook::PAGE_END, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page>
