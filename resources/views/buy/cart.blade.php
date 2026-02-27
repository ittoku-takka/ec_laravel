@extends('layouts.app')

@section('title', 'ショッピングカート')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">ショッピングカート</h1>

        @if($carts->isEmpty())
            <div class="bg-white p-8 rounded-lg shadow text-center">
                <p class="text-gray-500 mb-4">カートに商品は入っていません。</p>
                <a href="{{ route('item_list') }}" class="text-blue-600 hover:underline">買い物を続ける</a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4">商品名</th>
                            <th class="p-4">単価</th>
                            <th class="p-4">数量</th>
                            <th class="p-4">小計</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $cart)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 font-bold">{{ $cart->item->title }}</td>
                                <td class="p-4">¥{{ number_format($cart->item->price) }}</td>
                                <td class="p-4">{{ $cart->quantity }}</td>
                                <td class="p-4 font-bold">¥{{ number_format($cart->item->price * $cart->quantity) }}</td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('cart.delete', $cart->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700 text-sm font-bold">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- ▼ ここを修正しました！ --}}
                <div class="p-6 bg-gray-50 flex justify-between items-center">
                    <div class="text-xl font-bold">合計: ¥{{ number_format($totalPrice) }}</div>

                    <div class="flex flex-col items-end gap-2">
                        {{-- 支払い方法選択画面へ移動するボタン --}}
                        <a href="{{ route('billing_select') }}"
                            class="bg-orange-500 text-white px-8 py-3 rounded-lg font-bold hover:bg-orange-600 shadow-md transition">
                            レジに進む（お届け先・支払方法へ）
                        </a>
                        <p class="text-xs text-gray-500 italic text-right">※次の画面でお支払い方法を選択できます</p>
                    </div>
                </div>
                {{-- ▲ ここまで --}}
            </div>
        @endif
    </div>
@endsection