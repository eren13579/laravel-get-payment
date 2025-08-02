<?php

use App\Http\Controllers\GetPaymentController;
use App\Http\Controllers\PaymentStatus;
use App\Http\Controllers\TransfertPaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
});

Route::post('/depot', [GetPaymentController::class, 'sendDepot'])->name('get-payment.depot');

Route::post('/retrait', [TransfertPaymentController::class, 'transfertPayment'])->name('transfert-payment.retrait');

Route::get('/depot/verify', [PaymentStatus::class, 'handleReturnUrl'])->name('get-payment.success');

Route::get('/', [GetPaymentController::class, 'index'])->name('transaction-payment');

