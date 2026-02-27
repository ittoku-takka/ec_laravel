<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stationery Shop | 文房具通販</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* あなたの style.css の魂を 1px も壊さず継承 */
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

        /* 魂の「横伸びホバー」 (style.css 17-35行目を完全再現) */
        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
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
            border-radius: 19px;
            border: 1px solid #eee;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            overflow: hidden;
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            text-decoration: none;
        }

        .image-icon-wrap:hover {
            width: 140px;
            border-color: #333;
        }

        .nav-img-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            color: #fff;
        }

        /* ホバー時に aria-label から文字を出してスライドさせる演出 */
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

        /* カテゴリナビのスライド黒線 */
        .category-list {
            display: flex;
            list-style: none;
            gap: 15px;
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
    </style>
</head>

<body>
    <div id="app">
        <header>
            <div class="header-inner">
                {{-- ロゴ --}}
                <div class="logo-area">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('image/rogo.png') }}" alt="Shop Logo" style="height: 60px;">
                    </a>
                </div>

                {{-- 中央ナビ --}}
                <nav class="category-nav">
                    <ul class="category-list">
                        <li><a href="{{ url('/') }}" class="filter-btn {{ Request::is('/') ? 'active' : '' }}">すべて</a>
                        </li>
                        @auth
                            @if(Auth::user()->is_admin)
                                <li><a href="{{ route('item.index') }}" class="filter-btn">商品管理</a></li>
                                <li><a href="{{ route('user_list') }}" class="filter-btn">ユーザー管理</a></li>
                            @else
                                <li><button class="filter-btn" data-filter="pen">ペン</button></li>
                                <li><button class="filter-btn" data-filter="note">ノート</button></li>
                            @endif
                        @endauth
                    </ul>
                </nav>

                <div class="header-right">
                    <span class="user-status">@guest ゲスト 様 @else {{ Auth::user()->name }} 様 @endguest</span>

                    <nav class="flex gap-x-4">
                        @guest
                            {{-- ★未ログイン時：一般と管理者の入り口を2つ並べる --}}
                            <a href="{{ route('login') }}" class="image-icon-wrap" aria-label="一般ログイン">
                                <img src="{{ asset('image/log_in.png') }}" alt="Login" class="nav-img-icon">
                            </a>
                            <a href="{{ route('admin.login') }}" class="image-icon-wrap" aria-label="管理者ログイン">
                                <span class="nav-img-icon"
                                    style="background: #333; font-size: 10px; font-weight: bold;">管</span>
                            </a>
                        @else
                            {{-- ログイン後：権限でアイコンを分岐 --}}
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('item.index') }}" class="image-icon-wrap" aria-label="管理画面">
                                    <span class="nav-img-icon" style="background: #d32f2f;">⚙️</span>
                                </a>
                            @else
                                <a href="{{ route('cart') }}" class="image-icon-wrap" aria-label="カート">
                                    <img src="{{ asset('image/cart.png') }}" alt="Cart" class="nav-img-icon">
                                </a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">@csrf</form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="image-icon-wrap" aria-label="ログアウト">
                                <img src="{{ asset('image/log_in.png') }}" alt="Logout" class="nav-img-icon">
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