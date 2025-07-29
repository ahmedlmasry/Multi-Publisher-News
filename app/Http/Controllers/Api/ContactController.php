<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Frontend\ContactRequest;

class ContactController extends Controller
{
    public function storeContact(ContactRequest $request)
    {
        $data = $request->validated();
        $data['ip_address'] = $request->ip();
        Contact::create($data);

//        $admins = Admin::get();
//        Notification::send($admins , new NewContactNotify($contact));
        return $this->apiResponse(201, 'Contact Created Successfully');
    }
}
