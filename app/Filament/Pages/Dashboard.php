<?php

namespace App\Filament\Pages;

use App\Models\Announcement;
use App\Models\FinancialDocument;
use App\Models\NewsPost;
use App\Models\Program;
use App\Models\Faq;
use App\Models\ContactChannel;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationLabel = 'Beranda';

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public function getHeading(): string | Htmlable
    {
        return 'Ringkasan Direktorat Keuangan';
    }

    public function getSubheading(): string | Htmlable
    {
        return 'Pantau status publikasi dan kelola konten strategis secara terpadu.';
    }

    protected function getViewData(): array
    {
        $now = Carbon::now();

        return [
            'summary' => [
                'announcements' => Announcement::count(),
                'activeAnnouncements' => Announcement::active()->count(),
                'news' => NewsPost::count(),
                'documents' => FinancialDocument::count(),
                'programs' => Program::where('type', 'program')->count(),
                'services' => Program::where('type', 'service')->count(),
                'faqs' => Faq::count(),
                'channels' => ContactChannel::count(),
            ],
            'latestAnnouncements' => Announcement::orderByDesc('published_at')->limit(3)->get(),
            'latestNews' => NewsPost::orderByDesc('published_at')->limit(4)->get(),
            'latestDocuments' => FinancialDocument::orderByDesc('published_at')->limit(3)->get(),
            'now' => $now,
        ];
    }
}
