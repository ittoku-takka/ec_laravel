@extends('layouts.app')

@section('content')
    <style>
        /* 1. ベースは絶対に変えない（継承） */
        .admin-container {
            font-family: "Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", sans-serif;
            background: #fcfcf9;
            display: flex;
            min-height: calc(100vh - 60px);
        }

        .sidebar {
            width: 240px;
            background: #232f3e;
            color: #ffffff;
            padding: 20px 0;
            flex-shrink: 0;
            position: sticky;
            top: 60px;
            height: calc(100vh - 60px);
        }

        .sidebar-menu { list-style: none; padding: 0; }

        .sidebar-item {
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .sidebar-item:hover,
        .sidebar-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-left: 4px solid #ff9900;
        }

        .main-content {
            flex-grow: 1;
            padding: 40px;
            max-width: 1400px;
        }

        .admin-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
            padding: 30px;
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 900;
            color: #333;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .styled-input, .styled-select {
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-amazon {
            background: linear-gradient(to bottom, #ffb03b, #ff9900);
            border: 1px solid #a88734;
            border-radius: 8px;
            color: #111;
            font-weight: bold;
            padding: 10px 24px;
            cursor: pointer;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .product-item {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 15px;
            transition: 0.3s;
            text-align: left;
            display: flex;
            flex-direction: column;
        }

        .product-image {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: contain;
            margin-bottom: 15px;
        }

        /* ★文字数は絶対に減らしません！全表示設定★ */
        .product-description-full {
            font-size: 0.85rem;
            color: #555;
            line-height: 1.6;
            margin: 10px 0;
            word-break: break-all;
            white-space: pre-wrap; /* 改行を有効にし、省略もしない */
            flex-grow: 1;
        }

        .action-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            border-top: 1px solid #eee;
            margin-top: 15px;
            padding-top: 15px;
        }

        .btn-pill {
            padding: 8px 24px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.2s;
            color: white;
            text-align: center;
        }
        .btn-pill-edit { background: #0066c0; }
        .btn-pill-delete { background: #cc0c39; }

        .user-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .user-table th {
            background: #f8f9fa;
            color: #555;
            font-weight: bold;
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #eee;
            font-size: 0.85rem;
        }

        .user-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
            color: #333;
        }

        .role-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .role-admin { background: #fff3cd; color: #856404; }
        .role-user { background: #d1ecf1; color: #0c5460; }
    </style>

    <div class="admin-container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="{{ url('/') }}" class="sidebar-item"><i class="fa-solid fa-store"></i> ショップ画面を表示</a></li>
                <div style="padding: 20px 24px 10px; font-size: 1.0rem; color: #888; text-transform: uppercase;">管理メニュー</div>
                <li><a href="#items-section" class="sidebar-item active"><i class="fa-solid fa-box-open"></i> 販売品管理</a></li>
                <li><a href="#users-section" class="sidebar-item"><i class="fa-solid fa-users-gear"></i> ユーザー管理</a></li>
                <li><a href="{{ route('item.create') }}" class="sidebar-item"><i class="fa-solid fa-plus-circle"></i> 新規商品登録</a></li>
            </ul>
            <div style="position: absolute; bottom: 20px; left: 24px; font-size: 0.75rem; color: #888;">
                管理者: <span style="color: #ff9900;">{{ Auth::user()->name }}</span>
            </div>
        </aside>

        <main class="main-content">
            {{-- ★修正：カテゴリー選択 ＋ キーワード検索フォーム★ --}}
            <div class="admin-card">
                <h3 class="section-title"><i class="fa-solid fa-magnifying-glass"></i> 商品を絞り込む</h3>
                <form action="{{ route('item.index') }}" method="GET" style="display: flex; gap: 15px; align-items: center;">
                    {{-- カテゴリー選択を追加 --}}
                    <select name="category" class="styled-select" style="min-width: 160px;">
                        <option value="">すべて</option>
                        <option value="ペン" {{ request('category') == 'ペン' ? 'selected' : '' }}>ペン</option>
                        <option value="シャープペン" {{ request('category') == 'シャープペン' ? 'selected' : '' }}>シャープペン</option>
                        <option value="ノート" {{ request('category') == 'ノート' ? 'selected' : '' }}>ノート</option>
                        <option value="消しゴム" {{ request('category') == '消しゴム' ? 'selected' : '' }}>消しゴム</option>
                    </select>

                    {{-- キーワード入力 --}}
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="styled-input" placeholder="商品名などで検索..." style="flex-grow: 1;">
                    
                    <button type="submit" class="btn-amazon">検索する</button>
                </form>
            </div>

            {{-- API取得セクション --}}
            <div class="admin-card" style="background: #e7f3ff; border: 1px solid #b3d7ff;">
                <h3 class="section-title" style="color: #004085;"><i class="fa-solid fa-wand-magic-sparkles"></i> APIから商品を取り込む</h3>
                <form action="{{ route('item.importSingle') }}" method="POST" style="display: flex; gap: 10px;">
                    @csrf
                    <input type="number" name="item_code" class="styled-input" placeholder="1 〜 20 の数字を入力" style="flex-grow: 1;">
                    <button type="submit" class="btn-amazon">この商品をGET</button>
                </form>
            </div>

            {{-- 商品一覧セクション --}}
            <div id="items-section" class="admin-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h3 class="section-title" style="margin-bottom: 0;"><i class="fa-solid fa-boxes-stacked"></i> 登録済み商品一覧</h3>
                    <a href="{{ route('item.create') }}" class="btn-amazon" style="text-decoration: none;"><i class="fa-solid fa-plus"></i> 新規商品を追加</a>
                </div>

                <div class="product-grid">
                    @foreach($items as $item)
                        <div class="product-item">
                            <img src="{{ str_starts_with($item->image1, 'http') ? $item->image1 : asset('storage/' . $item->image1) }}" class="product-image" alt="商品画像">
                            
                            <div style="font-weight: bold; font-size: 1rem; color: #232f3e; margin-bottom: 10px;">{{ $item->title }}</div>
                            
                            {{-- 【重要】説明文：文字数を削らず全て表示します --}}
                            <div class="product-description-full">
                                {!! nl2br(e($item->description)) !!}
                            </div>

                            <div style="color: #b12704; font-weight: bold; font-size: 1.2rem; margin: 15px 0;">¥ {{ number_format($item->price) }}</div>
                            
                            <div class="action-container">
                                <a href="{{ route('item.edit', $item->id) }}" class="btn-pill btn-pill-edit">編集</a>
                                
                                <form action="{{ route('item.destroy', $item->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-pill btn-pill-delete">削除</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ユーザー一覧セクション --}}
            <div id="users-section" class="admin-card">
                <h3 class="section-title"><i class="fa-solid fa-users"></i> 登録ユーザー一覧</h3>
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>ユーザー名</th><th>メールアドレス</th><th>権限</th><th>登録日</th><th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>#{{ $user->id }}</td>
                                <td class="font-bold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="role-badge {{ $user->role == 1 ? 'role-admin' : 'role-user' }}">
                                        {{ $user->role == 1 ? '管理者' : '一般ユーザー' }}
                                    </span>
                                </td>
                                <td style="color: #888; font-size: 0.8rem;">{{ $user->created_at->format('Y/m/d') }}</td>
                                <td>
                                    <button style="background:none; border:none; color:#0066c0; text-decoration:underline; cursor:pointer;">詳細</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection