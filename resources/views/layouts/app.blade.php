<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stationery Shop | 文房具通販</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: "Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", sans-serif;
            background: #fcfcf9;
            color: #333;
        }

        header {
            background: rgba(255, 255, 255, 0.98);
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 8px 0;
        }

        .header-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .category-nav {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .category-list {
            display: flex;
            list-style: none;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .filter-btn {
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
        }

        .filter-btn.active,
        .filter-btn:hover {
            color: #333;
            font-weight: bold;
            border-bottom: 2px solid #333;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 200px;
            justify-content: flex-end;
        }

        .user-status {
            font-size: 0.75rem;
            font-weight: bold;
            color: #666;
            background: #f5f5f5;
            padding: 6px 14px;
            border-radius: 20px;
        }

        .image-icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 20px !important;
            border: 1px solid #ddd;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            overflow: hidden;
            transition: width 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            position: relative;
            text-decoration: none;
            flex-shrink: 0;
            padding-left: 1px;
        }

        .image-icon-wrap:hover {
            width: 140px;
            border-color: #333;
            border-radius: 20px !important;
        }

        .nav-img-icon {
            width: 34px;
            height: 34px;
            border-radius: 50% !important;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1a1a1a;
            color: #ffffff !important;
            font-size: 14px;
            margin-left: 1px;
        }

        .image-icon-wrap::after {
            content: attr(aria-label);
            font-size: 0.7rem;
            font-weight: bold;
            color: #333;
            margin-left: 10px;
            opacity: 0;
            transform: translateX(-5px);
            transition: 0.3s ease 0.1s;
            white-space: nowrap;
        }

        .image-icon-wrap:hover::after {
            opacity: 1;
            transform: translateX(0);
        }

        .logo-area {
            min-width: 200px;
        }

        .logo-text {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.4rem;
            font-weight: 900;
            color: #232f3e;
            text-decoration: none;
            font-style: italic;
        }

        .logo-text span {
            color: #ff9900;
        }
    </style>
</head>

<body>
    <div id="app">
        <header>
            <div class="header-inner">
                {{-- 1. ロゴ --}}
                <div class="logo-area">
                    <a href="{{ url('/') }}" class="logo-text">
                        <i class="fa-solid fa-pen-nib"></i>
                        <span>SHOP</span>
                    </a>
                </div>

                {{-- 2. 中央ナビ：ご指定の4つのカテゴリーに固定 --}}
                <nav class="category-nav">
                    <ul class="category-list">
                        <li><a href="{{ url('/') }}" class="filter-btn {{ Request::is('/') ? 'active' : '' }}">すべて</a>
                        </li>
                        <li><button class="filter-btn" data-filter="pen">ペン</button></li>
                        <li><button class="filter-btn" data-filter="sharpen">シャープペン</button></li>
                        <li><button class="filter-btn" data-filter="note">ノート</button></li>
                        <li><button class="filter-btn" data-filter="eraser">消しゴム</button></li>
                    </ul>
                </nav>

                {{-- 3. 右側：アイコンエリア --}}
                <div class="header-right">
                    <span class="user-status">@guest ゲスト 様 @else {{ Auth::user()->name }} 様 @endguest</span>

                    <nav class="flex gap-x-4">
                        @guest
                            <a href="{{ route('login') }}" class="image-icon-wrap" aria-label="一般ログイン">
                                <span class="nav-img-icon"><i class="fa-solid fa-right-to-bracket"></i></span>
                            </a>
                            <a href="{{ route('admin.login') }}" class="image-icon-wrap" aria-label="管理者ログイン">
                                <span class="nav-img-icon" style="background: #333;"><i class="fa-solid fa-lock"></i></span>
                            </a>
                        @else
                            @if(Auth::user()->role == 1)
                                <a href="{{ route('item.index') }}" class="image-icon-wrap" aria-label="管理画面設定">
                                    <span class="nav-img-icon"><i class="fa-solid fa-gear"></i></span>
                                </a>
                            @else
                                <a href="{{ route('cart') }}" class="image-icon-wrap" aria-label="マイページ">
                                    <span class="nav-img-icon"><i class="fa-solid fa-user"></i></span>
                                </a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">@csrf</form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="image-icon-wrap" aria-label="ログアウト">
                                <span class="nav-img-icon" style="background: #444;"><i
                                        class="fa-solid fa-power-off"></i></span>
                            </a>
                        @endguest
                    </nav>
                </div>
            </div>
        </header>

        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>