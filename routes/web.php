<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\Dashboard\NotificationController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\Dashboard\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsSubscriberController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::group(['as' => 'frontend.'], function () {
    Route::get('/home', HomeController::class)->name('index');
    Route::post('news-subscribe', NewsSubscriberController::class)->name('news.subscribe');
    Route::get('category/{category:slug}', CategoryController::class)->name('category.posts');

    Route::get('post/{post:slug}', [PostController::class, 'show'])->name('post.show');
    Route::get('post/{post:slug}/comment', [PostController::class, 'getAllComments'])->name('post.comment');
    Route::post('post/comment/store', [PostController::class, 'saveComment'])->name('comment.store');

    Route::controller(ContactController::class)->name('contact.')
        ->prefix('contact-us')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
        });
    Route::match(['get', 'post'], 'search', SearchController::class)->name('search');

    //  manage profile page
    Route::prefix('account/')->name('dashboard.')->middleware(['auth:web', 'verified'])->group(function () {

        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile', 'index')->name('profile');
            Route::post('post/store', 'storePost')->name('post.store');
            Route::delete('post/delete', 'deletePost')->name('post.delete');
            Route::get('post/get-comments/{id}', 'getComments')->name('post.getComments');

            Route::get('post/{slug}/edit', 'showEditForm')->name('post.edit');
            Route::put('post/update', 'updatePost')->name('post.update');
            Route::post('post/image/delete/{image_id}', 'deletePostImage')->name('post.image.delete');
        });
        // setting routes
        Route::prefix('setting')->controller(SettingController::class)->group(function () {
            Route::get('/', 'index')->name('setting');
            Route::post('/update', 'update')->name('setting.update');
            Route::post('/change-password', 'changePassword')->name('setting.changePassword');
        });
        // Notification Routes
        Route::prefix('notification')->controller(NotificationController::class)->group(function () {
            Route::get('/', 'index')->name('notifications.index');
            Route::get('/read-all', 'readAll')->name('notifications.readAll');
            Route::post('/delete', 'delete')->name('notifications.delete');
            Route::get('/delete-all', 'deleteAll')->name('notifications.deleteAll');
        });
    });

});

Route::prefix('email')->name('verification.')->controller(VerificationController::class)
    ->group(function () {
        Route::get('/verify', 'show')->name('notice');
        Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
        Route::post('/resend', 'resend')->name('resend');
    });

Auth::routes();

require __DIR__.'../admin.php';
