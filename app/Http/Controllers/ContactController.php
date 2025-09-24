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

        return view('web.contact', [
            'setting' => $setting,
            'channels' => $channels,
            'announcements' => $announcements,
        ]);
    }
}
