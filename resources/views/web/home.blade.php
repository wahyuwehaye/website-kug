@extends('layouts.web')

@php
    use Illuminate\Support\Str;

    $title = trans('web.site_title');

    $resolveAsset = static function (?string $path) {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return url(ltrim($path, '/'));
        }

        if (Str::startsWith($path, 'assets/')) {
            return asset($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $heroFallbackImage = asset('assets/images/telu1.webp');
@endphp

@section('content')
    <section class="section-block pt-16">
        <div class="hero-shell grid gap-10 p-10 lg:grid-cols-[1.15fr,0.85fr]">
            <div class="space-y-8">
                <div class="space-y-4">
                    <span class="pill-muted">Telkom University Finance Directorate</span>
                    <h2 class="text-3xl font-semibold leading-tight text-slate-900 md:text-[2.5rem]">
                        {{ $siteSetting?->getTranslation('tagline', $activeLocale) ?? 'Transparansi Tata Kelola Keuangan Telkom University' }}
                    </h2>
                    <p class="max-w-2xl text-base text-slate-600 md:text-lg">
                        {{ $siteSetting?->getTranslation('short_description', $activeLocale) ?? Str::limit(strip_tags($siteSetting?->getTranslation('about', $activeLocale)), 220) }}
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="btn-primary">
                        <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        {{ trans('web.program_and_services') }}
                    </a>
                    <a href="{{ route('documents.index', ['locale' => $activeLocale]) }}" class="btn-outline">
                        <x-ui.icon name="document-text" class="h-4 w-4" />
                        {{ trans('web.documents') }}
                    </a>
                    @if($siteSetting?->sso_login_url)
                        <a href="{{ $siteSetting->sso_login_url }}" target="_blank" rel="noopener" class="btn-outline">
                            <x-ui.icon name="link" class="h-4 w-4" /> SSO Operator
                        </a>
                    @endif
                </div>
                <dl class="grid gap-5 sm:grid-cols-3">
                    <div class="card-soft p-6">
                        <dt class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">{{ trans('web.announcements') }}</dt>
                        <dd class="mt-3 flex items-center gap-3 text-3xl font-semibold text-slate-900">
                            <x-ui.icon name="megaphone" class="h-6 w-6 text-red-600" />
                            {{ $announcements->count() }}
                        </dd>
                        <p class="mt-2 text-xs text-slate-500">{{ __('Informasi kebijakan dan agenda layanan terkini.') }}</p>
                    </div>
                    <div class="card-soft p-6">
                        <dt class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">{{ trans('web.documents') }}</dt>
                        <dd class="mt-3 flex items-center gap-3 text-3xl font-semibold text-slate-900">
                            <x-ui.icon name="document-text" class="h-6 w-6 text-red-600" />
                            {{ $highlightDocuments->count() }}
                        </dd>
                        <p class="mt-2 text-xs text-slate-500">{{ __('Dokumen keuangan resmi siap diakses publik.') }}</p>
                    </div>
                    <div class="card-soft p-6">
                        <dt class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">{{ trans('web.programs.title') }}</dt>
                        <dd class="mt-3 flex items-center gap-3 text-3xl font-semibold text-slate-900">
                            <x-ui.icon name="chart-bar" class="h-6 w-6 text-red-600" />
                            {{ $featuredPrograms->count() + $services->count() }}
                        </dd>
                        <p class="mt-2 text-xs text-slate-500">{{ __('Program prioritas dan layanan operasional keuangan.') }}</p>
                    </div>
                </dl>
            </div>

            <div class="space-y-6">
                <div class="hero-carousel" data-carousel>
                    <div class="hero-progress" data-carousel-progress>
                        <div class="hero-progress-bar"></div>
                    </div>
                    <div class="hero-carousel__slides">
                        @foreach($heroSlides as $index => $slide)
                            <article class="hero-slide {{ $loop->first ? 'is-active' : '' }}" data-carousel-slide>
                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">
                                            {{ $slide->getTranslation('subtitle', $activeLocale) }}
                                        </p>
                                        <h3 class="text-2xl font-semibold text-slate-900 md:text-3xl">
                                            {{ $slide->getTranslation('title', $activeLocale) }}
                                        </h3>
                                        <p class="text-sm text-slate-600 md:text-base">
                                            {{ $slide->getTranslation('description', $activeLocale) }}
                                        </p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        @if($slide->cta_url)
                                            <a href="{{ $slide->cta_url }}" target="_blank" rel="noopener" class="btn-primary">
                                                {{ $slide->getTranslation('cta_label', $activeLocale) ?? trans('web.read_more') }}
                                            </a>
                                        @endif
                                        @if($slide->media_type === 'video' && $slide->video_url)
                                            <a href="{{ $slide->video_url }}" target="_blank" rel="noopener" class="btn-outline">
                                                <x-ui.icon name="play" class="h-4 w-4" />
                                                {{ __('Tonton Video') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="hero-slide-media">
                                    @if($slide->media_type === 'image' && $slide->media_path)
                                        <img src="{{ $resolveAsset($slide->media_path) ?? $heroFallbackImage }}" alt="{{ $slide->getTranslation('title', $activeLocale) }}" class="h-full w-full object-cover">
                                    @elseif($slide->media_type === 'video' && $slide->video_url)
                                        <iframe src="{{ $slide->video_url }}" class="h-full w-full" allowfullscreen loading="lazy"></iframe>
                                    @else
                                        <img src="{{ $heroFallbackImage }}" alt="Telkom University" class="h-full w-full object-cover">
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <button type="button" class="absolute left-4 top-1/2 z-20 -translate-y-1/2 rounded-full border border-slate-200 bg-white/90 p-3 shadow" data-carousel-prev>
                        <x-ui.icon name="arrow-right" class="h-4 w-4 -rotate-180 text-slate-700" />
                    </button>
                    <button type="button" class="absolute right-4 top-1/2 z-20 -translate-y-1/2 rounded-full border border-slate-200 bg-white/90 p-3 shadow" data-carousel-next>
                        <x-ui.icon name="arrow-right" class="h-4 w-4 text-slate-700" />
                    </button>
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2">
                        @foreach($heroSlides as $slide)
                            <button type="button" class="h-2.5 w-8 rounded-full bg-slate-300 transition" data-carousel-dot></button>
                        @endforeach
                    </div>
                </div>
                <div class="card-soft p-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-semibold uppercase tracking-[0.3em] text-red-500">{{ trans('web.announcements') }}</h4>
                        <a href="{{ route('news.index', ['locale' => $activeLocale]) }}" class="text-xs font-semibold text-red-600 hover:text-red-500">{{ trans('web.view_all') }}</a>
                    </div>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        @forelse($announcements as $announcement)
                            <li class="rounded-2xl border border-slate-200/80 bg-slate-50/80 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-semibold text-slate-900">{{ $announcement->getTranslation('title', $activeLocale) }}</p>
                                    <span class="text-xs text-slate-400">{{ $announcement->starts_at?->translatedFormat('d M Y') }}</span>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">{{ Str::limit(strip_tags($announcement->getTranslation('body', $activeLocale)), 140) }}</p>
                                @if($announcement->cta_url)
                                    <a href="{{ $announcement->cta_url }}" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-2 text-xs font-semibold text-red-600 hover:text-red-500">
                                        {{ $announcement->getTranslation('cta_label', $activeLocale) ?? trans('web.read_more') }}
                                        <x-ui.icon name="arrow-right" class="h-3 w-3" />
                                    </a>
                                @endif
                            </li>
                        @empty
                            <li class="rounded-2xl border border-dashed border-slate-300 p-4 text-xs text-slate-400">{{ __('Belum ada pengumuman aktif.') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="profil" class="section-block">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ __('Tentang Direktorat') }}</p>
                <h2 class="section-title">{{ __('Mitra Strategis Pengelolaan Keuangan Telkom University') }}</h2>
                <p class="section-subtitle">
                    {{ $siteSetting?->getTranslation('about', $activeLocale) ? Str::limit(strip_tags($siteSetting->getTranslation('about', $activeLocale)), 260) : __('Direktorat Keuangan menghadirkan tata kelola anggaran, layanan kas, dan pelaporan untuk mendukung seluruh unit kerja kampus.') }}
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="#services" class="btn-outline">
                    <x-ui.icon name="presentation-chart-bar" class="h-4 w-4" />
                    {{ __('Strategi & Program') }}
                </a>
                <a href="{{ route('contact', ['locale' => $activeLocale]) }}" class="btn-primary">
                    <x-ui.icon name="phone" class="h-4 w-4" />
                    {{ __('Hubungi Kami') }}
                </a>
            </div>
        </div>
        <div class="mt-10 grid gap-6 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="card-soft p-8">
                <h3 class="text-lg font-semibold text-slate-900">{{ __('Fokus Tata Kelola') }}</h3>
                <ul class="mt-4 space-y-4 text-sm text-slate-600">
                    <li class="flex items-start gap-3">
                        <x-ui.icon name="shield-check" class="mt-1 h-5 w-5 text-red-500" />
                        <span>{{ __('Kepatuhan dan transparansi dalam siklus pengelolaan anggaran universitas.') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-ui.icon name="presentation-chart-bar" class="mt-1 h-5 w-5 text-red-500" />
                        <span>{{ __('Pemanfaatan dashboard digital untuk insight real-time terhadap realisasi anggaran.') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-ui.icon name="life-buoy" class="mt-1 h-5 w-5 text-red-500" />
                        <span>{{ __('Helpdesk layanan dana multi kanal yang responsif bagi seluruh sivitas akademika.') }}</span>
                    </li>
                </ul>
            </div>
            @if($leadershipMessage)
                <div class="card-soft p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">{{ __('Pesan Pimpinan') }}</p>
                    <blockquote class="mt-4 space-y-4 text-sm text-slate-600">
                        {!! $leadershipMessage->getTranslation('message', $activeLocale) !!}
                        <footer class="border-l-2 border-red-200 pl-4 text-sm text-slate-500">
                            <p class="font-semibold text-slate-900">{{ $leadershipMessage->leader_name }}</p>
                            <p>{{ $leadershipMessage->leader_title }}</p>
                        </footer>
                    </blockquote>
                </div>
            @endif
        </div>
    </section>

    <section id="services" class="section-block">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ trans('web.programs.title') }}</p>
                <h2 class="section-title">{{ __('Program Strategis & Inisiatif Layanan') }}</h2>
                <p class="section-subtitle">{{ __('Rangkaian program transformasi digital, penguatan kepatuhan, dan dukungan layanan dana untuk Telkom University.') }}</p>
            </div>
            <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="btn-outline">{{ trans('web.view_all') }}</a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($featuredPrograms as $program)
                @php
                    $programIcon = null;

                    if ($program->icon) {
                        $programIcon = (string) Str::of($program->icon)
                            ->replace('heroicon-o-', '')
                            ->replace('heroicon-s-', '');
                    }
                @endphp
                <article class="card-soft flex h-full flex-col gap-4 p-6">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                        @if($programIcon)
                            <x-ui.icon :name="$programIcon" class="h-6 w-6" />
                        @else
                            <span class="text-sm font-semibold">{{ strtoupper(Str::limit($program->getTranslation('name', $activeLocale), 2, '')) }}</span>
                        @endif
                    </div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">{{ trans('web.program_types.' . $program->type) }}</p>
                    <h3 class="text-lg font-semibold text-slate-900">{{ $program->getTranslation('name', $activeLocale) }}</h3>
                    <p class="text-sm text-slate-600">{{ $program->getTranslation('summary', $activeLocale) }}</p>
                    <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $program]) }}" class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-500">
                        {{ trans('web.read_more') }}
                        <x-ui.icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </article>
            @endforeach
        </div>

        @if($services->isNotEmpty())
            <div class="mt-12 grid gap-4 md:grid-cols-3">
                @foreach($services as $service)
                        @php
                            $serviceIcon = null;

                            if ($service->icon) {
                                $serviceIcon = (string) Str::of($service->icon)
                                    ->replace('heroicon-o-', '')
                                    ->replace('heroicon-s-', '');
                            }
                        @endphp
                    <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $service]) }}" class="card-soft flex items-start gap-3 border border-red-100/60 bg-white/90 p-5 text-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600">
                            @if($serviceIcon)
                                <x-ui.icon :name="$serviceIcon" class="h-5 w-5" />
                            @else
                                <span class="text-xs font-semibold">{{ strtoupper(Str::limit($service->getTranslation('name', $activeLocale), 2, '')) }}</span>
                            @endif
                        </span>
                        <span>
                            <span class="block font-semibold text-slate-900">{{ $service->getTranslation('name', $activeLocale) }}</span>
                            <span class="mt-1 block text-xs text-slate-500">{{ $service->getTranslation('summary', $activeLocale) }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <section id="documents" class="section-block">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ trans('web.documents') }}</p>
                <h2 class="section-title">{{ __('Repositori Dokumen Keuangan') }}</h2>
                <p class="section-subtitle">{{ __('Laporan audit, RBA, SOP, dan dokumen keuangan lainnya yang relevan untuk sivitas akademika.') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('documents.index', ['locale' => $activeLocale]) }}" class="btn-outline">{{ trans('web.view_all') }}</a>
            </div>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($highlightDocuments as $document)
                <article class="card-soft p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">{{ trans('web.document_categories.' . $document->category) }}</p>
                    <h3 class="mt-3 text-base font-semibold text-slate-900">{{ $document->getTranslation('title', $activeLocale) }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $document->getTranslation('description', $activeLocale) }}</p>
                    <div class="mt-3 text-xs text-slate-500">{{ $document->published_at?->translatedFormat('d F Y') ?? $document->year }}</div>
                    <div class="mt-4 flex flex-wrap gap-2 text-xs">
                        <a href="{{ route('documents.show', ['locale' => $activeLocale, 'document' => $document]) }}" class="inline-flex items-center gap-2 rounded-full border border-red-200 px-3 py-1 font-semibold text-red-600 hover:border-red-400">
                            {{ trans('web.documents_list.view') }}
                        </a>
                        @if($document->external_url)
                            <a href="{{ $document->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 font-semibold text-slate-600 hover:border-red-200">
                                {{ trans('web.documents_list.external') }}
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    @if($formDownloads->isNotEmpty())
        <section id="downloads" class="section-block">
            <div class="section-heading">
                <div>
                    <p class="pill-muted">{{ trans('web.downloads.title') }}</p>
                    <h2 class="section-title">{{ trans('web.downloads.title') }}</h2>
                    <p class="section-subtitle">{{ trans('web.downloads.subtitle') }}</p>
                </div>
                <a href="{{ route('documents.index', ['locale' => $activeLocale, 'category' => 'form']) }}" class="btn-outline">{{ trans('web.view_all') }}</a>
            </div>
            <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($formDownloads as $form)
                    <article class="card-soft flex h-full flex-col gap-4 p-5">
                        <h3 class="text-base font-semibold text-slate-900">{{ $form->getTranslation('title', $activeLocale) }}</h3>
                        <p class="flex-1 text-sm text-slate-600">{{ $form->getTranslation('description', $activeLocale) }}</p>
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span>{{ $form->document_number }}</span>
                            <span>{{ $form->published_at?->translatedFormat('d F Y') ?? $form->year }}</span>
                        </div>
                        <a href="{{ route('documents.show', ['locale' => $activeLocale, 'document' => $form]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-500">
                            {{ trans('web.documents_list.open_form') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <section id="news" class="section-block">
        <div class="section-heading">
            <div>
                <p class="pill-muted">{{ trans('web.latest_news') }}</p>
                <h2 class="section-title">{{ __('Publikasi & Informasi Terbaru') }}</h2>
                <p class="section-subtitle">{{ __('Ikuti perkembangan program, layanan, dan kebijakan Direktorat Keuangan terkini.') }}</p>
            </div>
            <a href="{{ route('news.index', ['locale' => $activeLocale]) }}" class="btn-outline">{{ trans('web.view_all') }}</a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @forelse($latestNews as $post)
                <article class="card-soft overflow-hidden">
                    @if($post->cover_image_path)
                        <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="h-44 w-full object-cover" />
                    @endif
                    <div class="space-y-3 p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-red-500">
                            {{ $post->category?->getTranslation('name', $activeLocale) ?? trans('web.news.title') }}
                        </p>
                        <h3 class="text-lg font-semibold text-slate-900">{{ $post->getTranslation('title', $activeLocale) }}</h3>
                        <p class="text-sm text-slate-600">{{ $post->getTranslation('excerpt', $activeLocale) }}</p>
                        <div class="text-xs text-slate-500">{{ $post->published_at?->translatedFormat('d F Y') }}</div>
                        <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $post]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-500">
                            {{ trans('web.read_more') }}
                            <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-slate-200 bg-white p-6 text-sm text-slate-500">{{ trans('web.news.empty') }}</p>
            @endforelse
        </div>
    </section>

    <section id="faq" class="section-block grid gap-10 lg:grid-cols-[1.1fr,0.9fr]">
        <div class="card-soft p-8">
            <p class="pill-muted">{{ trans('web.faqs') }}</p>
            <h2 class="section-title">{{ __('Tanya Jawab Tata Kelola Keuangan') }}</h2>
            <p class="section-subtitle">{{ __('Temukan jawaban cepat mengenai kebijakan keuangan, layanan pembayaran, dan dukungan administrasi.') }}</p>
            <div class="faq-accordion mt-6">
                @foreach($faqs as $faq)
                    <div class="faq-card" data-faq-card>
                        <button type="button" class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left text-sm font-semibold text-slate-900" data-faq-trigger>
                            <span>{{ $faq->getTranslation('question', $activeLocale) }}</span>
                            <svg class="h-5 w-5 text-red-500 transition" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a.75.75 0 01.75.75v3.5h3.5a.75.75 0 010 1.5h-3.5v3.5a.75.75 0 01-1.5 0v-3.5h-3.5a.75.75 0 010-1.5h3.5v-3.5A.75.75 0 0110 5z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="faq-body" data-faq-body>
                            {!! $faq->getTranslation('answer', $activeLocale) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="space-y-6" id="contact">
            <div class="card-soft p-8">
                <p class="pill-muted">{{ trans('web.contact_us') }}</p>
                <h2 class="text-xl font-semibold text-slate-900">{{ __('Hubungi Direktorat Keuangan') }}</h2>
                <p class="mt-3 text-sm text-slate-600">{{ __('Tim kami siap membantu kebutuhan layanan keuangan, penyusunan anggaran, dan dukungan operasional unit.') }}</p>
                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    @foreach($contactChannels as $channel)
                        <div class="card-muted border border-slate-200/80 p-4">
                            <p class="text-xs uppercase tracking-[0.35em] text-red-500">{{ ucfirst($channel->type) }}</p>
                            <p class="mt-1 text-base font-semibold text-slate-900">{{ $channel->getTranslation('name', $activeLocale) }}</p>
                            <p class="mt-1 text-slate-600">{{ $channel->value }}</p>
                            @if($channel->getTranslation('notes', $activeLocale))
                                <p class="mt-1 text-xs text-slate-500">{{ $channel->getTranslation('notes', $activeLocale) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-soft p-4">
                @if($siteSetting?->map_embed)
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        <div class="aspect-[4/3] md:aspect-[16/9]">
                            {!! $siteSetting->map_embed !!}
                        </div>
                    </div>
                @else
                    <div class="flex h-full items-center justify-center rounded-2xl border border-dashed border-slate-300 p-6 text-sm text-slate-400">
                        {{ __('Embed peta belum diatur.') }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if(! empty($partnerLogos))
        <section id="partners" class="section-block">
            <div class="section-heading">
                <div>
                    <p class="pill-muted">{{ __('Kemitraan Strategis') }}</p>
                    <h2 class="section-title">{{ __('Partner Pembayaran & Perbankan Telkom University') }}</h2>
                    <p class="section-subtitle">{{ __('Kolaborasi dengan institusi perbankan nasional untuk mendukung layanan transaksi dan pengelolaan kas kampus.') }}</p>
                </div>
            </div>
            <div class="partner-marquee mt-8">
                <div class="partner-track">
                    @foreach($partnerLogos as $partner)
                        <div class="partner-item">
                            <img src="{{ asset($partner['logo']) }}" alt="{{ $partner['name'] }}" class="h-10 w-auto object-contain">
                        </div>
                    @endforeach
                    @foreach($partnerLogos as $partner)
                        <div class="partner-item">
                            <img src="{{ asset($partner['logo']) }}" alt="{{ $partner['name'] }}" class="h-10 w-auto object-contain">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
