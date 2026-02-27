@extends('layouts.app')

@section('title', 'お届け先・お支払い方法の選択')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-8 text-center text-gray-800">お届け先・お支払い方法</h1>

        <form action="{{ route('order_check') }}" method="GET" class="space-y-6">

            {{-- 配送先情報 --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-bold mb-4 border-b pb-2 text-blue-600">配送先情報</h2>
                <div class="space-y-2 text-gray-700">
                    <p><span class="font-bold">お名前：</span> {{ Auth::user()->name }} 様</p>
                    {{-- ユーザーテーブルにカラムがない場合は「未設定」と出ます --}}
                    <p><span class="font-bold">郵便番号：</span> 〒{{ Auth::user()->billing_post_code ?? '---' }}</p>
                    <p><span class="font-bold">ご住所：</span> {{ Auth::user()->billing_address1 ?? '住所が登録されていません' }}</p>
                </div>
            </div>

            {{-- お支払い方法の選択 --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-bold mb-4 border-b pb-2 text-blue-600">お支払い方法</h2>
                <div class="space-y-4">
                    <label
                        class="flex items-center space-x-3 cursor-pointer p-3 border rounded hover:bg-gray-50 transition">
                        <input type="radio" name="payment_method" value="credit_card" checked class="w-4 h-4 text-blue-600">
                        <span class="text-gray-800 font-medium">クレジットカード</span>
                    </label>
                    <label
                        class="flex items-center space-x-3 cursor-pointer p-3 border rounded hover:bg-gray-50 transition">
                        <input type="radio" name="payment_method" value="bank_transfer" class="w-4 h-4 text-blue-600">
                        <span class="text-gray-800 font-medium">銀行振込</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('cart') }}" class="text-gray-500 hover:underline">カートに戻る</a>
                <button type="submit"
                    class="bg-blue-600 text-white px-10 py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg transition">
                    確認画面へ進む
                </button>
            </div>
        </form>
    </div>
@endsection