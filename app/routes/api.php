<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserVisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function() {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => 'CheckAuthToken'], function () {
        Route::post('profile/update', [UserController::class, 'profileUpdate'])->name('profile.update');
        Route::get('post', [PostController::class, 'index'])->name('posts');
        Route::get('post/show/{post}', [PostController::class, 'show'])->name('post.show');
        Route::get('post/visited/', [UserVisitController::class, 'index'])->name('post.visit');
    });
});






