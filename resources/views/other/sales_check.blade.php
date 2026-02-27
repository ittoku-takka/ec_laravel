<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>売上確認 - 管理者パネル</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#eaeded] font-sans antialiased flex overflow-hidden">

    {{-- 1. サイドバー (管理者専用デザイン) --}}
    <div class="w-64 bg-[#232f3e] text-white h-screen shadow-xl flex flex-col flex-shrink-0">
        <div class="p-4 bg-[#131921] flex items-center justify-center border-b border-gray-800">
            <h2 class="text-xl font-bold tracking-tighter italic text-white">
                SHOP<span class="text-[#ff9900] ml-1">Admin</span>
            </h2>
        </div>
        <nav class="flex-grow mt-4">
            <div class="px-2 mb-6">
                <p class="px-4 text-[10px] text-gray-400 mb-2 uppercase font-bold tracking-widest">商品管理</p>
                <a href="{{ route('item.index') }}" class="flex items-center px-4 py-3 text-sm hover:bg-[#37475a] border-l-4 border-transparent hover:border-[#ff9900] transition-all">
                    <span class="mr-3">📦</span> 販売品一覧
                </a>
            </div>
            <div class="px-2 mb-6 border-t border-gray-700 pt-6">
                <p class="px-4 text-[10px] text-gray-400 mb-2 uppercase font-bold tracking-widest">データ分析</p>
                <a href="{{ route('sales_check') }}" class="flex items-center px-4 py-3 text-sm bg-[#37475a] border-l-4 border-[#ff9900]">
                    <span class="mr-3">📈</span> 売上確認
                </a>
            </div>
        </nav>
        <div class="p-4 bg-[#19222d] text-xs border-t border-gray-800">
            <p class="text-gray-400">ログイン中:</p>
            <p class="font-bold text-[#ff9900] truncate">{{ Auth::user()->name }}</p>
        </div>
    </div>

    {{-- 2. メインコンテンツエリア --}}
    <div class="flex-grow flex flex-col h-screen overflow-y-auto">
        
        {{-- ヘッダー (カート・お届け先なし) --}}
        <header class="bg-[#131921] text-white h-[60px] px-6 flex items-center justify-between shadow-md flex-shrink-0">
            <div class="text-sm font-bold flex items-center">
                <span class="text-gray-400">管理者パネル</span>
                <span class="mx-2 text-gray-600">›</span>
                <span class="text-[#ff9900]">売上・注文履歴</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs bg-gray-700 hover:bg-gray-600 px-4 py-1.5 rounded font-bold transition">
                    ログアウト
                </button>
            </form>
        </header>

        <main class="p-8">
            <div class="flex justify-between items-end mb-8 border-b border-gray-300 pb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">📈 売上・注文履歴</h1>
                    <p class="text-gray-500 mt-1 font-medium">ショップ全体の販売パフォーマンスを確認できます。</p>
                </div>
            </div>

            {{-- 売上サマリーカード --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 border-t-4 border-t-[#B12704]">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">総売上累計</p>
                    <p class="text-4xl font-black text-gray-900 mt-2">
                        <span class="text-2xl font-bold">¥</span>{{ number_format($totalSales ?? 0) }}
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 border-t-4 border-t-blue-500">
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">総受注件数</p>
                    <p class="text-4xl font-black text-gray-900 mt-2">
                        {{ $sales->count() }} <span class="text-xl">件</span>
                    </p>
                </div>
            </div>

            {{-- 売上履歴リスト --}}
            <div class="space-y-4">
                @forelse($sales as $sale)
                    <div class="bg-white rounded-md border border-gray-300 overflow-hidden shadow-sm hover:shadow-md transition">
                        {{-- 注文ヘッダー --}}
                        <div class="bg-[#f0f2f2] px-4 py-3 border-b border-gray-300 flex flex-wrap justify-between items-center text-xs text-gray-600">
                            <div class="flex space-x-10">
                                <div>
                                    <p class="font-bold text-gray-400 uppercase mb-0.5">注文日</p>
                                    <p class="font-medium text-gray-800">{{ $sale->created_at->format('Y年m月d日 H:i') }}</p>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-400 uppercase mb-0.5">売上金額</p>
                                    <p class="font-bold text-[#B12704]">¥{{ number_format($sale->price * $sale->quantity) }}</p>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-400 uppercase mb-0.5">購入者</p>
                                    <p class="text-blue-600 font-bold">{{ $sale->billing_name ?? 'ゲスト' }} 様</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-400 uppercase mb-0.5">注文番号</p>
                                <p class="font-mono">#{{ $sale->buy_number }}</p>
                            </div>
                        </div>

                        {{-- 商品情報 --}}
                        <div class="p-4 flex gap-6 items-center">
                            <div class="w-20 h-20 bg-white flex-shrink-0 border border-gray-100 p-1 rounded">
                                <img src="{{ $sale->image1 ? asset('storage/' . $sale->image1) : 'https://via.placeholder.com/150' }}"
                                    class="w-full h-full object-contain"
                                    onerror="this.src='https://via.placeholder.com/150'">
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-bold text-sm text-gray-800 leading-snug mb-1">{{ $sale->title ?? $sale->item_name }}</h3>
                                <p class="text-xs text-gray-500">
                                    単価: ¥{{ number_format($sale->price) }} / 数量: {{ $sale->quantity }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold border border-green-200 uppercase">
                                    売上確定
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-24 bg-white border border-gray-300 rounded-md">
                        <div class="text-4xl mb-4">📈</div>
                        <p class="text-gray-500 font-bold text-lg">売上データがまだ存在しません。</p>
                        <p class="text-gray-400 text-sm">商品が購入されるとここに表示されます。</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

</body>
</html>