@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 px-4">
        {{-- カード状のコンテナ --}}
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-300">
            <h1 class="text-3xl font-medium mb-6 text-gray-800">ログイン</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1 ml-1 text-gray-700">Eメールアドレス</label>
                    <input type="email" name="email" required autofocus
                        class="w-full border border-gray-400 rounded-sm px-3 py-2 focus:border-[#e77600] focus:ring-1 focus:ring-[#e77600] outline-none shadow-inner transition">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold mb-1 ml-1 text-gray-700">パスワード</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-400 rounded-sm px-3 py-2 focus:border-[#e77600] focus:ring-1 focus:ring-[#e77600] outline-none shadow-inner transition">
                </div>

                <button type="submit"
                    class="w-full bg-[#ffd814] hover:bg-[#f7ca00] text-black py-2 rounded-md shadow-sm border border-[#adb1b8] font-medium text-sm transition">
                    ログイン
                </button>
            </form>

            <p class="text-[11px] text-gray-600 mt-4 leading-tight">
                続行することで、ShoppingMallの <a href="#" class="text-blue-600 hover:underline">利用規約</a> および <a href="#"
                    class="text-blue-600 hover:underline">プライバシー規約</a> に同意したものとみなされます。
            </p>

            <div class="relative flex py-6 items-center">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="flex-shrink mx-4 text-gray-400 text-xs">ShoppingMallをご利用でない方</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <a href="{{ route('register') }}"
                class="block w-full text-center bg-[#f0f2f2] hover:bg-[#e7e9ec] text-black py-2 rounded-md text-sm font-medium border border-[#adb1b8] shadow-sm transition">
                ShoppingMallアカウントを作成
            </a>
        </div>

        {{-- 管理者への案内をこっそり下に --}}
        <div class="mt-6 text-center">
            <div class="inline-block bg-gray-100 px-4 py-2 rounded-full border border-gray-200">
                <span class="text-xs text-gray-500">🔧 <strong>管理者の方へ:</strong> 登録済みの管理者用アドレスでログインすると自動で管理パネルへ移行します。</span>
            </div>
        </div>
    </div>
@endsection