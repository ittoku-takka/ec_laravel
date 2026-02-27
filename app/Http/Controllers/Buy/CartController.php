<?php

namespace App\Http\Controllers\Buy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // カート一覧表示
    public function index()
    {
        $cart_items = Cart::where('user_id', Auth::id())->with('item')->get();
        return view('cart.cart_list', compact('cart_items'));
    }

    // カートに商品を追加
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $item_id = $request->item_id;
        $quantity = $request->quantity ?? 1;

        // 同じ商品がすでにカートにあるか確認
        $cartItem = Cart::where('user_id', $user_id)->where('item_id', $item_id)->first();

        if ($cartItem) {
            // あれば数量を加算（ひたすら積み上がるのを防ぐ）
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // なければ新規作成
            Cart::create([
                'user_id' => $user_id,
                'item_id' => $item_id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart');
    }

    // 数量更新（ルートから{id}を消したので、$requestからIDを取る）
    public function update(Request $request)
    {
        $cartItem = Cart::findOrFail($request->cart_item_id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', '数量を更新しました');
    }

    // 削除（ルートから{id}を消したので、$requestからIDを取る）
    public function destroy(Request $request)
    {
        $cartItem = Cart::findOrFail($request->cart_item_id);
        $cartItem->delete();

        return back()->with('success', '商品を削除しました');
    }

    // 決済・チェックアウト処理（簡易版）
    public function checkout()
    {
        // 本来はここで注文テーブルに保存するが、まずはカートを空にする
        Cart::where('user_id', Auth::id())->delete();
        return view('cart.order_complete'); // 完了画面へ
    }
}