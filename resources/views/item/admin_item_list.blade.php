<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理者パネル - 販売品管理ツール</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#eaeded] font-sans antialiased flex overflow-hidden">

    {{-- 1. サイドバー (固定) --}}
    <div class="w-64 bg-[#232f3e] text-white h-screen shadow-xl flex flex-col flex-shrink-0">
        <div class="p-4 bg-[#131921] flex items-center justify-center">
            <h2 class="text-xl font-bold tracking-tighter italic">
                <span class="text-white">SHOP</span><span class="text-[#ff9900] ml-1">Admin</span>
            </h2>
        </div>
        <nav class="flex-grow mt-4 px-2">
            <p class="px-4 text-[10px] text-gray-400 mb-2 uppercase font-bold tracking-widest">商品管理</p>
            <a href="{{ route('item.index', ['admin' => 'true']) }}"
                class="flex items-center px-4 py-3 text-sm bg-[#37475a] border-l-4 border-[#ff9900] mb-1">
                <span class="mr-3">📦</span> 販売品一覧
            </a>
            <a href="{{ route('item.create') }}"
                class="flex items-center px-4 py-3 text-sm hover:bg-[#37475a] border-l-4 border-transparent hover:border-[#ff9900] transition-all mb-1">
                <span class="mr-3">➕</span> 新規商品登録
            </a>
        </nav>
        <div class="p-4 bg-[#19222d] text-xs border-t border-gray-800 text-center text-gray-400">
            管理者: <span class="text-[#ff9900] font-bold">{{ Auth::user()->name }}</span>
        </div>
    </div>

    {{-- 2. メインコンテンツ --}}
    <div class="flex-grow flex flex-col h-screen overflow-y-auto">
        <header class="bg-[#131921] text-white h-[60px] px-6 flex items-center justify-between shadow-md flex-shrink-0">
            <div class="text-sm font-bold">販売品一覧管理</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-700 hover:bg-gray-600 px-4 py-1.5 rounded font-bold text-xs transition">ログアウト</button>
            </form>
        </header>

        <main class="p-8">
            {{-- メッセージ表示 (成功/エラー) --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- 🚀 1. API個別取り込みエリア (練習用) --}}
            <div class="bg-blue-600 p-6 rounded-lg shadow-md mb-8">
                <form action="{{ route('item.import.single') }}" method="POST" class="flex items-end gap-4">
                    @csrf
                    <div class="flex-grow">
                        <label class="block text-white text-sm font-bold mb-2 uppercase tracking-wider">
                            ✨ APIから1品指定して取り込む (練習用)
                        </label>
                        <input type="number" name="item_code" placeholder="1 〜 20 の数字を入力してください"
                            class="w-full px-4 py-2.5 rounded border-none shadow-inner outline-none focus:ring-4 focus:ring-yellow-400 transition"
                            required min="1" max="20">
                    </div>
                    <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 text-black px-10 py-2.5 rounded font-extrabold shadow-lg transition transform active:scale-95 whitespace-nowrap">
                        この商品をGET
                    </button>
                </form>
                <p class="text-blue-100 text-[11px] mt-3 italic flex items-center">
                    <span class="mr-1">ℹ️</span> FakeStoreAPIのIDを指定して、商品を1件ずつデータベースへ登録する練習ができます。
                </p>
            </div>

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-extrabold text-gray-800">📦 登録済み商品一覧</h1>
                <a href="{{ route('item.create') }}"
                    class="bg-[#ffd814] hover:bg-[#f7ca00] border border-[#fcd200] text-black px-6 py-2 rounded-md font-bold shadow-sm text-sm transition transform active:scale-95">
                    ＋ 新規商品を追加
                </a>
            </div>

            {{-- 🔍 2. 検索・フィルタバー --}}
            <div class="bg-white p-5 rounded-lg border border-gray-300 shadow-sm mb-8">
                <form action="{{ route('item.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <input type="hidden" name="admin" value="true">

                    <div class="flex-grow min-w-[250px]">
                        <label
                            class="block text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-widest">キーワード検索</label>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で絞り込み..."
                            class="w-full px-3 py-2 border border-gray-400 rounded-sm text-sm focus:ring-1 focus:ring-[#e77600] outline-none shadow-inner">
                    </div>

                    <div class="w-56">
                        <label
                            class="block text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-widest">カテゴリ絞り込み</label>
                        <select name="category"
                            class="w-full border border-gray-400 rounded-sm px-3 py-2 text-sm bg-gray-50 outline-none focus:ring-1 focus:ring-[#e77600]">
                            <option value="">すべて</option>
                            <option value="ペン" {{ request('category') == 'ペン' ? 'selected' : '' }}>ペン</option>
                            <option value="シャープペン" {{ request('category') == 'シャープペン' ? 'selected' : '' }}>シャープペン</option>
                            <option value="ノート" {{ request('category') == 'ノート' ? 'selected' : '' }}>ノート</option>
                            <option value="消しゴム" {{ request('category') == '消しゴム' ? 'selected' : '' }}>消しゴム</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-[#232f3e] text-white px-8 py-2 rounded-md text-sm font-bold hover:bg-[#37475a] transition shadow-sm">
                            検索
                        </button>
                        @if(request('keyword') || request('category'))
                            <a href="{{ route('item.index', ['admin' => 'true']) }}"
                                class="px-2 py-2 text-sm text-blue-600 hover:underline flex items-center">
                                クリア
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- 🛍 3. 商品グリッド --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($items as $item)
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-lg transition group">
                        <div
                            class="w-full aspect-square bg-white flex items-center justify-center p-6 border-b border-gray-50 relative overflow-hidden">
                            {{-- ★画像表示：URL(http)かファイルパスか自動判定 --}}
                            <img src="{{ \Illuminate\Support\Str::startsWith($item->image1, 'http') ? $item->image1 : asset('storage/' . $item->image1) }}"
                                class="object-contain w-full h-full transition transform group-hover:scale-110 duration-300">
                        </div>

                        <div class="p-4 flex-grow">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[10px] text-gray-400 font-mono italic">#{{ $item->id }}</span>
                                <span
                                    class="text-[10px] font-bold px-2 py-0.5 bg-gray-100 text-gray-600 rounded uppercase tracking-tighter">{{ $item->category }}</span>
                            </div>
                            <h3 class="text-sm font-bold text-gray-800 line-clamp-2 h-10 mb-2 leading-snug">
                                {{ $item->title }}</h3>
                            <p class="text-2xl font-bold text-[#B12704]">¥{{ number_format($item->price) }}</p>
                            <p class="text-xs text-gray-500 mt-2">
                                在庫状況: <span
                                    class="font-bold {{ $item->stock <= 3 ? 'text-red-600' : 'text-gray-700' }}">{{ $item->stock }}</span>
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 grid grid-cols-2 gap-2 border-t border-gray-100">
                            <a href="{{ route('item.edit', $item->id) }}"
                                class="text-center bg-white border border-gray-300 py-2 rounded text-sm font-bold hover:bg-gray-100 transition shadow-sm">編集</a>
                            <form action="{{ route('item.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('この商品を削除してよろしいですか？')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-white border border-gray-300 py-2 rounded text-sm font-bold text-red-600 hover:bg-red-50 transition shadow-sm">削除</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white border border-dashed border-gray-300 rounded-lg">
                        <p class="text-gray-400">該当する商品が見つかりません。上の青いフォームから取り込んでみましょう！</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>

</html>