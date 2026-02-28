<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Item\ItemListController;
use App\Http\Controllers\Buy\CartController;
use App\Http\Controllers\Other\BuyHistoryController;
use App\Http\Controllers\Other\SalesCheckController;
use App\Http\Controllers\User\UserListController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\LoginController;

// ホーム：ショップ画面へリダイレクト
Route::get('/', function () {
    return redirect()->route('item_list');
});

// --- 【認証】 ---
Auth::routes();
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');

// --- 【一般ショップ：誰でもOK】 ---
Route::get('/item_list', [ItemListController::class, 'index'])->name('item_list');
Route::get('/item_detail/{id}', [ItemListController::class, 'show'])->name('item_detail');

// --- 【購入者メニュー：ログイン必須】 ---
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'destroy'])->name('cart.remove');
    Route::get('/buy_history', [BuyHistoryController::class, 'index'])->name('buy_history');
});

// --- 【管理者（セラー）専用：role=1のみ】 ---
Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    // 自分の在庫管理
    Route::get('/item_list', [ItemListController::class, 'index'])->name('item.index');
    Route::get('/item_register', [ItemListController::class, 'create'])->name('item.create');
    Route::post('/item_store', [ItemListController::class, 'store'])->name('item.store');
    Route::get('/item_edit/{id}', [ItemListController::class, 'edit'])->name('item.edit');
    Route::post('/item_update/{id}', [ItemListController::class, 'update'])->name('item.update');
    Route::delete('/item_destroy/{id}', [ItemListController::class, 'destroy'])->name('item.destroy');

    // ★ユーザー(role=0)の一覧管理
    Route::get('/user_list', [UserListController::class, 'index'])->name('user_list');
    Route::get('/sales_check', [SalesCheckController::class, 'index'])->name('sales_check');
    Route::get('/user_edit/{id}', [UserListController::class, 'edit'])->name('user.edit');
    Route::post('/user_update/{id}', [UserListController::class, 'update'])->name('user.update');

    // API取り込み（URL対応版）
    // ★ ここを Blade と同じ名前に合わせます
    Route::post('/items/import-single', [ItemListController::class, 'importSingle'])->name('item.importSingle');
});