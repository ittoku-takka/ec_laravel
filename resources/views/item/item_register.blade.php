<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>商品登録 - 管理者パネル</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#eaeded] font-sans antialiased flex overflow-hidden">
    {{-- メインのみ抜粋（構造はeditと同じ） --}}
    <div class="flex-grow flex flex-col h-screen overflow-y-auto">
        <header class="bg-[#131921] h-[60px] px-6 flex items-center">
            <div class="text-sm font-bold text-white">管理者パネル › 新規商品登録</div>
        </header>
        <main class="p-8 flex justify-center">
            <div class="max-w-2xl w-full bg-white shadow-sm border border-gray-300 rounded-md p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">新しい商品を登録する</h1>
                <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">商品名</label>
                        <input type="text" name="title" required
                            class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm outline-none focus:ring-1 focus:ring-[#e77600]">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">カテゴリ</label>
                        <select name="category" required
                            class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm bg-gray-50 outline-none">
                            <option value="">選択してください</option>
                            <option value="ペン">ペン</option>
                            <option value="シャープペン">シャープペン</option>
                            <option value="ノート">ノート</option>
                            <option value="消しゴム">消しゴム</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-1 text-gray-700">価格（円）</label>
                            <input type="number" name="price" required
                                class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1 text-gray-700">在庫数</label>
                            <input type="number" name="stock" required
                                class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">商品説明</label>
                        <textarea name="description" rows="5"
                            class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm outline-none focus:ring-1 focus:ring-[#e77600]"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">商品画像</label>
                        <input type="file" name="image1" class="text-xs">
                    </div>
                    <div class="pt-6 flex items-center space-x-6 border-t mt-4">
                        <button type="submit"
                            class="bg-[#ffd814] hover:bg-[#f7ca00] border border-[#fcd200] text-black px-12 py-2.5 rounded-md font-bold shadow-sm transition text-sm">商品を登録する</button>
                        <a href="{{ route('item.index', ['admin' => 'true']) }}"
                            class="text-sm text-blue-600 hover:underline">キャンセル</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>