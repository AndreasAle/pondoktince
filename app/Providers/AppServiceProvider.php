<?php

namespace App\Providers;

use App\Models\NavigationMenu;
use App\Services\SeoManager;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Request-scoped SEO state shared across controller + views.
        $this->app->singleton(SeoManager::class);
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        // Share navigation + settings with public views only (avoids DB hits in admin).
        View::composer(['layouts.public', 'partials.*', 'pages.*'], function ($view) {
            $view->with([
                'siteSettings' => settings(),
                'headerNav' => $this->nav('header'),
                'footerNav' => $this->nav('footer'),
                'mobileNav' => $this->nav('mobile'),
            ]);
        });
    }

    protected function nav(string $location)
    {
        return NavigationMenu::query()
            ->location($location)
            ->active()
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get();
    }
}
