<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController; 

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
    //return view('welcome');
    return 'hey obaid here';

});


Route::get('/products', [productController::class, 'index'])->name('products');
Route::get('/createproduct', [productController::class, 'create'])->name('products.create');
Route::post('/storeproduct', [productController::class, 'store'])->name('products.store');
Route::get('/editproduct/{id}', [productController::class, 'edit'])->name('products.edit');
Route::patch('/updateproduct/{id}', [productController::class, 'update'])->name('products.update');
Route::delete('/delete/{id}', [productController::class, 'destroy'])->name('products.destroy');





