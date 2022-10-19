<?php

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
Route::group(['middleware' => 'auth'],function(){

    Route::get('/', [App\Http\Controllers\TableController::class, 'index'])->name('table.index');
    Route::get('/table/{table}', [App\Http\Controllers\TableController::class, 'show'])->name('table.show');
    
    Route::post('/table/{table_number}', [App\Http\Controllers\TableController::class, 'store'])->name('table.store');
    Route::delete('/table/{table}', [App\Http\Controllers\TableController::class, 'close'])->name('table.close');
    Route::post('/table/{table}/product/{product}', [App\Http\Controllers\TableController::class, 'addProduct'])->name('table.add-product');

    Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::get('/product/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');

    Route::get('report',[App\Http\Controllers\ReportController::class,'index'])->name('report.index');
    Route::get('report/table/{table}',[App\Http\Controllers\ReportController::class,'show'])->name('report.show');
});

include_once('auth.php');

