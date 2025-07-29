<?php

use App\Http\Controllers\Api\Account\AccountController;
use App\Http\Controllers\Api\Account\CommentController;
use App\Http\Controllers\Api\Account\NotificationController;
use App\Http\Controllers\Api\Account\PostController;
use App\Http\Controllers\Api\Account\SettingController as AccountSettingController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\Password\ForogtPasswordController;
use App\Http\Controllers\Api\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\RelatedNewsController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Middleware\CheckEmailVerifyApi;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/login', [LoginController::class, 'login'])->middleware('throttle:login');
Route::post('/auth/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

// Verify Email
Route::middleware('auth:sanctum')->controller(VerifyEmailController::class)->group(function () {
    Route::post('auth/email/verify', 'verifyEmail');
    Route::get('auth/email/verify', 'sendOtpAgain');
});

// reset  Password
Route::post('password/send-otp', [ForogtPasswordController::class, 'sendOtp']);
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword']);

// account Routes
Route::middleware(['auth:sanctum' , CheckUserStatus::class,CheckEmailVerifyApi::class])->prefix('account/')->controller(  AccountController::class)->group(function () {
    Route::get('user', function () {
        return UserResource::make(auth()->user());
    });
    //user profile
    Route::post('profile/{user:id}', 'updateAccount');
    Route::post('update-password/{user:id}', 'updatePassword');
    //user posts
    Route::apiResource('posts', PostController::class);
    Route::post('posts/{post:id}', [PostController::class,'update']);
    //user post comments
    Route::get('posts/{post:id}/comments', [CommentController::class,'index']);
    Route::post('posts/{post:id}/comment/store', [CommentController::class,'store']);
    // user notifcation
    Route::get('notifications' , [NotificationController::class , 'getNotifications']);
    Route::get('notifications/read/{id}' , [NotificationController::class , 'readNotifications']);
});



// Home Page Routes
Route::controller(MainController::class)->group(function () {
    Route::get('posts/{keyword?}',           'getPosts');
    Route::post('posts/search/{keyword?}',    'searchPosts');
    Route::get('posts/show/{slug}',          'showPost');
    Route::get('posts/comments/{slug}',      'getPostComments');
});

//  Categories Routes
Route::controller(CategoryController::class)->group(function () {
    Route::get('categories',             'getCategories');
    Route::get('categories/{category:slug}/posts', 'getCategoryPosts');
});

//  Contact Routes
Route::post('contacts/store', [ContactController::class, 'storeContact'])->middleware('throttle:contact');

//  RelatedSites Routes
Route::get('related-sites', RelatedNewsController::class);

//   Settings Routes
Route::get('settings', [SettingController::class, 'getSettings']);
