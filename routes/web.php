<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('/admin')->group(function () {

    // Orders

    Route::get('/', function () {
        return view('admin.orders');
    })->name('admin');

    Route::get('/order/{id}', [OrderController::class, 'index'])->name('admin.order');


    // products

    Route::get('/products', [ProductController::class, 'index'])->name('admin.producs');

});


