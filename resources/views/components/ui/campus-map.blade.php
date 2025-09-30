@props([
    'lat',
    'lng',
    'zoom' => 18,
    'title' => null,
    'address' => null,
    'hours' => null,
    'phone' => null,
    'email' => null,
    'whatsapp' => null,
    'directionsUrl' => null,
    'marker' => null,
])

@php
    $markerIcon = $marker ?? asset('assets/images/kug.png');
    $directionsUrl = $directionsUrl ?? 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($address ?? 'Bangkit Building, Telkom University, Bandung');
@endphp

<div
    class="map-shell"
    data-map-lat="{{ $lat }}"
    data-map-lng="{{ $lng }}"
    data-map-zoom="{{ $zoom }}"
    data-map-marker="{{ $markerIcon }}"
>
    <div class="map-canvas" data-map-canvas></div>

    <div class="map-card">
        <div class="map-card__header">
            <span class="map-card__badge">{{ trans('web.map.badge') }}</span>
            <h3 class="map-card__title">{{ $title }}</h3>
            <p class="map-card__address">{{ $address }}</p>
        </div>
        <dl class="map-card__details">
            @if($hours)
                <div>
                    <dt>{{ trans('web.map.hours') }}</dt>
                    <dd>{{ $hours }}</dd>
                </div>
            @endif
            @if($phone)
                <div>
                    <dt>{{ trans('web.map.phone') }}</dt>
                    <dd><a href="tel:{{ $phone }}">{{ $phone }}</a></dd>
                </div>
            @endif
            @if($email)
                <div>
                    <dt>{{ trans('web.map.email') }}</dt>
                    <dd><a href="mailto:{{ $email }}">{{ $email }}</a></dd>
                </div>
            @endif
            @if($whatsapp)
                <div>
                    <dt>{{ trans('web.map.whatsapp') }}</dt>
                    <dd><a href="https://wa.me/{{ preg_replace('/\D+/', '', $whatsapp) }}" target="_blank" rel="noopener">{{ $whatsapp }}</a></dd>
                </div>
            @endif
        </dl>
        <a href="{{ $directionsUrl }}" target="_blank" rel="noopener" class="map-card__cta">
            <x-ui.icon name="arrow-right" class="h-4 w-4" />
            {{ trans('web.map.open_directions') }}
        </a>
    </div>

    <template data-map-popup>
        <div class="map-popup">
            <h3>{{ $title }}</h3>
            <p>{{ $address }}</p>
            @if($phone)
                <p class="map-popup__contact">{{ trans('web.map.phone') }}: <a href="tel:{{ $phone }}">{{ $phone }}</a></p>
            @endif
            @if($email)
                <p class="map-popup__contact">{{ trans('web.map.email') }}: <a href="mailto:{{ $email }}">{{ $email }}</a></p>
            @endif
            <a href="{{ $directionsUrl }}" target="_blank" rel="noopener" class="map-popup__cta">{{ trans('web.map.open_directions') }}</a>
        </div>
    </template>
</div>
