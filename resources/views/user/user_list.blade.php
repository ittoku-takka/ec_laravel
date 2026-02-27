<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ユーザー管理 - 管理者パネル</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#eaeded] font-sans antialiased flex overflow-hidden">

    {{-- 1. サイドバー (共通デザイン) --}}
    <div class="w-64 bg-[#232f3e] text-white h-screen shadow-xl flex flex-col flex-shrink-0">
        <div class="p-4 bg-[#131921] flex items-center justify-center border-b border-gray-800">
            <h2 class="text-xl font-bold tracking-tighter italic">
                SHOP<span class="text-[#ff9900] ml-1">Admin</span>
            </h2>
        </div>
        <nav class="flex-grow mt-4">
            <div class="px-2 mb-6">
                <p class="px-4 text-[10px] text-gray-400 mb-2 uppercase font-bold tracking-widest">商品管理</p>
                <a href="{{ route('item.index') }}"
                    class="flex items-center px-4 py-3 text-sm hover:bg-[#37475a] border-l-4 border-transparent hover:border-[#ff9900] transition-all">
                    <span class="mr-3">📦</span> 販売品一覧
                </a>
            </div>
            <div class="px-2 mb-6 border-t border-gray-700 pt-6">
                <p class="px-4 text-[10px] text-gray-400 mb-2 uppercase font-bold tracking-widest">データ分析</p>
                <a href="{{ route('user_list') }}"
                    class="flex items-center px-4 py-3 text-sm bg-[#37475a] border-l-4 border-[#ff9900]">
                    <span class="mr-3">👤</span> ユーザー一覧
                </a>
                <a href="{{ route('sales_check') }}"
                    class="flex items-center px-4 py-3 text-sm hover:bg-[#37475a] border-l-4 border-transparent hover:border-[#ff9900] transition-all">
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

        {{-- ヘッダー (お届け先・カートなし) --}}
        <header class="bg-[#131921] text-white h-[60px] px-6 flex items-center justify-between shadow-md flex-shrink-0">
            <div class="text-sm font-bold flex items-center">
                <span class="text-gray-400">管理者モード</span>
                <span class="mx-2 text-gray-600">›</span>
                <span class="text-white font-bold">登録ユーザー管理</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-xs bg-gray-700 hover:bg-gray-600 px-4 py-1.5 rounded font-bold transition">
                    ログアウト
                </button>
            </form>
        </header>

        <main class="p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-800">👤 登録ユーザー管理</h1>
                <p class="text-gray-500 mt-1 font-medium">システムの全ユーザー情報を閲覧・編集できます。</p>
            </div>

            {{-- ユーザー一覧テーブル (Amazon Admin風) --}}
            <div class="bg-white shadow-sm border border-gray-300 rounded-md overflow-hidden">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 border-b border-gray-300">
                            <th class="p-4 font-bold w-20">ID</th>
                            <th class="p-4 font-bold">名前</th>
                            <th class="p-4 font-bold">メールアドレス</th>
                            <th class="p-4 font-bold text-center">アクション</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-500 font-mono">{{ $user->id }}</td>
                                <td class="p-4">
                                    <span class="font-bold text-gray-800">{{ $user->name }}</span>
                                    @if($user->role === 'admin')
                                        <span
                                            class="ml-2 text-[10px] bg-orange-100 text-orange-700 px-1.5 py-0.5 rounded font-bold uppercase">管理者</span>
                                    @endif
                                </td>
                                <td class="p-4 text-blue-600">{{ $user->email }}</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('profile.edit', $user->id) }}"
                                            class="bg-white border border-gray-300 px-3 py-1 rounded text-xs font-bold hover:bg-gray-100 transition shadow-sm">
                                            編集
                                        </a>
                                        {{-- ここに削除ボタンなどを追加可能 --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($users->isEmpty())
                    <div class="text-center py-20 bg-gray-50">
                        <p class="text-gray-400 italic">登録されているユーザーがいません。</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

</body>

</html>