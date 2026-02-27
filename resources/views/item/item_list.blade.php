@extends('layouts.app')

@section('content')
    <style>
        /* 商品カードのスタイル */
        .product-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 15px;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        /* 数量選択のセレクトボックスをAmazon風に */
        .quantity-select {
            background-color: #F0F2F2;
            border: 1px solid #D5D9D9;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(15, 17, 17, .15);
            cursor: pointer;
            font-size: 13px;
            padding: 4px 8px;
        }

        .quantity-select:focus {
            outline: none;
            border-color: #007185;
            box-shadow: 0 0 0 3px #c8f3fa;
        }
    </style>

    {{-- 商品グリッド --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        @foreach($items as $item)
            <div class="product-card shadow-sm">
                {{-- 画像エリア：モデルの main_image 機能を利用 --}}
                <a href="{{ route('item_detail', $item->id) }}"
                    class="block aspect-square bg-gray-50 flex items-center justify-center p-4">

                    {{-- IDごとに違う画像をネットから拾う設定（onerror）を搭載 --}}
                    <img src="{{ asset('storage/' . $item->main_image) }}" class="max-h-full object-contain"
                        alt="{{ $item->title }}" onerror="this.src='https://picsum.photos/seed/{{ $item->id }}/400/400';">
                </a>

                <div class="p-4 flex flex-col flex-grow">
                    {{-- 商品名（Seederに合わせて title を使用） --}}
                    <h3 class="text-sm font-bold text-gray-800 mb-1 line-clamp-2 h-10">
                        {{ $item->title }}
                    </h3>

                    {{-- 価格 --}}
                    <p class="text-red-700 font-bold text-lg mb-3">
                        ￥{{ number_format($item->price) }}
                    </p>

                    {{-- カートボタンエリア --}}
                    <div class="mt-auto">
                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">

                            {{-- 数量選択：10個まで選べる --}}
                            <div class="flex items-center gap-2">
                                <label class="text-[11px] font-bold text-gray-600">数量:</label>
                                <select name="quantity" class="quantity-select">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- カートに入れるボタン：Amazonカラー (#ffd814) --}}
                            <button type="submit"
                                class="w-full bg-[#ffd814] hover:bg-[#f7ca00] text-black text-[12px] py-2.5 rounded-full font-bold shadow-sm border border-[#adb1b8] transition active:scale-95">
                                カートに入れる
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection