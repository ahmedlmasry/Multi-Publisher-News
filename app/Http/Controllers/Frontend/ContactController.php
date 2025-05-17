<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Frontend\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }
    public function store(ContactRequest $request)
    {
        $data = $request->validated();
        $data['ip_address'] = $request->ip();
        Contact::create($data);
//        $admins = Admin::get();
//        Notification::send($admins , new NewContactNotify($contact));
        return redirect()->back()->with('success' , 'Your Msg Created Successfully!');
    }
}

