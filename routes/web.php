<?php

use App\Http\Controllers\CalculationController;


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('calculators')->group(function () {
    Route::get('/price-without-iva', [CalculationController::class, 'priceWithoutIVA'])->name('calculators.priceWithoutIVA');
    Route::get('/price-without-iva-with-tax', [CalculationController::class, 'priceWithoutIVAWithTax'])->name('calculators.priceWithoutIVAWithTax');
    Route::get('/price-with-iva', [CalculationController::class, 'priceWithIVA'])->name('calculators.priceWithIVA');

    Route::post('/calculate', [CalculationController::class, 'calculate'])->name('calculators.calculate');
    Route::get('/dashboard', [CalculationController::class, 'dashboard'])->name('dashboard');
    Route::delete('/calculations/{id}', [CalculationController::class, 'destroy'])->name('calculations.destroy');


});