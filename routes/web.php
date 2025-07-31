<?php

use App\Http\Controllers\GetPaymentController;
use App\Models\PaysAfricain;
use Illuminate\Support\Facades\Route;

// Route::post('depot', [GetPaymentController::class, 'depot'])->name('get-payment.depot');

Route::get('/', [GetPaymentController::class, 'index']);

Route::get('/get-country-data/{id}', function(string $id) {
    $countries = PaysAfricain::find($id);

    if (!$countries) {
        return response()->json(['error' => 'Country not found'], 404);
    }

    return response()->json([
        'indicatif' => $countries->indicatif,
        'currency_id' => $countries->devise_id,
    ]);
    
})->name('get.country.data');
