<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Frontend\SettingRequest;
use App\Http\Requests\UpdatePasswordRequest;

/**
 * Class AccountController
 *
 * Handles user account management operations for the API, such as updating profile information and changing passwords.
 *
 * Main responsibilities:
 * - Update authenticated user's profile data (with image upload support)
 * - Update authenticated user's password after validating the current password
 *
 * All methods are protected by authentication middleware and use route model binding for user resolution.
 *
 * @package App\Http\Controllers\Api\Account
 */
class AccountController extends Controller
{
    public function updateAccount(SettingRequest $request, User $user)
    {
        if (auth()->user()->id != $user->id) {
            return apiResponse(403, 'You are not allowed to update this client.');
        }

        $user->update($request->except('image'));

        ImageManger::uploadImages($request, null, $user);
        return apiResponse(200, 'Profile Data Updated Successfully');
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        if (auth()->id() != $user->id) {
            return apiResponse(403, 'You are not allowed to update this password.');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return apiResponse(400, 'Password dose not match');
        }

        $user->update([
            'password' => $request->password,
        ]);
        return apiResponse(200, 'Pssword Update Successfully');
    }
}
