@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;

    $statCards = [
        [
            'label' => 'Total Pengumuman',
            'value' => $summary['announcements'] ?? 0,
            'hint' => 'Termasuk agenda mendatang dan arsip.',
            'icon' => 'megaphone',
        ],
        [
            'label' => 'Berita Terpublikasi',
            'value' => $summary['news'] ?? 0,
            'hint' => 'Konten portal publik terbaru.',
            'icon' => 'presentation-chart-bar',
        ],
        [
            'label' => 'Dokumen Keuangan',
            'value' => $summary['documents'] ?? 0,
            'hint' => 'Laporan, pedoman, dan formulir.',
            'icon' => 'document-text',
        ],
        [
            'label' => 'Program Strategis',
            'value' => $summary['programs'] ?? 0,
            'hint' => 'Inisiatif prioritas tahun berjalan.',
            'icon' => 'chart-bar',
        ],
        [
            'label' => 'Layanan Operasional',
            'value' => $summary['services'] ?? 0,
            'hint' => 'Layanan digital & helpdesk.',
            'icon' => 'life-buoy',
        ],
        [
            'label' => 'FAQ & Kanal Kontak',
            'value' => ($summary['faqs'] ?? 0) + ($summary['channels'] ?? 0),
            'hint' => 'Basis pengetahuan & jalur komunikasi.',
            'icon' => 'sparkles',
        ],
    ];
@endphp

<x-filament-panels::page>
    {{ FilamentView::renderHook(PanelsRenderHook::PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <div class="space-y-8">
        <section class="relative overflow-hidden glass-card p-8">
            <div class="pointer-events-none absolute -right-10 top-10 h-48 w-48 rounded-full bg-amber-400/20 blur-[140px]"></div>
            <div class="pointer-events-none absolute -left-16 bottom-0 h-64 w-64 rounded-full bg-blue-500/10 blur-[160px]"></div>
            <div class="relative flex flex-col gap-10 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-amber-200">Dashboard</p>
                    <h1 class="text-3xl font-semibold text-white lg:text-4xl">{{ $this->getHeading() }}</h1>
                    <p class="max-w-2xl text-sm text-slate-200">{{ $this->getSubheading() }}</p>
                    <div class="flex flex-wrap gap-3 text-xs text-slate-300">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            {{ $summary['activeAnnouncements'] ?? 0 }} pengumuman aktif saat ini
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                            <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                            {{ $summary['news'] ?? 0 }} berita telah dipublikasikan
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                            <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                            {{ $summary['documents'] ?? 0 }} dokumen siap diunduh
                        </span>
                    </div>
                </div>
                <div class="glass-card z-10 w-full max-w-sm bg-white/10 p-6 text-slate-100">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-300">Akses Cepat</p>
                    <p class="mt-3 text-2xl font-semibold text-white">Optimalkan publikasi hari ini</p>
                    <p class="mt-2 text-xs text-slate-300">Mulai dari membuat pengumuman baru hingga mengunggah dokumen pengawasan.</p>
                    <div class="mt-6 grid gap-2">
                        <a href="{{ route('filament.admin.resources.announcements.create') }}" class="flex items-center justify-between rounded-2xl bg-amber-400/90 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-amber-300">
                            Buat Pengumuman
                            <span class="text-xs uppercase tracking-[0.3em]">Baru</span>
                        </a>
                        <a href="{{ route('filament.admin.resources.financial-documents.create') }}" class="flex items-center justify-between rounded-2xl border border-white/10 px-4 py-3 text-sm font-semibold text-amber-200 transition hover:border-amber-300/60 hover:text-white">
                            Unggah Dokumen
                            <span class="text-xs uppercase tracking-[0.3em]">PDF</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            @foreach ($statCards as $stat)
                <article class="glass-card bg-white/5 p-6">
                    <div class="flex items-start justify-between">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-300/10 text-amber-200">
                            <x-ui.icon :name="$stat['icon']" class="h-5 w-5" />
                        </span>
                        <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $now->translatedFormat('d M Y') }}</span>
                    </div>
                    <p class="mt-6 text-xs font-semibold uppercase tracking-[0.3em] text-slate-300">{{ $stat['label'] }}</p>
                    <p class="mt-3 text-3xl font-semibold text-white">{{ number_format($stat['value']) }}</p>
                    <p class="mt-2 text-xs text-slate-400">{{ $stat['hint'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="glass-card bg-white/5 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Pengumuman Terbaru</h3>
                        <p class="text-xs text-slate-300">Prioritaskan jadwal penting unit kerja.</p>
                    </div>
                    <a href="{{ route('filament.admin.resources.announcements.index') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-200">Kelola</a>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($latestAnnouncements as $announcement)
                        <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                            <p class="text-[11px] uppercase tracking-[0.3em] text-amber-200">{{ strtoupper($announcement->type) }}</p>
                            <p class="mt-2 text-sm font-semibold text-white">{{ $announcement->getTranslation('title', app()->getLocale()) }}</p>
                            <div class="mt-3 flex items-center justify-between text-xs text-slate-400">
                                <span>{{ $announcement->starts_at?->translatedFormat('d M Y') ?? 'TBA' }}</span>
                                @if ($announcement->status)
                                    <span class="inline-flex items-center gap-1 rounded-full border border-white/10 px-2 py-0.5 text-[10px] uppercase tracking-[0.3em] text-emerald-300">
                                        {{ strtoupper($announcement->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-300">Belum ada pengumuman yang dipublikasikan.</p>
                    @endforelse
                </div>
            </div>

            <div class="glass-card bg-white/5 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Aktivitas Berita</h3>
                        <p class="text-xs text-slate-300">Tinjau publikasi terakhir ke laman depan.</p>
                    </div>
                    <a href="{{ route('filament.admin.resources.news-posts.index') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-200">Kelola</a>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($latestNews as $news)
                        <div class="flex gap-3 rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                            <div class="mt-1 h-2 w-2 rounded-full bg-amber-300"></div>
                            <div class="grow">
                                <p class="text-sm font-semibold text-white">{{ $news->getTranslation('title', app()->getLocale()) }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $news->published_at?->translatedFormat('d M Y H:i') ?? 'Draft' }}</p>
                                <div class="mt-2 flex flex-wrap gap-2 text-[11px] uppercase tracking-[0.3em] text-slate-400">
                                    <span>{{ strtoupper($news->status) }}</span>
                                    @if ($news->category)
                                        <span>• {{ strtoupper($news->category->getTranslation('name', app()->getLocale())) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-300">Belum ada berita yang dipublikasikan.</p>
                    @endforelse
                </div>
            </div>

            <div class="glass-card bg-white/5 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Dokumen Rilis</h3>
                        <p class="text-xs text-slate-300">Kelola repositori arsip dan laporan resmi.</p>
                    </div>
                    <a href="{{ route('filament.admin.resources.financial-documents.index') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-200">Kelola</a>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($latestDocuments as $document)
                        <div class="rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                            <p class="text-sm font-semibold text-white">{{ $document->getTranslation('title', app()->getLocale()) }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $document->published_at?->translatedFormat('d M Y') ?? 'Belum ditentukan' }}</p>
                            <div class="mt-2 flex flex-wrap gap-2 text-[11px] uppercase tracking-[0.3em] text-slate-400">
                                <span>{{ strtoupper($document->category) }}</span>
                                <span>• {{ $document->document_number ?? 'Tanpa Nomor' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-300">Belum ada dokumen yang diunggah.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    {{ FilamentView::renderHook(PanelsRenderHook::PAGE_END, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page>
