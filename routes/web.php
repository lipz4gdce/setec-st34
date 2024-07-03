<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\CheckDueDateAndBalance;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionCheckoutController;
use Laravel\Cashier\Http\Controllers\WebhookController;

// make it to be conflect
// Hello Welcome to merge conflict
// Public route
// Auth route
// Route::post('/stripe/webhook', [SubscriptionCheckoutController::class, 'handleWebhook']);

Route::get('/checksub', [SubscriptionCheckoutController::class, 'checksub'])->name('checksub');


Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/billing', [SubscriptionCheckoutController::class, 'index'])->name('billing');

    Route::get('/due-date-with-no-balance', [SubscriptionCheckoutController::class, 'cancelIfDueDateAndUserBalanceIs0'])->name('cancelIfDueDateAndUserBalanceIs0');

    Route::get('/profile/setting', [UserController::class,'profile']);

    // ajax upload image
    Route::post('/profile/upload', [UserController::class,'upload']);

    Route::get('/payment-method/{plan}', [SubscriptionCheckoutController::class, 'getPaymentMethodId'])
    ->name('payment-method');

    Route::post('/subscription-checkout/{plan}', [SubscriptionCheckoutController::class, 'checkout'])
    ->name('subscription-checkout');

    Route::get('/success', [SubscriptionCheckoutController::class, 'success'])->name('success');
    Route::get('/fail', [SubscriptionCheckoutController::class, 'fail'])->name('fail');



    Route::post('/subscription-cancel', [SubscriptionCheckoutController::class, 'cancelSubscription'])->name('subscription-cancel');

    // Route::post('/stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');
    // Route::post('stripe/webhook', 'StripeWebhookController@handleWebhook')->name('cashier.webhook');
});

// Auth route + is Admin user
Route::middleware(['auth','verified',CheckDueDateAndBalance::class])->group(function () {
    Route::get('/subscribed', function () {
        return view('user.subscribed');
    })->name('subscribed');
    // Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleSubscriptionCancellation']);
});

Route::middleware(['auth','verified', IsAdmin::class])->group(function () {
    Route::get('/admin', [DashboardController::class,'index']);
});




