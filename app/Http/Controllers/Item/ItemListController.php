<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User; // ★これを追加しました
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ItemListController extends Controller
{
    /**
     * 在庫一覧画面を表示
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // 検索絞り込み
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // すべての在庫を取得
        $items = $query->orderBy('created_at', 'desc')->get();

        // 管理画面の場合は、ユーザー一覧も取得して一緒に渡す
        if ($request->is('admin/*')) {
            $users = User::all(); // ユーザーデータを取得
            return view('item.admin_item_list', compact('items', 'users'));
        }

        return view('item.item_list', compact('items'));
    }

    /**
     * 新規登録画面を表示
     */
    public function create()
    {
        return view('item.item_register');
    }

    /**
     * 商品を保存する処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
        ]);

        Item::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category ?? '未分類',
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'description' => $request->description ?? '',
            'image1' => $request->image1 ?? '',
        ]);

        return redirect()->route('item.index')->with('success', '商品を新しく登録しました！');
    }

    /**
     * APIから1件取り込む機能
     */
    public function importSingle(Request $request)
    {
        $id = $request->item_code;
        $response = Http::get("https://fakestoreapi.com/products/{$id}");

        if ($response->successful() && $response->json()) {
            $product = $response->json();
            Item::create([
                'user_id' => Auth::id(),
                'title' => $product['title'],
                'category' => 'ペン',
                'price' => $product['price'] * 150,
                'stock' => rand(5, 50),
                'description' => $product['description'],
                'image1' => $product['image'],
            ]);
            return redirect()->route('item.index')->with('success', "商品ID:{$id} を取り込みました！");
        }
        return back()->with('error', '取得に失敗しました。');
    }

    /**
     * 削除処理
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('item.index')->with('success', '商品を削除しました。');
    }

    /**
     * 編集画面を表示
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('item.item_edit', compact('item'));
    }
} // ← ここでクラスがしっかり閉じています！