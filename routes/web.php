<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MemberMiddleware;
use App\Models\Item;

Route::get('/profile', [AccountController::class, 'index'])->middleware(AdminMiddleware::class);
Route::get('/banner', [BannerController::class, 'index'])->middleware(AdminMiddleware::class);
Route::get('/payment', [PaymentController::class, 'index'])->middleware(AdminMiddleware::class);
Route::get('/revenue', [TransactionController::class, 'revenue'])->middleware(AdminMiddleware::class);
Route::get('/transaksi', [TransactionController::class, 'nota'])->middleware(AdminMiddleware::class);
Route::get('/nota/{id_transaksi}', [TransactionController::class, 'nota'])->name('nota');
Route::get('/cari-pesanan', [TransactionController::class,'getNota'])->name('search.transaction');
Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/', [GameController::class, 'index']);
Route::post('/', [GameController::class, 'upload']);
Route::get('/{game:slug}', [GameController::class, 'detail']);
Route::post('/{game:slug}', [TransactionController::class, 'store'])->middleware(MemberMiddleware::class);