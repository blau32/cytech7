<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

//Laravelがまとめて認証用のルートを作ってくれるショートカット
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 商品一覧画面へのルート
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品登録画面（GET）
Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');

// 商品登録処理（POST）
Route::post('/products/store', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');

// 商品編集画面（GET）
Route::get('/products/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');

// 商品更新処理（PUT）
Route::put('/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');

//商品削除処理（DELETE）
Route::delete('/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');

// 商品詳細画面（show）
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
