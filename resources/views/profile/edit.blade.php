@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mt-10">
        <h2 class="text-2xl font-black mb-6 flex items-center border-b pb-4">
            <span class="mr-2 text-3xl">👤</span> 会員情報の確認・変更
        </h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- ログイン用の名前 --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">ユーザー名</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- お届け先名 --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">お届け先お名前</label>
                    <input type="text" name="billing_name" value="{{ Auth::user()->billing_name }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">メールアドレス（変更不可）</label>
                <input type="text" value="{{ Auth::user()->email }}" disabled
                    class="w-full bg-gray-50 border-gray-200 rounded-lg shadow-sm text-gray-400">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                {{-- 郵便番号 --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">郵便番号</label>
                    <input type="text" name="billing_post_code" value="{{ Auth::user()->billing_post_code }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- 電話番号 --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">電話番号</label>
                    <input type="text" name="billing_tel" value="{{ Auth::user()->billing_tel }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>
            </div>

            {{-- 住所 --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">住所（都道府県・市区町村）</label>
                <input type="text" name="billing_address1" value="{{ Auth::user()->billing_address1 }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">住所（番地・建物名）</label>
                <input type="text" name="billing_address2" value="{{ Auth::user()->billing_address2 }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold shadow-lg transition-all transform hover:-translate-y-1">
                会員情報を更新する
            </button>
        </form>
    </div>
@endsection