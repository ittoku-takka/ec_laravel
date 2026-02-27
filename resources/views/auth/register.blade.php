@extends('layouts.app')

@section('content')
    <div class="container py-10">
        <div class="max-w-md mx-auto bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-black mb-6 text-center">新規会員登録</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- 基本情報 --}}
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">ユーザー名</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">メールアドレス</label>
                    <input type="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">パスワード</label>
                    <input type="password" name="password" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-1">パスワード（確認用）</label>
                    <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg shadow-sm"
                        required>
                </div>

                <hr class="my-6 border-gray-100">
                <h3 class="text-lg font-bold mb-4 flex items-center">📦 お届け先情報の入力</h3>

                {{-- 追加した住所情報 --}}
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">お届け先お名前（フルネーム）</label>
                    <input type="text" name="billing_name" class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="山田 太郎" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">郵便番号（ハイフンなし）</label>
                    <input type="text" name="billing_post_code" class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="1234567" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">住所1（都道府県・市区町村）</label>
                    <input type="text" name="billing_address1" class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="東京都渋谷区..." required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">住所2（番地・建物名）</label>
                    <input type="text" name="billing_address2" class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="1-2-3 〇〇マンション101" required>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-1">電話番号（ハイフンなし）</label>
                    <input type="text" name="billing_tel" class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="09012345678" required>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold shadow-lg transition">
                    会員登録して買い物を始める
                </button>
            </form>
        </div>
    </div>
@endsection