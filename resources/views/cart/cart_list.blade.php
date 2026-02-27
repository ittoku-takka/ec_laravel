@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-10">
        <h2 class="text-3xl font-black text-gray-800 mb-8 flex items-center">
            <span class="mr-3">🛒</span> ショッピングカート
        </h2>

        @if($cart_items->isEmpty())
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-r-xl shadow-sm">
                <p class="text-blue-700 font-bold">カートは空っぽです。</p>
                <a href="{{ route('item_list') }}" class="inline-block mt-4 text-blue-600 hover:underline font-bold">
                    ➔ 商品一覧へ戻って買い物を楽しむ
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- 左側：商品リスト --}}
                <div class="lg:col-span-2 space-y-4">
                    @php $total = 0; @endphp
                    @foreach($cart_items as $item)
                        @php
                            $subtotal = $item->item->price * $item->quantity;
                            $total += $subtotal;
                        @endphp
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border">
                                    <img src="{{ asset('storage/' . $item->item->main_image) }}"
                                        onerror="this.src='https://picsum.photos/seed/{{ $item->item_id }}/100/100'"
                                        class="object-contain w-full h-full">
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $item->item->title }}</h3>
                                    <p class="text-sm text-gray-500">単価: ¥{{ number_format($item->item->price) }}</p>

                                    {{-- 数量変更 --}}
                                    <div class="flex items-center mt-2 gap-4">
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                            <select name="quantity" onchange="this.form.submit()"
                                                class="text-xs border rounded px-1 py-0.5 bg-white">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </form>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                            <button type="submit" class="text-[10px] text-red-400 underline">🗑 削除</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right font-black text-lg text-indigo-600">
                                ¥{{ number_format($subtotal) }}
                            </div>
                        </div>
                    @endforeach

                    {{-- お届け先情報 --}}
                    <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-300 mt-8">
                        <h4 class="font-bold text-gray-700 mb-4 flex items-center">
                            <span class="mr-2">📦</span> お届け先・請求先情報
                        </h4>
                        <div class="text-sm text-gray-600 space-y-2">
                            <p><span class="font-bold">お名前：</span> {{ Auth::user()->billing_name ?? Auth::user()->name }} 様</p>
                            <p>
                                <span class="font-bold">住所：</span>
                                @if(Auth::user()->billing_post_code)
                                    〒{{ Auth::user()->billing_post_code }}<br>
                                    <span class="ml-10">{{ Auth::user()->billing_address1 }}</span><br>
                                    <span class="ml-10">{{ Auth::user()->billing_address2 }}</span>
                                @else
                                    <span class="text-red-500 font-bold italic">住所が登録されていません</span>
                                @endif
                            </p>
                            <p><span class="font-bold">電話：</span> {{ Auth::user()->billing_tel ?? '未登録' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                            class="inline-block mt-4 text-xs text-indigo-500 hover:underline font-bold">
                            ➔ 住所を変更する
                        </a>
                    </div>
                </div>

                {{-- 右側：注文合計 --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border border-indigo-50 sticky top-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4">注文内容確認</h3>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-500">商品小計</span>
                            <span class="font-bold text-gray-800">¥{{ number_format($total) }}</span>
                        </div>
                        <div class="flex justify-between mb-8">
                            <span class="text-gray-500">送料</span>
                            <span class="font-bold text-green-500">無料</span>
                        </div>
                        <div class="flex justify-between items-end mb-8 border-t pt-4">
                            <span class="text-gray-800 font-bold">合計金額</span>
                            <span class="text-3xl font-black text-indigo-600">¥{{ number_format($total) }}</span>
                        </div>

                        <form action="{{ route('order_complete') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-black shadow-lg transition-all transform hover:-translate-y-1 active:scale-95">
                                注文を確定する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection