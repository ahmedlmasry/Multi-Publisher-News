<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
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
        Paginator::useBootstrap();

        $setting = Setting::first();
        $setting->whatsapp = "https://wa.me/".$setting->phone;
        $relatedSites = RelatedNewsSite::select('name', 'url')->get();
        $categories = Category::active()->select('id','slug', 'name')->get();

        view()->share([
            'setting' => $setting,
            'relatedSites'=> $relatedSites,
            'categories'=>$categories
        ]);


    }
}
