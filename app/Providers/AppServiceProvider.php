<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use App\Policies\PostPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;

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
        $setting->whatsapp = "https://wa.me/" . $setting->phone;
        $relatedSites = RelatedNewsSite::select('name', 'url')->get();
        $categories = Category::active()->select('id', 'slug', 'name')->get();

        view()->share([
            'setting' => $setting,
            'relatedSites' => $relatedSites,
            'categories' => $categories
        ]);

        $this->configureRateLimiter();
        foreach(config('authorization.permissions') as $config_permission=>$value){
            Gate::define($config_permission , function($auth) use($config_permission){
                return $auth->hasAccess($config_permission);
            });
        }
    }

    protected function configureRateLimiter()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(20)->by($request->user()?->id ?: $request->ip())->response(function () {
                return apiResponse(429, 'Try After Minute');
            });
        });

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip())->response(function () {
                return apiResponse(429, 'Try After Minute');
            });
        });
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function () {
                return apiResponse(429, 'Try After Minute');
            });
        });
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip())->response(function () {
                return apiResponse(429, 'Try After Minute');
            });
        });
        RateLimiter::for('comments', function (Request $request) {
            return Limit::perMinute(1)->by($request->ip())->response(function () {
                return apiResponse(429, 'Try After Minute');
            });
        });
    }
}
