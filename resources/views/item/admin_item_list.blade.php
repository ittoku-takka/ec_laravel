@extends('layouts.app')

@section('content')
    <style>
        /* --- 1. ヘッダーデザイン（管理メニュー専用） --- */
        .category-nav .category-list {
            display: none !important;
        }

        .admin-header-nav {
            display: flex;
            list-style: none;
            gap: 25px;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .admin-filter-style {
            font-size: 0.9rem;
            font-weight: 500;
            color: #777;
            background: none;
            border: none;
            padding: 6px 4px;
            border-bottom: 2px solid transparent;
            transition: 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .admin-filter-style:hover,
        .admin-filter-style.active {
            color: #333;
            font-weight: bold;
            border-bottom: 2px solid #333;
        }

        .admin-status-badge {
            font-size: 0.7rem;
            font-weight: bold;
            color: #666;
            background: #f5f5f5;
            padding: 4px 10px;
            border-radius: 20px;
            margin-right: 15px;
            border: 1px solid #eee;
        }

        /* --- 2. メインコンテンツ（行列形式） --- */
        .admin-container {
            font-family: "Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", sans-serif;
            background: #fcfcf9;
            min-height: calc(100vh - 60px);
        }

        .main-content {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .admin-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
            padding: 30px;
            margin-bottom: 40px;
        }

        .item-list-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .item-list-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #eee;
            color: #555;
            font-size: 0.85rem;
            background: #fcfcfc;
        }

        .item-row {
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
        }

        .item-row:hover {
            background: #f9f9f9;
        }

        .item-row td {
            padding: 15px;
            vertical-align: top;
        }

        .item-thumb {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border: 1px solid #eee;
            border-radius: 4px;
            background: #fff;
        }

        .item-title-text {
            font-weight: bold;
            color: #232f3e;
            font-size: 1rem;
        }

        .item-desc-text {
            font-size: 0.85rem;
            color: #555;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-all;
            margin-top: 5px;
        }

        .item-price-text {
            color: #b12704;
            font-weight: bold;
            font-size: 1.1rem;
            white-space: nowrap;
        }

        .item-stock-text {
            font-weight: bold;
            font-size: 1rem;
            white-space: nowrap;
        }

        .item-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 100px;
        }

        .btn-pill {
            padding: 6px 18px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 0.85rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            color: white;
            text-align: center;
            display: block;
        }

        .btn-pill-edit {
            background: #0066c0;
        }

        .btn-pill-delete {
            background: #cc0c39;
        }

        .btn-amazon {
            background: linear-gradient(to bottom, #ffb03b, #ff9900);
            border: 1px solid #a88734;
            border-radius: 8px;
            color: #111;
            font-weight: bold;
            padding: 10px 24px;
            cursor: pointer;
            text-decoration: none;
        }

        .styled-input,
        .styled-select {
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categoryNav = document.querySelector('.category-nav');
            if (categoryNav) {
                categoryNav.innerHTML = `
                        <ul class="admin-header-nav">
                            <li><span class="admin-status-badge">ADMIN PANEL</span></li>
                            <li><a href="{{ route('item.index') }}" class="admin-filter-style {{ request()->routeIs('item.index') ? 'active' : '' }}">📦 販売品一覧</a></li>
                            <li><a href="{{ route('item.create') }}" class="admin-filter-style {{ request()->routeIs('item.create') ? 'active' : '' }}">➕ 新規登録</a></li>
                            </ul>
                    `;
            }
        });
    </script>

    <div class="admin-container">
        <main class="main-content">
            {{-- 検索フォーム --}}
            <div class="admin-card">
                <h3 class="section-title">🔍 商品を絞り込む</h3>
                <form action="{{ route('item.index') }}" method="GET"
                    style="display: flex; gap: 15px; align-items: center;">
                    <select name="category" class="styled-select" style="min-width: 160px;">
                        <option value="">すべての商品</option>
                        <option value="ペン" {{ request('category') == 'ペン' ? 'selected' : '' }}>ペン</option>
                        <option value="シャープペン" {{ request('category') == 'シャープペン' ? 'selected' : '' }}>シャープペン</option>
                        <option value="ノート" {{ request('category') == 'ノート' ? 'selected' : '' }}>ノート</option>
                        <option value="消しゴム" {{ request('category') == '消しゴム' ? 'selected' : '' }}>消しゴム</option>
                    </select>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="styled-input"
                        placeholder="商品名などで検索..." style="flex-grow: 1;">
                    <button type="submit" class="btn-amazon">検索する</button>
                </form>
            </div>

            {{-- 商品一覧 --}}
            <div id="items-section" class="admin-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h3 class="section-title" style="margin-bottom: 0;">📦 登録済み商品一覧</h3>
                    <a href="{{ route('item.create') }}" class="btn-amazon">➕ 新規商品を追加</a>
                </div>

                <table class="item-list-table">
                    <thead>
                        <tr>
                            <th style="width: 100px;">画像</th>
                            <th>商品情報</th>
                            <th style="width: 120px;">価格</th>
                            <th style="width: 100px;">在庫</th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr class="item-row">
                                <td>
                                    <img src="{{ str_starts_with($item->image1, 'http') ? $item->image1 : asset('storage/' . $item->image1) }}"
                                        class="item-thumb" alt="商品">
                                </td>
                                <td>
                                    <div class="item-info">
                                        <div class="item-title-text">{{ $item->title }}</div>
                                        <div class="item-desc-text">{!! nl2br(e($item->description)) !!}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="item-price-text">¥ {{ number_format($item->price) }}</div>
                                </td>
                                <td>
                                    <div class="item-stock-text" style="color: {{ $item->stock <= 5 ? '#cc0c39' : '#333' }};">
                                        {{ $item->stock }} <small>個</small>
                                        @if($item->stock <= 5)
                                            <div style="font-size: 0.7rem; color: #cc0c39; margin-top: 4px;">⚠️残りわずか</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="item-actions">
                                        <a href="{{ route('item.edit', $item->id) }}" class="btn-pill btn-pill-edit">編集</a>
                                        <form action="{{ route('item.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('本当に削除しますか？')" style="margin: 0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-pill btn-pill-delete">削除</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection