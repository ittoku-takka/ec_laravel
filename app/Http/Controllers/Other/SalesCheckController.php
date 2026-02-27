<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use App\Models\BuyHistory;

class SalesCheckController extends Controller
{
    /**
     * 売上確認画面の表示
     */
    public function index()
    {
        // すべての購入履歴を取得（新しい順）
        $sales = BuyHistory::orderBy('created_at', 'desc')->get();

        // 合計売上金額の計算
        $totalSales = 0;
        foreach ($sales as $sale) {
            $totalSales += $sale->price * $sale->quantity;
        }

        // resources/views/other/sales_check.blade.php を表示
        return view('other.sales_check', compact('sales', 'totalSales'));
    }
}