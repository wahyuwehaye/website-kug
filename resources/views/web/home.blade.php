@extends('layouts.web')

@php
    use Illuminate\Support\Str;
    $title = trans('web.site_title');
@endphp

@section('content')
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 hero-grid"></div>
        <div class="section-shell relative z-10">
            <div class="grid gap-10 lg:grid-cols-[1.6fr,1fr] lg:items-center">
                <div class="space-y-8">
                    <span class="pill-muted">Finance Directorate</span>
                    <div class="space-y-4">
                        <h2 class="text-3xl font-semibold leading-tight text-white md:text-4xl">
                            {{ $siteSetting?->getTranslation('tagline', $activeLocale) ?? 'Transparansi dan Keunggulan Tata Kelola Keuangan Telkom University' }}
                        </h2>
                        <p class="max-w-2xl text-sm text-slate-200 md:text-base">
                            {{ $siteSetting?->getTranslation('short_description', $activeLocale) ?? Str::limit(strip_tags($siteSetting?->getTranslation('about', $activeLocale)), 220) }}
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-amber-300">
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                            {{ trans('web.program_and_services') }}
                        </a>
                        @if($siteSetting?->sso_login_url)
                            <a href="{{ $siteSetting->sso_login_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:border-white hover:bg-white/10">
                                <x-ui.icon name="link" class="h-4 w-4" />
                                SSO Operator
                            </a>
                        @endif
                    </div>
                    <dl class="grid gap-4 sm:grid-cols-3">
                        <div class="glass-tile hover-raise p-5">
                            <dt class="text-[11px] uppercase tracking-[0.35em] text-slate-300">{{ trans('web.announcements') }}</dt>
                            <dd class="mt-2 flex items-center gap-2 text-3xl font-semibold text-white">
                                <x-ui.icon name="megaphone" class="h-6 w-6 text-amber-200" />
                                {{ $announcements->count() }}
                            </dd>
                            <p class="mt-2 text-xs text-slate-400">{{ __('Siaran kebijakan terbaru untuk sivitas dan unit kerja.') }}</p>
                        </div>
                        <div class="glass-tile hover-raise p-5">
                            <dt class="text-[11px] uppercase tracking-[0.35em] text-slate-300">{{ trans('web.documents') }}</dt>
                            <dd class="mt-2 flex items-center gap-2 text-3xl font-semibold text-white">
                                <x-ui.icon name="document-text" class="h-6 w-6 text-amber-200" />
                                {{ $highlightDocuments->count() }}
                            </dd>
                            <p class="mt-2 text-xs text-slate-400">{{ __('Laporan audit, pedoman, dan arsip digital siap unduh.') }}</p>
                        </div>
                        <div class="glass-tile hover-raise p-5">
                            <dt class="text-[11px] uppercase tracking-[0.35em] text-slate-300">{{ trans('web.programs.title') }}</dt>
                            <dd class="mt-2 flex items-center gap-2 text-3xl font-semibold text-white">
                                <x-ui.icon name="chart-bar" class="h-6 w-6 text-amber-200" />
                                {{ $featuredPrograms->count() + $services->count() }}
                            </dd>
                            <p class="mt-2 text-xs text-slate-400">{{ __('Program strategis serta layanan operasional unggulan.') }}</p>
                        </div>
                    </dl>
                </div>
                <div class="glass-panel space-y-5 p-6">
                    <div class="flex items-center justify-between text-xs uppercase tracking-[0.35em] text-amber-200">
                        <span>{{ __('Highlight Direktorat') }}</span>
                        <span class="text-slate-300">{{ now()->translatedFormat('d M Y') }}</span>
                    </div>
                    @if($heroSlides->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($heroSlides as $slide)
                                <article class="glass-tile hover-raise border-white/10 bg-white/5 p-4">
                                    <p class="text-[11px] uppercase tracking-[0.35em] text-slate-300">{{ $slide->label ?? 'Program Insight' }}</p>
                                    <h3 class="mt-2 text-lg font-semibold text-white">{{ $slide->getTranslation('title', $activeLocale) }}</h3>
                                    <p class="mt-2 text-sm text-slate-200">{{ $slide->getTranslation('description', $activeLocale) }}</p>
                                    <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-300">
                                        @if($slide->cta_url)
                                            <a href="{{ $slide->cta_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-amber-400/20 px-3 py-1 text-amber-100 hover:bg-amber-400/30">
                                                {{ $slide->getTranslation('cta_label', $activeLocale) ?? trans('web.read_more') }}
                                            </a>
                                        @endif
                                        @if($slide->media_type === 'video' && $slide->video_url)
                                            <span class="rounded-full bg-white/10 px-3 py-1 text-xs uppercase tracking-[0.3em] text-slate-300">Video</span>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-300">{{ __('Isi slider melalui panel admin untuk menampilkan highlight terbaru.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if($announcements->isNotEmpty())
        <section class="section-shell">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="pill-muted">{{ trans('web.announcements') }}</p>
                    <h2 class="mt-4 text-2xl font-semibold text-white">{{ __('Pengumuman & Agenda Keuangan') }}</h2>
                    <p class="section-subtitle">{{ __('Prioritaskan deadline SPJ, penutupan buku, dan update layanan terbaru.') }}</p>
                </div>
                <a href="{{ route('news.index', ['locale' => $activeLocale, 'category' => 'pengumuman']) }}" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-white hover:text-white">
                    {{ trans('web.view_all') }}
                    <x-ui.icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach($announcements as $announcement)
                    <article class="glass-panel hover-raise space-y-4 p-6">
                        <span class="badge-primary">
                            <x-ui.icon name="megaphone" class="h-4 w-4" />
                            {{ Str::upper($announcement->type) }}
                        </span>
                        <h3 class="text-lg font-semibold text-white">{{ $announcement->getTranslation('title', $activeLocale) }}</h3>
                        <p class="text-sm text-slate-200">{{ Str::limit(strip_tags($announcement->getTranslation('body', $activeLocale)), 180) }}</p>
                        <div class="text-xs text-slate-400">
                            {{ $announcement->starts_at?->translatedFormat('d F Y') }}
                            @if($announcement->ends_at)
                                • {{ __('s.d') }} {{ $announcement->ends_at->translatedFormat('d F Y') }}
                            @endif
                        </div>
                        @if($announcement->cta_url)
                            <a href="{{ $announcement->cta_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-semibold text-amber-200 transition hover:text-amber-100">
                                {{ $announcement->getTranslation('cta_label', $activeLocale) ?? trans('web.read_more') }}
                                <x-ui.icon name="arrow-right" class="h-4 w-4" />
                            </a>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="section-shell">
        <div class="glass-panel p-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="pill-muted">{{ trans('web.program_and_services') }}</p>
                    <h2 class="mt-4 text-2xl font-semibold text-white">{{ __('Program Strategis & Layanan Utama') }}</h2>
                    <p class="section-subtitle">{{ __('Mengawal transformasi keuangan digital, layanan operasional, dan tata kelola yang akuntabel.') }}</p>
                </div>
                <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-white hover:text-white">
                    {{ trans('web.view_all') }}
                    <x-ui.icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach($featuredPrograms as $program)
                    @php
                        $programIcon = $program->icon
                            ? Str::of($program->icon)->replace('heroicon-o-', '')->replace('heroicon-s-', '')->value()
                            : null;
                    @endphp
                    <article class="glass-tile hover-raise flex h-full flex-col gap-4 p-6">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-400/20 text-amber-200">
                            @if($programIcon)
                                <x-ui.icon :name="$programIcon" class="h-6 w-6" />
                            @else
                                <span class="text-sm font-semibold">{{ strtoupper(Str::limit($program->getTranslation('name', $activeLocale), 2, '')) }}</span>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-300">{{ trans('web.program_types.' . $program->type) }}</p>
                            <h3 class="text-lg font-semibold text-white">{{ $program->getTranslation('name', $activeLocale) }}</h3>
                            <p class="text-sm text-slate-300">{{ $program->getTranslation('summary', $activeLocale) }}</p>
                        </div>
                        <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $program]) }}" class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-amber-200 transition hover:text-amber-100">
                            {{ trans('web.read_more') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </article>
                @endforeach
            </div>

            @if($services->isNotEmpty())
                <div class="gradient-divider mt-12"></div>
                <div class="mt-10 grid gap-4 md:grid-cols-3">
                    @foreach($services as $service)
                        @php
                            $serviceIcon = $service->icon
                                ? Str::of($service->icon)->replace('heroicon-o-', '')->replace('heroicon-s-', '')->value()
                                : null;
                        @endphp
                        <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $service]) }}" class="glass-tile hover-raise flex items-start gap-3 p-4 text-sm">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-amber-200">
                                @if($serviceIcon)
                                    <x-ui.icon :name="$serviceIcon" class="h-5 w-5" />
                                @else
                                    <span class="text-xs font-semibold">{{ strtoupper(Str::limit($service->getTranslation('name', $activeLocale), 2, '')) }}</span>
                                @endif
                            </span>
                            <span class="space-y-1">
                                <span class="block font-semibold text-white">{{ $service->getTranslation('name', $activeLocale) }}</span>
                                <span class="block text-xs text-slate-300">{{ $service->getTranslation('summary', $activeLocale) }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="section-shell">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="pill-muted">{{ trans('web.documents') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-white">{{ __('Repositori Dokumen Keuangan') }}</h2>
                <p class="section-subtitle">{{ __('Akses laporan audit, RBA, pedoman, dan formulir resmi Direktorat Keuangan.') }}</p>
            </div>
            <a href="{{ route('documents.index', ['locale' => $activeLocale]) }}" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-white hover:text-white">
                {{ trans('web.view_all') }}
                <x-ui.icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($highlightDocuments as $document)
                <article class="glass-panel hover-raise space-y-3 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-amber-200">{{ trans('web.document_categories.' . $document->category) }}</p>
                    <h3 class="text-base font-semibold text-white">{{ $document->getTranslation('title', $activeLocale) }}</h3>
                    <p class="text-sm text-slate-300">{{ $document->getTranslation('description', $activeLocale) }}</p>
                    <div class="text-xs text-slate-400">{{ $document->published_at?->translatedFormat('d F Y') ?? $document->year }}</div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        @if($document->file_path)
                            <a href="{{ route('documents.download', ['locale' => $activeLocale, 'document' => $document]) }}" class="inline-flex items-center gap-2 rounded-full bg-amber-400/20 px-3 py-1 text-amber-100 hover:bg-amber-400/30">
                                {{ trans('web.documents_list.download') }}
                            </a>
                        @endif
                        @if($document->external_url)
                            <a href="{{ $document->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-3 py-1 text-slate-200 hover:border-white">
                                {{ trans('web.documents_list.external') }}
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-shell">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="pill-muted">{{ trans('web.latest_news') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-white">{{ __('Sorotan Berita & Publikasi') }}</h2>
                <p class="section-subtitle">{{ __('Update terbaru tentang inisiatif keuangan, transformasi digital, dan layanan stakeholder.') }}</p>
            </div>
            <a href="{{ route('news.index', ['locale' => $activeLocale]) }}" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-white hover:text-white">
                {{ trans('web.view_all') }}
                <x-ui.icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @forelse($latestNews as $post)
                <article class="glass-panel hover-raise overflow-hidden">
                    @if($post->cover_image_path)
                        <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="h-44 w-full object-cover" />
                    @endif
                    <div class="space-y-3 p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-amber-200">
                            {{ $post->category?->getTranslation('name', $activeLocale) ?? trans('web.news.title') }}
                        </p>
                        <h3 class="text-lg font-semibold text-white">{{ $post->getTranslation('title', $activeLocale) }}</h3>
                        <p class="text-sm text-slate-300">{{ $post->getTranslation('excerpt', $activeLocale) }}</p>
                        <div class="text-xs text-slate-400">{{ $post->published_at?->translatedFormat('d F Y') }}</div>
                        <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $post]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-amber-200 transition hover:text-amber-100">
                            {{ trans('web.read_more') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">{{ trans('web.news.empty') }}</p>
            @endforelse
        </div>
    </section>

    <section class="section-shell grid gap-8 lg:grid-cols-[1.1fr,0.9fr]">
        <div class="glass-panel p-8">
            <p class="pill-muted">{{ trans('web.faqs') }}</p>
            <h2 class="mt-4 text-2xl font-semibold text-white">{{ __('Pertanyaan yang Sering Diajukan') }}</h2>
            <p class="section-subtitle">{{ __('Panduan singkat mengenai kebijakan keuangan, layanan pembayaran, serta dukungan operasional.') }}</p>
            <div class="mt-6 space-y-4">
                @foreach($faqs as $faq)
                    <details class="group rounded-2xl border border-white/10 bg-white/5 p-4">
                        <summary class="flex cursor-pointer items-center justify-between text-sm font-semibold text-white">
                            <span>{{ $faq->getTranslation('question', $activeLocale) }}</span>
                            <svg class="h-5 w-5 text-amber-200 transition group-open:rotate-45" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a.75.75 0 01.75.75v3.5h3.5a.75.75 0 010 1.5h-3.5v3.5a.75.75 0 01-1.5 0v-3.5h-3.5a.75.75 0 010-1.5h3.5v-3.5A.75.75 0 0110 5z" clip-rule="evenodd" />
                            </svg>
                        </summary>
                        <p class="mt-3 text-sm text-slate-300">{!! $faq->getTranslation('answer', $activeLocale) !!}</p>
                    </details>
                @endforeach
            </div>
        </div>
        <div class="glass-panel space-y-6 p-8">
            <div>
                <p class="pill-muted">{{ trans('web.contact_us') }}</p>
                <h2 class="mt-4 text-2xl font-semibold text-white">{{ __('Hubungi Direktorat Keuangan') }}</h2>
                <p class="section-subtitle">{{ __('Tim kami siap mendampingi kebutuhan layanan keuangan, administrasi anggaran, hingga dukungan kebijakan.') }}</p>
            </div>
            <div class="space-y-3 text-sm">
                @foreach($contactChannels as $channel)
                    <div class="glass-tile border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.35em] text-amber-200">{{ $channel->type }}</p>
                        <p class="mt-1 text-base font-semibold text-white">{{ $channel->getTranslation('name', $activeLocale) }}</p>
                        <p class="mt-1 text-slate-300">{{ $channel->value }}</p>
                        @if($channel->getTranslation('notes', $activeLocale))
                            <p class="mt-1 text-xs text-slate-400">{{ $channel->getTranslation('notes', $activeLocale) }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            @if($siteSetting?->map_embed)
                <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5 shadow-inner shadow-black/40">
                    <div class="aspect-[4/3] md:aspect-[16/9]">
                        {!! $siteSetting->map_embed !!}
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
