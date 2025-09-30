<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __invoke(string $locale): View
    {
        $faqs = Faq::query()->where('is_active', true)->orderBy('display_order')->get();

        return view('web.faq.index', [
            'faqs' => $faqs,
        ]);
    }
}
