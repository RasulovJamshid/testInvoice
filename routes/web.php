<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();


Route::middleware('auth')->group(function(){
    Route::get('/', function () {
        return view('dashboard');
    })->middleware('usercheck')->name('dashboard');
    Route::get('/manager',[InvoiceController::class,'invoices'])->middleware('manager')->name('manager');
    Route::get('/invoice/{invoice_id}/edit',[InvoiceController::class,'check'])->whereNumber('invoice_id')->name('checkinvoice');
    Route::post('/invoice',[InvoiceController::class,'store'])->name("invoice");
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
