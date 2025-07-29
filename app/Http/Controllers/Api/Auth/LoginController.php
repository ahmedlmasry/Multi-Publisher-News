<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Class LoginController
 *
 * Handles user authentication for the API (login and logout).
 */
class LoginController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param  LoginUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {

        // RateLimiter::clear($request->ip());

        // if (RateLimiter::tooManyAttempts($request->ip(), 2)) {
        //     $time = RateLimiter::availableIn($request->ip());
        //     return apiResponse(429, 'Tow many attempts , try after : ' . $time . ' seconds');
        // }
        // RateLimiter::increment($request->ip());
        // $remain  = RateLimiter::remaining($request->ip(), 2);

        $user = User::whereEmail($request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('user_token')->plainTextToken;

            return $this->apiResponse(200, 'User Loged Successfully', ['token' => $token]);
        }
        return $this->apiResponse(401, 'Credensials dose not match');
    }


    /**
     * Log the user out (invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = Auth::guard('sanctum')->user();
        $user->currentAccessToken()->delete();
        return $this->apiResponse(200, 'Token Deleted Successfully!');
    }
}
