<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Setting;
use App\Models\Category;
use App\Models\RelatedNewsSite;
use Illuminate\Foundation\Testing\RefreshDatabase;
abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Setting::create([
            'site_name' => 'News App',
            'logo' => '/logo.png',
            'favicon' => '/favicon.ico',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'facebook' => 'https://facebook.com',
            'twitter' => 'https://twitter.com',
            'instagram' => 'https://instagram.com',
            'youtube' => 'https://youtube.com',
            'country' => 'Egypt',
            'city' => 'Cairo',
            'street' => 'Street Name',
            'small_desc' => 'News App Description',
        ]);

        $setting = Setting::first();
        $categories = Category::where('status', 1)->select('id', 'slug', 'name')->get();
        $relatedSites = RelatedNewsSite::select('name', 'url')->get();

        view()->share([
            'setting' => $setting,
            'categories' => $categories,
            'relatedSites' => $relatedSites,
        ]);
    }
    public function createUser()
    {
        return User::factory()->create();
    }
}
