<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Requests\Frontend\ChangePasswordRequest;
use App\Http\Requests\Frontend\SettingRequest;
use App\Http\Controllers\Controller;
use App\Utils\ImageManger;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('frontend.dashboard.setting', compact('user'));
    }

    public function update(SettingRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        unset($data['image']);
        $user->update($data);
        ImageManger::uploadImages($request, null, $user);
        return redirect()->route('frontend.dashboard.setting')->with('Success', 'Profile Updated Successfully!');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return  redirect('/account/setting')->with('error', 'Password dose not match !');
        }
        $user->update(['password' => $request->password]);
        return redirect('/account/setting')->with('Success', 'Your Password Changed Successfully!');
    }

}
