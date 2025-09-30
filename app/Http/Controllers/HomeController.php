<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\FinancialDocument;
use App\Models\HeroSlide;
use App\Models\LeadershipMessage;
use App\Models\NewsPost;
use App\Models\Program;
use App\Models\Faq;
use App\Models\ContactChannel;
use App\Models\SiteSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(string $locale): View
    {
        $setting = SiteSetting::query()->first();
        $heroSlides = HeroSlide::query()->where('is_active', true)->orderBy('sort')->get();
        $leadershipMessage = LeadershipMessage::query()->where('is_active', true)->latest('updated_at')->first();
        $featuredPrograms = Program::query()->active()->where('type', 'program')->orderBy('sort')->take(6)->get();
        $services = Program::query()->active()->where('type', 'service')->orderBy('sort')->take(6)->get();
        $highlightDocuments = FinancialDocument::query()->orderByDesc('published_at')->take(4)->get();
        $formDownloads = FinancialDocument::query()->where('category', 'form')->orderByDesc('published_at')->take(6)->get();
        $announcements = Announcement::query()->active()->latest('starts_at')->take(3)->get();
        $latestNews = NewsPost::query()->published()->latest('published_at')->take(3)->get();
        $faqs = Faq::query()->where('is_active', true)->orderBy('display_order')->take(6)->get();
        $contactChannels = ContactChannel::query()->orderByDesc('is_primary')->orderBy('sort')->get();

        $partnerLogos = [
            ['name' => 'Bank Mandiri', 'logo' => 'assets/images/mandiri.jpg'],
            ['name' => 'Bank BNI', 'logo' => 'assets/images/bni.jpg'],
            ['name' => 'Bank BJB', 'logo' => 'assets/images/bjb.jpg'],
            ['name' => 'Bank BSI', 'logo' => 'assets/images/bsi.jpg'],
            ['name' => 'Finnet', 'logo' => 'assets/images/finnet.jpg'],
            ['name' => 'PT. Mitra Kasih Perkasa', 'logo' => 'assets/images/kug.png'],
        ];

        return view('web.home', [
            'setting' => $setting,
            'heroSlides' => $heroSlides,
            'leadershipMessage' => $leadershipMessage,
            'featuredPrograms' => $featuredPrograms,
            'services' => $services,
            'highlightDocuments' => $highlightDocuments,
            'formDownloads' => $formDownloads,
            'announcements' => $announcements,
            'latestNews' => $latestNews,
            'faqs' => $faqs,
            'contactChannels' => $contactChannels,
            'partnerLogos' => $partnerLogos,
        ]);
    }
}
