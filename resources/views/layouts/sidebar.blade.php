<div class="w-64 bg-[#232f3e] text-white min-h-screen p-0 shadow-xl flex flex-col">
    {{-- ロゴエリア --}}
    <div class="p-4 bg-[#131921] mb-2">
        <h2 class="text-lg font-bold flex items-center tracking-tighter">
            <span class="text-white">SHOP</span>
            <span class="text-[#ff9900] ml-1 text-xs border border-[#ff9900] px-1 rounded">ADMIN</span>
        </h2>
    </div>

    <nav class="flex-grow">
        {{-- 商品管理セクション --}}
        <div class="px-2 mb-4">
            <p class="px-4 text-[11px] text-gray-400 mb-1 uppercase font-bold tracking-wider">商品管理</p>
            <a href="{{ route('item.index') }}"
                class="flex items-center px-4 py-2.5 text-sm hover:bg-[#37475a] border-l-4 border-transparent hover:border-[#ff9900] transition-all group {{ request()->routeIs('item.index') ? 'bg-[#37475a] border-[#ff9900]' : '' }}">
                <span class="mr-3 text-lg group-hover:scale-110 transition">📦</span>
                販売品一覧
            </a>
            <a href="{{ route('item.create') }}"
                class="flex items-center px-4 py-2.5 text-sm hover:bg-[#37475a] border-l-4 border-transparent hover:border-[#ff9900] transition-all group {{ request()->routeIs('item.create') ? 'bg-[#37475a] border-[#ff9900]' : '' }}">
                <span class="mr-3 text-lg group-hover:scale-110 transition">➕</span>
                新規商品登録
            </a>
        </div>

        {{-- 顧客・売上セクション --}}
        <div class="px-2 mb-4 border-t border-gray-700 pt-4">
            <p class="px-4 text-[11px] text-gray-400 mb-1 uppercase font-bold tracking-wider">データ分析</p>
            <a href="{{ route('user_list') }}"
                class="flex items-center px-4 py-2.5 text-sm hover:bg-[#37475a] border-l-4 border-transparent hover:border-[#ff9900] transition-all group">
                <span class="mr-3 text-lg group-hover:scale-110 transition">👤</span>
                ユーザー一覧
            </a>
            <a href="{{ route('sales_check') }}"
                class="flex items-center px-4 py-2.5 text-sm hover:bg-[#37475a] border-l-4 border-transparent hover:border-[#ff9900] transition-all group">
                <span class="mr-3 text-lg group-hover:scale-110 transition">📈</span>
                売上確認
            </a>
        </div>

        {{-- ★カートを見る は管理者に不要なので削除しました --}}
    </nav>

    {{-- 下部設定エリア --}}
    <div class="p-4 bg-[#19222d] text-xs text-gray-400 mt-auto">
        <p>Logged in as:</p>
        <p class="text-white font-bold truncate">{{ Auth::user()->name }}</p>
    </div>
</div>