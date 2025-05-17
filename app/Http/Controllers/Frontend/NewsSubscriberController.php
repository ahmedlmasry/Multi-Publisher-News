<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\SendMails;
use App\Models\NewSubscriber;
use Illuminate\Http\Request;


class NewsSubscriberController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:new_subscribers,email'],
        ]);
        NewSubscriber::create([
            'email' => $request->email,
        ]);
        SendMails::dispatch($request->email);
        return redirect()->back()->with('success', 'Thank You For Subscribing!');
    }
}
