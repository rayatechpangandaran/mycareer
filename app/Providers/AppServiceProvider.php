<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View; 
use App\Models\Faq;
use Illuminate\Support\Facades\Schema;
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
    // Force HTTPS hanya di production
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }

    // Jangan jalankan query saat console (build, config:cache, migrate, dll)
    if (app()->runningInConsole()) {
        return;
    }

    try {
        $faqs = \App\Models\Faq::where('is_active', 1)
                    ->orderBy('order')
                    ->get();

        \Illuminate\Support\Facades\View::share('faqs', $faqs);

    } catch (\Throwable $e) {
        // diamkan saja supaya tidak crash deploy
    }
}

}
