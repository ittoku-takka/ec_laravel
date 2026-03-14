<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemListController extends Controller
{
    /**
     * 在庫一覧画面を表示
     */
    public function index(Request $request)
    {
        // 1. 管理画面（admin/*）の場合は「自分の商品」だけに絞り込む
        if ($request->is('admin/*')) {
            $query = Item::where('user_id', Auth::id());
        } else {
            // ショップ画面（一般）の場合は「全員の商品」を表示
            $query = Item::query();
        }

        // 検索絞り込み
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // データの取得
        $items = $query->orderBy('created_at', 'desc')->get();

        // 管理画面の場合は、ユーザー一覧も取得して一緒に渡す
        if ($request->is('admin/*')) {
            $users = User::all();
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
     * 商品を保存する処理（新規登録）
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
        ]);

        // 画像の保存処理
        $imagePath = '';
        if ($request->hasFile('image1')) {
            $imagePath = $request->file('image1')->store('items', 'public');
        }

        Item::create([
            'user_id' => Auth::id(), // ログイン中のIDを紐付け
            'title' => $request->title,
            'category' => $request->category ?? '未分類',
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'description' => $request->description ?? '',
            'image1' => $imagePath,
        ]);

        return redirect()->route('item.index')->with('success', '商品を新しく登録しました！');
    }

    /**
     * 編集画面を表示
     */
    public function edit($id)
    {
        // 他人の商品を勝手に編集できないようにガード
        $item = Item::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('item.item_edit', compact('item'));
    }

    /**
     * 商品を更新する処理
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        // 他人の商品を勝手に更新できないようにガード
        $item = Item::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // 基本情報の更新
        $item->title = $request->title;
        $item->category = $request->category ?? '未分類';
        $item->price = $request->price;
        $item->stock = $request->stock ?? 0;
        $item->description = $request->description ?? '';

        // 画像の更新処理
        if ($request->hasFile('image1')) {
            // 古い画像があれば削除（オプション）
            if ($item->image1) {
                Storage::disk('public')->delete($item->image1);
            }
            $path = $request->file('image1')->store('items', 'public');
            $item->image1 = $path;
        }

        $item->save();

        return redirect()->route('item.index')->with('success', '商品を更新しました！');
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
                'user_id' => Auth::id(), // 取り込んだ人も「自分の商品」にする
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
        // 他人の商品を勝手に削除できないようにガード
        $item = Item::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // 画像も削除（クリーンアップ）
        if ($item->image1) {
            Storage::disk('public')->delete($item->image1);
        }

        $item->delete();
        return redirect()->route('item.index')->with('success', '商品を削除しました。');
    }
}