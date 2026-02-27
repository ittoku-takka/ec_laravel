<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>商品編集 - 管理者パネル</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#eaeded] font-sans antialiased flex">
    {{-- サイドバーは共通のため省略（indexと同じものを入れてください） --}}

    <div class="flex-grow flex flex-col h-screen overflow-y-auto">
        <header class="bg-[#131921] text-white h-[60px] px-6 flex items-center justify-between">
            <div class="text-sm font-bold text-white">管理者パネル › 商品を編集する</div>
        </header>

        <main class="p-8 flex justify-center">
            <div class="max-w-2xl w-full bg-white shadow-sm border border-gray-300 rounded-md p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">商品を編集する</h1>
                <form action="{{ route('item.update', $item->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf
                    {{-- 注：ルート設定に合わせて @method('PATCH') は不要 --}}

                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">商品名</label>
                        <input type="text" name="title" value="{{ old('title', $item->title) }}" required
                            class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm focus:ring-1 focus:ring-[#e77600] outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">カテゴリ</label>
                        <select name="category" required
                            class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm bg-gray-50 outline-none">
                            <option value="ペン" {{ old('category', $item->category) == 'ペン' ? 'selected' : '' }}>ペン
                            </option>
                            <option value="シャープペン" {{ old('category', $item->category) == 'シャープペン' ? 'selected' : '' }}>
                                シャープペン</option>
                            <option value="ノート" {{ old('category', $item->category) == 'ノート' ? 'selected' : '' }}>ノート
                            </option>
                            <option value="消しゴム" {{ old('category', $item->category) == '消しゴム' ? 'selected' : '' }}>消しゴム
                            </option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-1 text-gray-700">価格（円）</label>
                            <input type="number" name="price" value="{{ old('price', $item->price) }}" required
                                class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1 text-gray-700">在庫数</label>
                            <input type="number" name="stock" value="{{ old('stock', $item->stock) }}" required
                                class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">商品説明</label>
                        <textarea name="description" rows="5"
                            class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm focus:ring-1 focus:ring-[#e77600] outline-none">{{ old('description', $item->description) }}</textarea>
                    </div>

                    <div class="bg-gray-50 p-4 border border-dashed border-gray-300">
                        <label class="block text-sm font-bold mb-2 text-gray-700 text-xs">商品画像</label>
                        @if($item->image1)
                            <img src="{{ asset('storage/' . $item->image1) }}"
                                class="h-20 w-20 object-contain border mb-2 bg-white">
                        @endif
                        <input type="file" name="image1" class="text-xs">
                    </div>

                    <div class="pt-6 flex items-center space-x-6 border-t mt-4">
                        <button type="submit"
                            class="bg-[#ffd814] hover:bg-[#f7ca00] border border-[#fcd200] text-black px-12 py-2.5 rounded-md font-bold shadow-sm transition text-sm">変更を保存</button>
                        <a href="{{ route('item.index', ['admin' => 'true']) }}"
                            class="text-sm text-blue-600 hover:underline">戻る</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>