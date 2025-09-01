<?php

use App\Http\Controllers\api\LoginApiController;
use App\Http\Controllers\api\ProjectController;
use App\Http\Controllers\api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//
Route::post('/register', [LoginApiController::class,'register']);
Route::post('/login', [LoginApiController::class,'login']);

Route::middleware(['auth:sanctum','throttle:60,1','role:admin'])->group(function(){
// Projects
    Route::prefix('/projects')->group(function (){
        Route::get('/',[ProjectController::class,'index']);
        Route::post('/store',[ProjectController::class,'store']);
        Route::get('/show/{project}',[ProjectController::class,'show']);
        Route::put('/update/{project}',[ProjectController::class,'update']);
        Route::delete('/delete/{project}',[ProjectController::class,'destroy']);
    });

//task 1
    Route::prefix('/tasks')->group(function (){
        Route::get('/{project}',[TaskController::class,'index']);
        Route::post('/store/{project}',[TaskController::class,'store']);
        Route::get('/show/{task}',[TaskController::class,'show']);
        Route::put('/update/{task}',[TaskController::class,'update']);
        Route::delete('/delete/{task}',[TaskController::class,'destroy']);
    });
});
