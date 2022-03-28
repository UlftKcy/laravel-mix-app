<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\SubOneCategoryController;
use App\Http\Controllers\SubTwoCategoryController;

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

Route::post('/store', [MainCategoryController::class, 'store']);
Route::post('/store', [SubOneCategoryController::class, 'store']);
Route::post('/store', [SubTwoCategoryController::class, 'store']);
