@extends('layouts.app')

@section('title', '注文内容の確認')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-8 text-center text-gray-800">ご注文内容の確認</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- 左側：商品一覧と配送先 --}}
            <div class="md:col-span-2 space-y-6">
                {{-- お届け先・支払い --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h2 class="font-bold mb-4 border-b pb-2">お届け先・お支払い</h2>
                    <div class="text-sm space-y-1">
                        <p>お名前：{{ Auth::user()->name }} 様</p>
                        <p>住所：〒{{ Auth::user()->billing_post_code }}
                            {{ Auth::user()->billing_address1 }}{{ Auth::user()->billing_address2 }}</p>
                        <p>支払方法：{{ request('payment_method') == 'credit_card' ? 'クレジットカード' : '銀行振込' }}</p>
                    </div>
                </div>

                {{-- カートの中身（簡易表示） --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h2 class="font-bold mb-4 border-b pb-2">注文商品</h2>
                    <p class="text-sm text-gray-600">※ここでは簡易表示しています。実際の在庫は確定時に引かれます。</p>
                    {{-- ここにループを入れることもできますが、まずは画面確認！ --}}
                </div>
            </div>

            {{-- 右側：決済ボタン --}}
            <div class="md:col-span-1">
                <div class="bg-gray-50 p-6 rounded-lg border sticky top-4">
                    <h2 class="font-bold mb-4">合計金額</h2>
                    <p class="text-2xl font-bold text-orange-600 mb-6">¥ --,--- <span
                            class="text-xs text-gray-500 font-normal">（税込）</span></p>

                    <form action="{{ route('order_complete') }}" method="POST">
                        @csrf
                        {{-- 前の画面から引き継いだ値を隠しデータとして送る --}}
                        <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">

                        <button type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-lg shadow-md transition mb-4">
                            この内容で注文を確定する
                        </button>
                    </form>

                    <a href="{{ route('billing_select') }}" class="block text-center text-sm text-gray-600 hover:underline">
                        お届け先・支払方法を変更する
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection