@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center min-h-[85vh] pt-12 bg-[#f0f2f2]">
        {{-- ログインフォームカード --}}
        <div class="w-[350px] bg-white p-6 border border-gray-300 rounded-lg shadow-sm">
            <h1 class="text-2xl font-normal mb-4">管理者ログイン</h1>

            @if ($errors->any())
                <div class="mb-4 text-red-600 text-xs font-bold bg-red-50 p-2 border border-red-200 rounded">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-xs font-bold mb-1">Eメールアドレス</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-gray-400 rounded-sm px-2 py-1 text-sm outline-none focus:ring-1 focus:ring-orange-500 shadow-inner">
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold mb-1">パスワード</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-400 rounded-sm px-2 py-1 text-sm outline-none focus:ring-1 focus:ring-orange-500 shadow-inner">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-b from-[#f7dfa1] to-[#edc14b] border border-[#a88734] hover:from-[#f5d172] text-sm py-1.5 rounded-sm shadow-sm">
                    ログイン
                </button>
            </form>
        </div>

        {{-- ★ここから追加：新規登録へのリンクセクション★ --}}
        <div class="w-[350px] mt-4">
            <div class="relative flex py-3 items-center">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="flex-shrink mx-2 text-xs text-gray-500">管理者アカウントをお持ちでない場合</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <a href="{{ route('register') }}"
                class="block w-full text-center bg-gray-100 hover:bg-gray-200 border border-gray-400 text-sm py-1.5 rounded-sm shadow-sm transition duration-200">
                新しく管理者を登録する
            </a>
        </div>
        {{-- ★ここまで追加★ --}}

    </div>
@endsection