<?php

namespace App\Providers;

use App\Models\Story;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share stories with navbar view
        View::composer('website.partials.navbar', function ($view) {
            $navbarStories = Story::approved()
                ->latest()
                ->limit(15)
                ->get();

            $view->with('navbarStories', $navbarStories);
        });
    }
}
