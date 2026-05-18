<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MosqueController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PaymentController;

// Public routes
Route::get('/', [MosqueController::class, 'index']);
Route::get('/mosque/{id}', [MosqueController::class, 'show']);
Route::get('/api/mosques', [MosqueController::class, 'apiList']);
Route::get('/mosque/{id}/donate', [DonationController::class, 'create'])->name('mosque.donate');

Route::post('/donate', [DonationController::class, 'store']);
Route::post('/donate/checkout', [PaymentController::class, 'checkout']);
Route::get('/donate/success', [PaymentController::class, 'success']);

// Stripe webhook endpoint (no CSRF)
Route::post('/stripe/webhook', [\App\Http\Controllers\WebhookController::class, 'handle']);

// Admin area removed — admin controllers and views deleted per redesign.
