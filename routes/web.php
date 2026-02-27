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



// ホーム
Route::get('/', function () {
    return redirect()->route('item_list');
});

// --- 【認証ルート】 ---
Auth::routes(); // 一般ユーザー用 (/login)

// 管理者専用ログイン画面
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');

// --- 【誰でも見れるページ】 ---
Route::get('/item_list', [ItemListController::class, 'index'])->name('item_list');
Route::get('/item_detail/{id}', [ItemListController::class, 'show'])->name('item_detail');

// --- 【一般ユーザー用：ログイン必須】 ---
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');

    // ★ここを修正：{id}を消して、POSTで受け取るように変更（Bladeのフォームに合わせる）
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'destroy'])->name('cart.remove');

    Route::get('/billing_select', [CartController::class, 'billing_select'])->name('billing_select');
    Route::get('/order_check', [CartController::class, 'order_check'])->name('order_check');
    Route::post('/order_complete', [CartController::class, 'checkout'])->name('order_complete');

    Route::get('/buy_history', [BuyHistoryController::class, 'index'])->name('buy_history');
    Route::get('/buy_history/{id}', [BuyHistoryController::class, 'show'])->name('buy_history_detail');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// --- 【管理者専用：ログイン必須 ＋ 管理者権限(can:admin)】 ---
Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/item_list', [ItemListController::class, 'index'])->name('item.index');
    Route::get('/item_register', [ItemListController::class, 'create'])->name('item.create');
    Route::post('/item_store', [ItemListController::class, 'store'])->name('item.store');
    Route::get('/item_edit/{id}', [ItemListController::class, 'edit'])->name('item.edit');
    Route::post('/item_update/{id}', [ItemListController::class, 'update'])->name('item.update');
    Route::delete('/item_destroy/{id}', [ItemListController::class, 'destroy'])->name('item.destroy');

    Route::get('/user_list', [UserListController::class, 'index'])->name('user_list');
    Route::get('/sales_check', [SalesCheckController::class, 'index'])->name('sales_check');
});

// fakeAPI
Route::post('/items/import', [ItemListController::class, 'importFake'])->name('item.import');
Route::post('/items/import-single', [ItemListController::class, 'importSingle'])->name('item.import.single');