<?php

namespace App\Http\Controllers;

use App\Models\FinancialDocument;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function __invoke(Request $request, string $locale): View
    {
        $year = (int) $request->get('year', now()->year);

        $news = NewsPost::query()
            ->published()
            ->whereYear('published_at', $year)
            ->latest('published_at')
            ->paginate(6, ['*'], 'news_page')
            ->withQueryString();

        $documents = FinancialDocument::query()
            ->whereYear('published_at', $year)
            ->orWhere('year', $year)
            ->orderByDesc('published_at')
            ->paginate(6, ['*'], 'documents_page')
            ->withQueryString();

        $years = collect(range(now()->year, now()->subYears(5)->year))->values();

        return view('web.archives.index', [
            'selectedYear' => $year,
            'years' => $years,
            'news' => $news,
            'documents' => $documents,
        ]);
    }
}
