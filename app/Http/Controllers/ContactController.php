<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\ContactChannel;
use App\Models\SiteSetting;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __invoke(string $locale): View
    {
        $setting = SiteSetting::query()->first();
        $channels = ContactChannel::query()->orderByDesc('is_primary')->orderBy('sort')->get();
        $announcements = Announcement::query()->active()->latest('starts_at')->take(5)->get();

        $mapLocation = [
            'lat' => $setting?->map_lat ?? -6.9739398,
            'lng' => $setting?->map_lng ?? 107.6325532,
            'zoom' => $setting?->map_zoom ?? 18,
            'title' => $setting?->getTranslation('name', $locale) ?? 'Telkom University Finance Directorate',
            'address' => $setting?->getTranslation('address', $locale) ?? 'Bangkit Building, 3rd Floor, Telkom University, Bandung',
            'hours' => $setting?->office_hours,
            'phone' => $setting?->phone,
            'email' => $setting?->email,
            'whatsapp' => $setting?->whatsapp,
            'directions_url' => 'https://www.google.com/maps/place/Bangkit+Building+-+Telkom+University/@-6.9739398,107.6325532,18z',
        ];

        return view('web.contact', [
            'setting' => $setting,
            'channels' => $channels,
            'announcements' => $announcements,
            'mapLocation' => $mapLocation,
        ]);
    }
}
