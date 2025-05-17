<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'site_name' => 'news',
            'logo' => '/test/logo.png',
            'favicon' => 'default',
            'email' => 'news@gmail.com',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://www.twitter.com/',
            'instagram' => 'https://www.instagram.com/',
            'youtube' => 'https://www.youtube.com/',
            'country' => 'Egypt',
            'city' => 'Cairo',
            'street' => 'First Abbas',
            'phone' => '01000999388',
            'small_desc' => '23 of PARAGE is equality of condition, blood, or dignity; specifically : equality between persons (as brothers) one of whom holds a part of a fee ',
        ]);
    }
}
