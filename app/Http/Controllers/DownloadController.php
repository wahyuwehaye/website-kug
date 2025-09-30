<?php

namespace App\Http\Controllers;

use App\Models\FinancialDocument;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DownloadController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categories = [
            'form' => trans('web.document_categories.form'),
            'guideline' => trans('web.document_categories.guideline'),
            'service_standard' => trans('web.document_categories.service_standard'),
            'policy' => trans('web.document_categories.policy'),
        ];

        $query = FinancialDocument::query()->orderByDesc('published_at')->whereIn('category', array_keys($categories));

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $downloads = $query->paginate(12)->withQueryString();

        return view('web.downloads.index', [
            'downloads' => $downloads,
            'categories' => $categories,
            'activeCategory' => $category,
        ]);
    }
}
