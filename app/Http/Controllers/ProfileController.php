<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __invoke(string $locale): View
    {
        $setting = SiteSetting::query()->first();
        $strategicPrograms = Program::query()->active()->where('type', 'program')->take(4)->get();
        $latestNews = NewsPost::query()->published()->latest('published_at')->take(3)->get();

        return view('web.profile', [
            'setting' => $setting,
            'strategicPrograms' => $strategicPrograms,
            'latestNews' => $latestNews,
        ]);
    }
}
