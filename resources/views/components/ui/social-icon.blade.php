@props([
    'type',
    'href',
    'label' => null,
    'class' => 'h-4 w-4',
])

@php
    $icons = [
        'facebook' => 'resources/icons/social/facebook.svg',
        'instagram' => 'resources/icons/social/instagram.svg',
        'linkedin' => 'resources/icons/social/linkedin.svg',
        'youtube' => 'resources/icons/social/youtube.svg',
    ];

    $path = $icons[$type] ?? null;
@endphp

@if($path)
    <a href="{{ $href }}" target="_blank" rel="noopener" aria-label="{{ $label ?? ucfirst($type) }}" class="site-footer__social" title="{{ $label ?? ucfirst($type) }}">
        {!! file_get_contents(base_path($path)) !!}
    </a>
@endif
