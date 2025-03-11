<?php


use Illuminate\Support\Facades\Route;

Route::prefix('bankpayment')->middleware('auth')->group(function () {
    Route::resource('bankPayment', 'BankPaymentController')->middleware('RoutePermissionCheck:bankPayment.index');
    Route::post('settings', 'BankPaymentController@settings')->name('bankPayment.settings');
});
