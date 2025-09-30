@props([
    'name' => 'sparkles',
    'class' => 'h-5 w-5',
])

@php
    use Illuminate\Support\HtmlString;
    use Illuminate\Support\Arr;

    if ($name instanceof \Illuminate\Support\Stringable) {
        $name = $name->toString();
    }

    if (is_array($name)) {
        $name = Arr::first($name);
    }

    $identifier = (string) ($name ?: 'sparkles');

    $paths = [
        'chart-bar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5l6 6 12-12M9 21V9m6 6V3" />',
        'life-buoy' => '<circle cx="12" cy="12" r="3.75"/><path stroke-linecap="round" stroke-linejoin="round" d="M5.1 5.1l3.4 3.4m7 7 3.4 3.4M5.1 18.9l3.4-3.4m7-7 3.4-3.4"/><circle cx="12" cy="12" r="8.25"/>',
        'scale' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M4 7l4.5 9a4.5 4.5 0 11-9 0L4 7zm16 0l4.5 9a4.5 4.5 0 11-9 0L20 7zM12 7v13"/>',
        'sparkles' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M12 18.75V21M21 12h-2.25M5.25 12H3m14.137-6.363l-1.59 1.59M6.453 17.137l-1.59 1.59M17.137 17.137l1.59 1.59M6.453 6.453l1.59 1.59M8.25 12a3.75 3.75 0 107.5 0 3.75 3.75 0 00-7.5 0z"/>',
        'arrow-right' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>',
        'map-pin' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.5-7.5 11.25-7.5 11.25S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z"/>',
        'phone' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15H19.5a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.09l-4.423-1.105a1.125 1.125 0 00-1.173.417l-.97 1.293a.75.75 0 01-1.21.038l-2.014-2.608a.75.75 0 01.063-.99l1.248-1.248a1.125 1.125 0 00.3-1.103L10.96 5.31a1.125 1.125 0 00-1.09-.852H8.5A2.25 2.25 0 006.25 6.75v0"/>',
        'envelope' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.5a2.25 2.25 0 01-2.26 0l-7.5-4.5a2.25 2.25 0 01-1.07-1.916V6.75"/>',
        'globe-alt' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3a17.97 17.97 0 010 18M12 3a17.97 17.97 0 000 18"/>',
        'document-text' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 3h6m2.25-9H12V3.75m4.5 2.25L12 3.75M6.75 3A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h10.5A2.25 2.25 0 0019.5 18.75V8.25L15 3H6.75z"/>',
        'megaphone' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25a.75.75 0 00-1.027-.707L5.79 8.18a.75.75 0 00-.54.714v6.212a.75.75 0 00.549.719l8.932 2.66a.75.75 0 00.999-.713V15a6.75 6.75 0 006.75 6.75h.75"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5v3.75"/>',
        'link' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6a3 3 0 014.243 4.243l-1.015 1.014m-1.415 1.414l-1.015 1.015a3 3 0 11-4.243-4.243"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 18a3 3 0 01-4.243-4.243l1.015-1.014m1.415-1.414l1.015-1.015a3 3 0 014.243 4.243"/>',
        'play' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.918-1.398 1.666-.986l11.54 6.347a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.666-.985V5.653z"/>',
        'shield-check' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75l7.5 3v6.75c0 5.25-3.75 8.25-7.5 9.75-3.75-1.5-7.5-4.5-7.5-9.75v-6.75l7.5-3z"/>',
        'presentation-chart-bar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5h18M3 21h18M7.5 12v3m4.5-6v6m4.5-3v3m-7.5 6l3 3 3-3"/>',
        'building-library' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5M2.25 10.5h19.5M12 3 2.25 10.5h19.5L12 3zM4.5 10.5V21M9 10.5V21m6-10.5V21m4.5-10.5V21"/>',
    ];

    $icon = new HtmlString($paths[$identifier] ?? $paths['sparkles']);
@endphp

<svg {{ $attributes->merge(['class' => $class, 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.5', 'viewBox' => '0 0 24 24', 'aria-hidden' => 'true']) }}>{!! $icon !!}</svg>
