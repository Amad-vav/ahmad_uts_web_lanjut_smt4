<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\MosqueController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [MosqueController::class, 'index']);
Route::get('/mosque/{id}', [MosqueController::class, 'show']);
Route::get('/api/mosques', [MosqueController::class, 'apiList']);
Route::get('/mosque/{id}/donate', [DonationController::class, 'create'])->name('mosque.donate');

Route::post('/donate', [DonationController::class, 'store']);
Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
Route::get('/donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
Route::put('/donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
Route::post('/donate/checkout', [PaymentController::class, 'checkout']);
Route::get('/donate/success', [PaymentController::class, 'success']);

// Stripe webhook endpoint (no CSRF)
Route::post('/stripe/webhook', [WebhookController::class, 'handle']);

// Admin area removed — admin controllers and views deleted per redesign.
