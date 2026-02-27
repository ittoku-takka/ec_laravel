<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // API通信用
use Illuminate\Support\Str;          // 文字列判定用

class ItemListController extends Controller
{
    // 商品一覧（既存のまま）
    public function index(Request $request)
    {
        $query = Item::query();
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $items = $query->orderBy('created_at', 'desc')->get();

        if ($request->query('admin') == 'true' || $request->routeIs('item.index')) {
            return view('item.admin_item_list', compact('items'));
        }
        return view('item.item_list', compact('items'));
    }

    // ★追加：フェイクAPIから「ID指定」で1件取り込む
    public function importSingle(Request $request)
    {
        $id = $request->item_code; // 画面の入力欄から来る数字（1〜20）

        // フェイクAPIにリクエスト
        $response = Http::get("https://fakestoreapi.com/products/{$id}");

        if ($response->successful() && $response->json()) {
            $product = $response->json();

            // データベースに保存
            Item::create([
                'title' => $product['title'],
                'category' => 'ペン', // カテゴリは一旦固定
                'price' => $product['price'] * 150, // 円っぽく換算
                'stock' => rand(1, 50),
                'description' => $product['description'],
                'image1' => $product['image'], // APIの画像URLを保存
            ]);

            return redirect()->route('item.index', ['admin' => 'true'])
                ->with('success', "商品ID:{$id} を取り込みました！");
        }

        return back()->with('error', '商品が見つかりませんでした。1〜20の数字を入れてください。');
    }

    // 登録・編集・削除などはそのまま
    public function create()
    {
        return view('item.item_register');
    }
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('item.item_edit', compact('item'));
    }
    public function store(Request $request)
    { /* 既存のコード */
    }
    public function update(Request $request, $id)
    { /* 既存のコード */
    }
    public function destroy($id)
    {
        Item::findOrFail($id)->delete();
        return back();
    }
}