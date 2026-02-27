@extends('layouts.app')

@section('title', '注文詳細')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden border mt-8">
        {{-- ヘッダー部分 --}}
        <div class="bg-gray-50 p-6 border-b flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">
                注文詳細 <span class="text-gray-400 font-normal text-sm ml-2">購入番号: {{ $order->buy_number }}</span>
            </h1>
            <a href="{{ route('buy_history') }}" class="text-sm text-blue-600 hover:underline">
                ← 購入履歴一覧に戻る
            </a>
        </div>

        <div class="p-8 space-y-8">
            {{-- 商品情報 --}}
            <div class="pb-6 border-b flex gap-6 items-center">
                <div class="w-24 h-24 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center p-2">
                    <img src="{{ $order->image ?? 'https://via.placeholder.com/150' }}" class="max-h-full object-contain">
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $order->title }}</h2>
                    <p class="text-gray-600">単価: ¥{{ number_format($order->price) }} / 数量: {{ $order->quantity }}</p>
                    <p class="text-xl font-bold text-blue-600 mt-2">
                        合計: ¥{{ number_format($order->price * $order->quantity) }}
                    </p>
                </div>
            </div>

            {{-- 配送先・支払い詳細 --}}
            <div class="grid md:grid-cols-2 gap-8 bg-blue-50 p-6 rounded-xl border border-blue-100">
                <div>
                    <h3 class="font-bold text-blue-800 mb-3 border-b border-blue-200 pb-1 text-sm uppercase">お届け先</h3>
                    <div class="text-sm text-gray-700 space-y-1 leading-relaxed">
                        <p class="font-bold text-gray-900">{{ $order->billing_name }} 様</p>
                        <p>〒{{ $order->billing_post_code }}</p>
                        <p>{{ $order->billing_address1 }} {{ $order->billing_address2 }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-blue-800 mb-3 border-b border-blue-200 pb-1 text-sm uppercase">配送・お支払い</h3>
                    <div class="text-sm text-gray-700 space-y-2">
                        <p><span class="text-gray-400 font-bold">配送方法:</span>
                            {{ $order->delivery_method == 0 ? 'クロネコヤマト' : '佐川急便' }}
                        </p>
                        <p><span class="text-gray-400 font-bold">支払方法:</span>
                            @if($order->payment_method == 0) 銀行振込
                            @elseif($order->payment_method == 1) クレジットカード
                            @else コンビニ決済
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection