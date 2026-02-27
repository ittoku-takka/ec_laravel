<?php

namespace App\Http\Controllers\Other; // 設計図のディレクトリに合わせる

use App\Http\Controllers\Controller;
use App\Models\BuyHistory;
use Illuminate\Support\Facades\Auth;

class BuyHistoryController extends Controller
{
    // 13. 購入履歴 (buy_history)
    public function index()
    {
        // 全員分ではなく「ログインしている自分」の履歴だけを取得
        $orders = BuyHistory::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('other.buy_history', compact('orders'));
    }
    // 既存のindexメソッドの下に追加
    public function show($id)
    {
        // 自分の注文であること、かつIDが一致するものを取得
        $order = \App\Models\BuyHistory::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->findOrFail($id);

        return view('other.buy_history_detail', compact('order'));
    }
}