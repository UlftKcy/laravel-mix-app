<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\SubOneCategoryController;
use App\Http\Controllers\SubTwoCategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\BasketController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [DashboardController::class, 'index'])->name('index');

// add category
Route::post('/store-main-category', [MainCategoryController::class, 'store']);
Route::post('/store-sub-one-category', [SubOneCategoryController::class, 'store']);
Route::post('/store-sub-two-category', [SubTwoCategoryController::class, 'store']);
Route::post('/fetch-main-category', [SubOneCategoryController::class, 'fetchMainCategory']);
Route::post('/fetch-sub-one-category', [SubTwoCategoryController::class, 'fetchSubOneCategory']);

// add product
Route::get('/product-edit/{id}', [ProductsController::class, 'edit'])->name('product.edit');
Route::post('/product-update', [ProductsController::class, 'update'])->name('product.update');
Route::get('/product-delete/{id}', [ProductsController::class, 'destroy'])->name('product.delete');
Route::post('/product-store', [ProductsController::class, 'store']);
Route::post('/fetch-main-categories', [ProductsController::class, 'fetchMainCategories']);
Route::post('/fetch-sub-one-categories', [ProductsController::class, 'fetchSubOneCategories']);
Route::post('/fetch-sub-two-categories', [ProductsController::class, 'fetchSubTwoCategories']);


// basket operations

Route::post('/add-product-to-basket',[BasketController::class,'store']);
