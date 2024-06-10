<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;

// make it to be conflect
// Hello Welcome to merge conflict
// Public route 
Route::get('/', function () {
    return view('welcome');
});


// Auth route 
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile/setting', [UserController::class,'profile']);

    // ajax upload image
    Route::post('/profile/upload', [UserController::class,'upload']);
});

// Auth route + is Admin user 
Route::middleware(['auth','verified', IsAdmin::class])->group(function () {
    Route::get('/admin', [DashboardController::class,'index']);
});
