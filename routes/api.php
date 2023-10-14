<?php

use App\Http\Controllers\productsController;
use App\Models\product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/create/product', [productsController::class, 'CreateProduct'])->name('CreateProduct');
Route::get('/show/product', [productsController::class, 'ShowUser'])->name('ShowUser');
Route::get('/delete/product/{id}', [productsController::class, 'DeleteProduct'])->name('DeleteProduct');
Route::get('/edit/product/{id}', [productsController::class, 'EditProduct'])->name('EditProduct');
Route::post('/update/product/{id}', [productsController::class, 'UpdateProduct'])->name('UpdateProduct');
