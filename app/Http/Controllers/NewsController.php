<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categories = NewsCategory::query()->where('is_active', true)->orderBy('name->id')->get();
        $categorySlug = $request->string('category')->toString();

        $posts = NewsPost::query()->published()->latest('published_at');

        $activeCategory = null;
        if ($categorySlug) {
            $activeCategory = $categories->firstWhere('slug', $categorySlug);
            if ($activeCategory) {
                $posts->where('news_category_id', $activeCategory->id);
            }
        }

        $posts = $posts->paginate(9)->withQueryString();

        return view('web.news.index', [
            'posts' => $posts,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(string $locale, NewsPost $newsPost): View
    {
        if ($newsPost->status !== 'published' || ! $newsPost->published_at || $newsPost->published_at->isFuture()) {
            abort(404);
        }

        $related = NewsPost::query()
            ->published()
            ->where('id', '!=', $newsPost->id)
            ->where('news_category_id', $newsPost->news_category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('web.news.show', [
            'post' => $newsPost,
            'relatedPosts' => $related,
        ]);
    }
}
