@extends('layouts.web')

@php
    use Illuminate\Support\Str;
    $title = trans('web.site_title');
@endphp

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-primary-900/80 to-slate-800 text-white">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-32 top-16 h-72 w-72 rounded-full bg-primary-500/40 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-amber-400/30 blur-[180px]"></div>
        </div>
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-20 lg:grid-cols-[1.2fr,0.8fr] lg:items-center">
            <div class="relative space-y-8">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">
                    <x-ui.icon name="sparkles" class="h-4 w-4" />
                    Finance Directorate
                </span>
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold leading-tight sm:text-4xl lg:text-5xl">
                        {{ $siteSetting?->getTranslation('tagline', $activeLocale) ?? 'Transparansi dan Keunggulan Tata Kelola Keuangan Telkom University' }}
                    </h2>
                    <p class="text-base text-slate-200 sm:text-lg">
                        {{ $siteSetting?->getTranslation('short_description', $activeLocale) ?? Str::limit(strip_tags($siteSetting?->getTranslation('about', $activeLocale)), 190) }}
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-amber-500/40 transition hover:-translate-y-0.5 hover:bg-amber-300">
                        <x-ui.icon name="arrow-right" class="h-4 w-4 rotate-0 text-slate-900" />
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
                    <div class="rounded-2xl bg-white/10 p-5 shadow-xl shadow-slate-900/20 ring-1 ring-white/10">
                        <dt class="text-xs uppercase tracking-wide text-slate-200">{{ trans('web.announcements') }}</dt>
                        <dd class="mt-2 flex items-center gap-2 text-3xl font-semibold text-white">
                            <x-ui.icon name="megaphone" class="h-6 w-6 text-amber-200" />
                            {{ $announcements->count() }}
                        </dd>
                        <p class="mt-2 text-xs text-slate-300">{{ __('Siaran penting pekan ini') }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-5 shadow-xl shadow-slate-900/20 ring-1 ring-white/10">
                        <dt class="text-xs uppercase tracking-wide text-slate-200">{{ trans('web.documents') }}</dt>
                        <dd class="mt-2 flex items-center gap-2 text-3xl font-semibold text-white">
                            <x-ui.icon name="document-text" class="h-6 w-6 text-amber-200" />
                            {{ $highlightDocuments->count() }}
                        </dd>
                        <p class="mt-2 text-xs text-slate-300">{{ __('Repositori keuangan terkini') }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-5 shadow-xl shadow-slate-900/20 ring-1 ring-white/10">
                        <dt class="text-xs uppercase tracking-wide text-slate-200">{{ trans('web.programs.title') }}</dt>
                        <dd class="mt-2 flex items-center gap-2 text-3xl font-semibold text-white">
                            <x-ui.icon name="chart-bar" class="h-6 w-6 text-amber-200" />
                            {{ $featuredPrograms->count() + $services->count() }}
                        </dd>
                        <p class="mt-2 text-xs text-slate-300">{{ __('Program strategis & layanan unggulan') }}</p>
                    </div>
                </dl>
            </div>
            <div class="relative rounded-3xl bg-white/10 p-6 ring-1 ring-white/15 backdrop-blur">
                <div class="mb-4 flex items-center justify-between text-sm font-semibold text-amber-200">
                    <span>{{ __('Highlight Direktorat') }}</span>
                    <div class="flex items-center gap-1 text-xs text-slate-200">
                        <x-ui.icon name="arrow-right" class="h-3 w-3 rotate-180" />
                        {{ __('Slide') }}
                    </div>
                </div>
                @if($heroSlides->isNotEmpty())
                    <div class="flex max-h-[24rem] flex-col gap-5 overflow-y-auto pr-2">
                        @foreach($heroSlides as $slide)
                            <article class="rounded-2xl bg-white/90 p-5 text-slate-800 shadow-lg shadow-slate-900/10">
                                @if($slide->media_type === 'image' && $slide->media_path)
                                    <img src="{{ asset('storage/'.$slide->media_path) }}" alt="{{ $slide->getTranslation('title', $activeLocale) }}" class="mb-4 h-40 w-full rounded-2xl object-cover">
                                @elseif($slide->media_type === 'video' && $slide->video_url)
                                    <div class="mb-4 overflow-hidden rounded-2xl ring-1 ring-slate-200">
                                        <iframe src="{{ $slide->video_url }}" title="Hero Video" class="h-40 w-full" allowfullscreen></iframe>
                                    </div>
                                @endif
                                <h3 class="text-lg font-semibold text-slate-900">{{ $slide->getTranslation('title', $activeLocale) }}</h3>
                                @if($slide->getTranslation('subtitle', $activeLocale))
                                    <p class="text-xs uppercase tracking-wide text-primary-600">{{ $slide->getTranslation('subtitle', $activeLocale) }}</p>
                                @endif
                                <p class="mt-2 text-sm text-slate-600">{{ $slide->getTranslation('description', $activeLocale) }}</p>
                                @if($slide->getTranslation('cta_label', $activeLocale) && $slide->cta_url)
                                    <a href="{{ $slide->cta_url }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-700" target="_blank" rel="noopener">
                                        {{ $slide->getTranslation('cta_label', $activeLocale) }}
                                        <x-ui.icon name="arrow-right" class="h-4 w-4" />
                                    </a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-200">{{ __('Isi slider melalui panel admin.') }}</p>
                @endif
            </div>
        </div>
    </section>

    @if($announcements->isNotEmpty())
        <section class="relative bg-white py-12">
            <div class="mx-auto max-w-7xl px-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">{{ trans('web.announcements') }}</h2>
                        <p class="text-sm text-slate-500">{{ __('Informasi kebijakan dan jadwal layanan terbaru.') }}</p>
                    </div>
                    <a href="{{ route('news.index', ['locale' => $activeLocale, 'category' => 'pengumuman']) }}" class="inline-flex items-center gap-2 rounded-full border border-primary-200 px-4 py-2 text-sm font-semibold text-primary-600 transition hover:bg-primary-50">
                        {{ trans('web.view_all') }}
                        <x-ui.icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach($announcements as $announcement)
                        <article class="relative overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-6 shadow-lg shadow-slate-200/40">
                            <span class="inline-flex items-center gap-2 rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-primary-700">
                                <x-ui.icon name="megaphone" class="h-4 w-4" />
                                {{ Str::upper($announcement->type) }}
                            </span>
                            <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ $announcement->getTranslation('title', $activeLocale) }}</h3>
                            <p class="mt-3 text-sm text-slate-600 line-clamp-3">{{ Str::limit(strip_tags($announcement->getTranslation('body', $activeLocale)), 140) }}</p>
                            <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                                <span>{{ $announcement->starts_at?->translatedFormat('d F Y') }}</span>
                                @if($announcement->ends_at)
                                    <span>{{ __('s.d') }} {{ $announcement->ends_at->translatedFormat('d F Y') }}</span>
                                @endif
                            </div>
                            @if($announcement->cta_url)
                                <a href="{{ $announcement->cta_url }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-700">
                                    {{ $announcement->getTranslation('cta_label', $activeLocale) ?? trans('web.read_more') }}
                                    <x-ui.icon name="arrow-right" class="h-4 w-4" />
                                </a>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-slate-100 py-16" id="about">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid gap-10 lg:grid-cols-[2fr,3fr] lg:items-start">
                <div class="rounded-3xl bg-white p-8 shadow-lg">
                    <h2 class="text-2xl font-bold text-slate-900">{{ __('Tentang Direktorat Keuangan') }}</h2>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">{!! $siteSetting?->getTranslation('about', $activeLocale) !!}</p>
                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        <div class="rounded-2xl border border-primary-100 bg-primary-50 p-6">
                            <h3 class="text-lg font-semibold text-primary-700">Visi</h3>
                            <p class="mt-3 text-sm text-primary-900">{!! $siteSetting?->getTranslation('vision', $activeLocale) !!}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6">
                            <h3 class="text-lg font-semibold text-slate-900">Misi</h3>
                            <p class="mt-3 text-sm text-slate-700">{!! $siteSetting?->getTranslation('mission', $activeLocale) !!}</p>
                        </div>
                    </div>
                </div>
                @if($leadershipMessage)
                    <div class="rounded-3xl bg-white p-8 shadow-lg">
                        <div class="flex flex-col gap-6 md:flex-row">
                            @if($leadershipMessage->photo_path)
                                <img src="{{ asset('storage/'.$leadershipMessage->photo_path) }}" alt="{{ $leadershipMessage->leader_name }}" class="h-36 w-36 rounded-full object-cover shadow" />
                            @endif
                            <div>
                                <p class="text-sm uppercase tracking-wide text-primary-600">Pimpinan Direktorat</p>
                                <h3 class="text-xl font-bold text-slate-900">{{ $leadershipMessage->leader_name }}</h3>
                                <p class="text-sm text-slate-600">{{ $leadershipMessage->leader_title }}</p>
                            </div>
                        </div>
                        <blockquote class="mt-6 border-l-4 border-primary-200 pl-5 text-slate-700">
                            {!! $leadershipMessage->getTranslation('message', $activeLocale) !!}
                        </blockquote>
                        @if($leadershipMessage->signature_path)
                            <div class="mt-6">
                                <img src="{{ asset('storage/'.$leadershipMessage->signature_path) }}" alt="Signature" class="h-16">
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-white py-16" id="programs">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-2xl font-bold text-slate-900">{{ trans('web.program_and_services') }}</h2>
                <a href="{{ route('programs.index', ['locale' => $activeLocale]) }}" class="text-sm font-semibold text-primary-600 hover:text-primary-500">{{ trans('web.view_all') }}</a>
            </div>
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach($featuredPrograms as $program)
                    @php
                        $programIcon = $program->icon
                            ? Str::of($program->icon)
                                ->replace('heroicon-o-', '')
                                ->replace('heroicon-s-', '')
                                ->value()
                            : null;
                    @endphp
                    <article class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-50 text-primary-600">
                            @if($programIcon)
                                <x-ui.icon :name="$programIcon" class="h-6 w-6" />
                            @else
                                <span class="text-sm font-semibold">{{ strtoupper(substr($program->getTranslation('name', $activeLocale), 0, 2)) }}</span>
                            @endif
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-slate-900">{{ $program->getTranslation('name', $activeLocale) }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ $program->getTranslation('summary', $activeLocale) }}</p>
                        <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $program]) }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-500">
                            {{ trans('web.read_more') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25l4.5 4.5-4.5 4.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18" />
                            </svg>
                        </a>
                    </article>
                @endforeach
            </div>

                @if($services->isNotEmpty())
                    <div class="mt-12 rounded-3xl bg-primary-600 px-8 py-10 text-white">
                        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-xl font-bold">{{ trans('web.services') }}</h3>
                                <p class="mt-2 text-sm text-primary-100">{{ __('Layanan operasional keuangan untuk sivitas Telkom University.') }}</p>
                            </div>
                            <div class="grid gap-4 md:grid-cols-3">
                                @foreach($services as $service)
                                    @php
                                        $serviceIcon = $service->icon
                                            ? Str::of($service->icon)
                                                ->replace('heroicon-o-', '')
                                                ->replace('heroicon-s-', '')
                                                ->value()
                                            : null;
                                    @endphp
                                    <a href="{{ route('programs.show', ['locale' => $activeLocale, 'program' => $service]) }}" class="flex items-start gap-3 rounded-2xl bg-white/10 p-4 text-sm hover:bg-white/20">
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-primary-100">
                                            @if($serviceIcon)
                                                <x-ui.icon :name="$serviceIcon" class="h-5 w-5" />
                                            @else
                                                <span class="text-xs font-semibold">{{ strtoupper(substr($service->getTranslation('name', $activeLocale), 0, 2)) }}</span>
                                            @endif
                                        </span>
                                        <span>
                                            <span class="block font-semibold text-white">{{ $service->getTranslation('name', $activeLocale) }}</span>
                                            <span class="mt-1 block text-xs text-primary-100">{{ $service->getTranslation('summary', $activeLocale) }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
        </div>
    </section>

    <section class="bg-slate-50 py-16" id="documents">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-2xl font-bold text-slate-900">{{ trans('web.documents') }}</h2>
                <a href="{{ route('documents.index', ['locale' => $activeLocale]) }}" class="text-sm font-semibold text-primary-600 hover:text-primary-500">{{ trans('web.view_all') }}</a>
            </div>
            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                @foreach($highlightDocuments as $document)
                    <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">{{ trans('web.document_categories.' . $document->category) }}</p>
                        <h3 class="mt-3 text-base font-semibold text-slate-900">{{ $document->getTranslation('title', $activeLocale) }}</h3>
                        <p class="mt-2 text-sm text-slate-600 line-clamp-3">{{ $document->getTranslation('description', $activeLocale) }}</p>
                        <div class="mt-3 text-xs text-slate-500">{{ $document->published_at?->translatedFormat('d F Y') ?? $document->year }}</div>
                        <div class="mt-4 flex flex-wrap gap-2 text-xs">
                            @if($document->file_path)
                                <a href="{{ route('documents.download', ['locale' => $activeLocale, 'document' => $document]) }}" class="inline-flex items-center gap-2 rounded-full bg-primary-100 px-3 py-1 text-primary-700 hover:bg-primary-200">
                                    {{ trans('web.documents_list.download') }}
                                </a>
                            @endif
                            @if($document->external_url)
                                <a href="{{ $document->external_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-primary-100 px-3 py-1 text-primary-600 hover:bg-primary-50">
                                    {{ trans('web.documents_list.external') }}
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-16" id="news">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-2xl font-bold text-slate-900">{{ trans('web.latest_news') }}</h2>
                <a href="{{ route('news.index', ['locale' => $activeLocale]) }}" class="text-sm font-semibold text-primary-600 hover:text-primary-500">{{ trans('web.view_all') }}</a>
            </div>
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @forelse($latestNews as $post)
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        @if($post->cover_image_path)
                            <img src="{{ asset('storage/'.$post->cover_image_path) }}" alt="{{ $post->getTranslation('title', $activeLocale) }}" class="h-44 w-full object-cover" />
                        @endif
                        <div class="space-y-3 p-6">
                            <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">
                                {{ $post->category?->getTranslation('name', $activeLocale) ?? trans('web.news.title') }}
                            </p>
                            <h3 class="text-lg font-semibold text-slate-900 line-clamp-2">{{ $post->getTranslation('title', $activeLocale) }}</h3>
                            <p class="text-sm text-slate-600 line-clamp-3">{{ $post->getTranslation('excerpt', $activeLocale) }}</p>
                            <div class="text-xs text-slate-500">{{ $post->published_at?->translatedFormat('d F Y') }}</div>
                            <a href="{{ route('news.show', ['locale' => $activeLocale, 'newsPost' => $post]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-500">
                                {{ trans('web.read_more') }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25l4.5 4.5-4.5 4.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-slate-600">{{ trans('web.news.empty') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-slate-100 py-16">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="rounded-3xl bg-white p-8 shadow">
                    <h2 class="text-2xl font-bold text-slate-900">{{ trans('web.faqs') }}</h2>
                    <div class="mt-6 space-y-4">
                        @foreach($faqs as $faq)
                            <details class="group rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <summary class="flex cursor-pointer items-center justify-between text-sm font-semibold text-slate-900">
                                    <span>{{ $faq->getTranslation('question', $activeLocale) }}</span>
                                    <svg class="h-5 w-5 text-primary-600 transition group-open:rotate-45" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a.75.75 0 01.75.75v3.5h3.5a.75.75 0 010 1.5h-3.5v3.5a.75.75 0 01-1.5 0v-3.5h-3.5a.75.75 0 010-1.5h3.5v-3.5A.75.75 0 0110 5z" clip-rule="evenodd" />
                                    </svg>
                                </summary>
                                <p class="mt-3 text-sm text-slate-600">{!! $faq->getTranslation('answer', $activeLocale) !!}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
                <div class="rounded-3xl bg-gradient-to-br from-primary-600 to-primary-700 p-8 text-white shadow">
                    <h2 class="text-2xl font-bold">{{ trans('web.contact_us') }}</h2>
                    <p class="mt-2 text-sm text-primary-100">{{ __('Kami siap membantu kebutuhan layanan keuangan dan administrasi anggaran.') }}</p>
                    <div class="mt-6 space-y-3 text-sm">
                        @foreach($contactChannels as $channel)
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-xs uppercase text-primary-200">{{ $channel->type }}</p>
                                <p class="mt-1 text-base font-semibold text-white">{{ $channel->getTranslation('name', $activeLocale) }}</p>
                                <p class="mt-1 text-primary-100">{{ $channel->value }}</p>
                            </div>
                        @endforeach
                    </div>
                    @if($siteSetting?->map_embed)
                        <div class="mt-8 overflow-hidden rounded-3xl border border-white/20 bg-white/5 shadow-lg shadow-primary-900/30">
                            <div class="aspect-[4/3] md:aspect-[16/9]">
                                {!! $siteSetting->map_embed !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
