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
       if (!app()->environment('local')) {
        URL::forceScheme('https');
    }

    if (Schema::hasTable('faqs')) {
        try {
            $faqs = Faq::where('is_active', 1)
                        ->orderBy('order')
                        ->get();

            View::share('faqs', $faqs);
        } catch (\Exception $e) {
            // biarin aja kalau gagal waktu build
        }
    }

    }
}
