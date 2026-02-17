<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View; 
use App\Models\Faq;
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
        if (app()->environment('local')) {
        URL::forceScheme('https');

    }
      $faqs = Faq::where('is_active', 1)
                    ->orderBy('order')
                    ->get();

        // Share ke semua view
        View::share('faqs', $faqs);

    }
}