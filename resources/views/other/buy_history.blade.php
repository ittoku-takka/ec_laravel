@extends('layouts.app')

@section('title', '購入履歴')

@section('content')
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">ご注文履歴</h1>

        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                    {{-- 注文のヘッダー部分（日付・番号・合計） --}}
                    <div class="bg-gray-50 p-4 border-b flex justify-between text-sm text-gray-600">
                        <div>
                            <span class="block text-xs uppercase font-bold text-gray-400">注文日</span>
                            {{ $order->created_at->format('Y年m月d日') }}
                        </div>
                        <div>
                            <span class="block text-xs uppercase font-bold text-gray-400">注文番号</span>
                            #{{ $order->buy_number }}
                        </div>
                        <div class="text-right font-bold text-gray-900">
                            <span class="block text-xs uppercase font-bold text-gray-400 text-gray-400">合計金額</span>
                            ¥{{ number_format($order->price * $order->quantity) }}
                        </div>
                    </div>

                    {{-- 商品の情報部分 --}}
                    <div class="p-4 flex gap-6 items-center">
                        <div class="w-20 h-20 bg-gray-100 rounded flex-shrink-0">
                            <img src="{{ $order->image ?? 'https://via.placeholder.com/100' }}"
                                class="w-full h-full object-contain">
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-lg text-blue-600">{{ $order->title }}</h3>
                            <p class="text-sm text-gray-500">
                                単価: ¥{{ number_format($order->price) }} / 数量: {{ $order->quantity }}
                            </p>
                        </div>

                        {{-- 【ここが重要！】配送済みバッジと詳細ボタン --}}
                        <div class="text-right space-y-2">
                            <span
                                class="block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold text-center">
                                配送済み
                            </span>

                            {{-- 詳細画面へのリンクボタン --}}
                            <a href="{{ route('buy_history_detail', $order->id) }}"
                                class="block text-xs bg-white border border-gray-300 hover:bg-gray-50 text-gray-600 py-1.5 px-3 rounded shadow-sm transition text-center font-bold no-underline">
                                注文詳細を見る
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection