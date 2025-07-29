<?php

namespace App\Http\Controllers\Api\Auth;

use App\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Notifications\SendOtpVerifyUserEmail;
use App\Utils\ImageManger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

/**
 * Class RegisterController
 *
 * Handles user registration requests via API.
 *
 * @package App\Http\Controllers\Api\Auth
 */
class RegisterController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  UserRequest  $request  Validated user input request.
     * @return JsonResponse
     */
    public function register(UserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = $this->createUser($request);

            // Handle optional image upload
            if ($request->hasFile('image')) {
                ImageManger::uploadImages($request, null, $user);
            }
            $user->notify(new SendOtpVerifyUserEmail());
            DB::commit();

            return $this->apiResponse(
                '200',
                'User created successfully',
                ['token' => $user->createToken('MyApp')->plainTextToken]
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration Error: ' . $e->getMessage());

            return $this->apiResponse('500', 'Internal Server Error');
        }
    }

    /**
     * Create a new user instance with hashed password.
     *
     * @param  UserRequest  $request
     * @return User
     */
    protected function createUser(UserRequest $request): User
    {
        return User::create([
            'name'     => $request->post('name'),
            'username' => $request->post('username'),
            'email'    => $request->post('email'),
            'phone'    => $request->post('phone'),
            'country'  => $request->post('country'),
            'city'     => $request->post('city'),
            'street'   => $request->post('street'),
            'password' => $request->post('password'),
        ]);
    }
}
