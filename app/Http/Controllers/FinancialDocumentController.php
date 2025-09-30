<?php

namespace App\Http\Controllers;

use App\Models\FinancialDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FinancialDocumentController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categories = [
            'report' => trans('web.document_categories.report'),
            'budget' => trans('web.document_categories.budget'),
            'policy' => trans('web.document_categories.policy'),
            'transparency' => trans('web.document_categories.transparency'),
            'service_standard' => trans('web.document_categories.service_standard'),
            'guideline' => trans('web.document_categories.guideline'),
            'form' => trans('web.document_categories.form'),
        ];

        $query = FinancialDocument::query()->orderByDesc('published_at')->orderByDesc('year');

        $category = $request->string('category')->toString();
        if ($category && array_key_exists($category, $categories)) {
            $query->where('category', $category);
        }

        $year = $request->integer('year');
        if ($year) {
            $query->where('year', $year);
        }

        $search = $request->string('q')->toString();
        if ($search) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title->id', 'like', "%{$search}%")
                    ->orWhere('title->en', 'like', "%{$search}%")
                    ->orWhere('description->id', 'like', "%{$search}%");
            });
        }

        $documents = $query->paginate(12)->withQueryString();
        $years = FinancialDocument::query()
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('web.documents.index', [
            'documents' => $documents,
            'categories' => $categories,
            'activeCategory' => $category,
            'years' => $years,
            'activeYear' => $year,
            'search' => $search,
        ]);
    }

    public function show(string $locale, FinancialDocument $document): View
    {
        $fileUrl = $document->file_path && Storage::disk('public')->exists($document->file_path)
            ? Storage::disk('public')->url($document->file_path)
            : null;

        return view('web.documents.show', [
            'document' => $document,
            'fileUrl' => $fileUrl,
        ]);
    }

    public function download(string $locale, FinancialDocument $document): StreamedResponse
    {
        if (! $document->file_path || ! Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($document->file_path, sprintf('%s.pdf', $document->slug));
    }
}
