<?php

use Illuminate\Support\Facades\Route;
use RazorpayPlugin\Http\Controllers\RazorpayController;

Route::post('/razorpay/initiate', [RazorpayController::class, 'initiate']);
Route::post('/razorpay/verify', [RazorpayController::class, 'verify']);
Route::view('/razorpay/test', 'vendor.razorpay-plugin.payment-test');
