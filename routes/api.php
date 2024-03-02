<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', [productController::class, 'getproducts']);
Route::post('/addproduct', [productController::class, 'storeProduct']);
Route::put('/updateproduct/{id}', [productController::class, 'updateProduct']);
Route::delete('/deleteproduct/{id}', [productController::class, 'deleteProduct']);


