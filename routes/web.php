<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;



Route::get('/',[PaymentController::class,'index'])->name('home');
Route::get('/payments/create',[PaymentController::class,'create'])->name('payment.create');
Route::get('/payments/{payment}/accept',[PaymentController::class,'accept'])->name('payment.accept');
Route::get('/payments/{payment}/reject',[PaymentController::class,'reject'])->name('payment.reject');
Route::get('/payments/{payment}/pay',[PaymentController::class,'pay'])->name('payment.pay');
Route::get('/payments/{payment}/download',[PaymentController::class,'download'])->name('payment.download');
Route::post('/payments',[PaymentController::class,'store'])->name('payment.store');

