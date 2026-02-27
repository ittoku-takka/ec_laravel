@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">

        {{-- 1. 戻るボタン（お買い物を続ける） --}}
        <div class="mb-6">
            <a href="{{ route('item_list') }}"
                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-bold transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                お買い物を続ける
            </a>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            <h1 class="text-2xl font-black mb-8 text-gray-800 flex items-center">
                <span class="mr-3 text-indigo-600">👤</span> プロフィール・お届け先の編集
            </h1>

            {{-- 成功メッセージ --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-3 rounded mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                {{-- 管理者が編集する場合のためのID --}}
                @if(isset($user->id) && $user->id !== Auth::user()->id)
                    <input type="hidden" name="id" value="{{ $user->id }}">
                @endif

                {{-- 基本情報 --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">お名前</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">メールアドレス</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- お届け先情報 --}}
                <div class="space-y-4">
                    <p class="text-sm font-bold text-indigo-600 uppercase tracking-widest">Delivery Info / お届け先</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">郵便番号</label>
                            <input type="text" name="billing_post_code"
                                value="{{ old('billing_post_code', $user->billing_post_code) }}" placeholder="123-4567"
                                class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">電話番号</label>
                            <input type="text" name="billing_tel" value="{{ old('billing_tel', $user->billing_tel) }}"
                                placeholder="090-0000-0000"
                                class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">住所1（市区町村・番地）</label>
                        <input type="text" name="billing_address1"
                            value="{{ old('billing_address1', $user->billing_address1) }}" placeholder="東京都渋谷区..."
                            class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">住所2（ビル・マンション名）</label>
                        <input type="text" name="billing_address2"
                            value="{{ old('billing_address2', $user->billing_address2) }}" placeholder="〇〇マンション 101号室"
                            class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                {{-- 保存ボタン --}}
                <div class="pt-6">
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white font-black py-4 rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 transform hover:-translate-y-0.5">
                        保存して更新する
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection