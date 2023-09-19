<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController::class, 'list']);

Route::get('/product_checkout/{id}',[ProductController::class, 'productCheckout']);

Route::post('/makePayment',[ProductController::class, 'makePayment']);
Route::get('/thankyou',function() {
    return view('products.thankyou');
});