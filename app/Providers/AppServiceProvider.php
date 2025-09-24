<?php

namespace App\Providers;

use App\Models\NavigationLink;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.web', 'web.*'], function ($view): void {
            $setting = SiteSetting::query()->first();

            $topNavigation = NavigationLink::query()
                ->where('location', 'top')
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            $mainNavigation = NavigationLink::query()
                ->with(['children' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort');
                }])
                ->where('location', 'main')
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            $footerNavigation = NavigationLink::query()
                ->where('location', 'footer')
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            $quickLinks = NavigationLink::query()
                ->where('location', 'quick')
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            $view->with([
                'siteSetting' => $setting,
                'topNavigation' => $topNavigation,
                'mainNavigation' => $mainNavigation,
                'footerNavigation' => $footerNavigation,
                'quickLinks' => $quickLinks,
                'availableLocales' => ['id' => 'Indonesia', 'en' => 'English'],
                'activeLocale' => App::getLocale(),
            ]);
        });
    }
}
