@extends('layouts.app')

@section('title', $item->title)

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-1/2">
            <img src="{{ $item->image1 ?? 'https://via.placeholder.com/600' }}" alt="{{ $item->title }}"
                class="w-full h-auto object-cover rounded-lg border">
        </div>
        <div class="w-full md:w-1/2">
            <h1 class="text-3xl font-bold mb-4">{{ $item->title }}</h1>
            <p class="text-2xl text-red-600 font-bold mb-4">¥{{ number_format($item->price) }} <span
                    class="text-sm text-gray-500 font-normal">(税込)</span></p>
            <p class="text-gray-600 mb-6 leading-relaxed">{{ $item->detail }}</p>
            <p class="text-sm text-gray-500 mb-4 font-bold {{ $item->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                在庫: {{ $item->stock }}
            </p>

            <form action="{{ route('cart.add') }}" method="POST" class="bg-gray-50 p-4 rounded-lg border">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <div class="flex items-center gap-4 mb-4">
                    <label class="text-sm font-bold">数量:</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $item->stock }}"
                        class="border p-2 rounded w-20 shadow-sm focus:ring-blue-500">
                </div>
                <button type="submit"
                    class="w-full bg-[#ffd814] hover:bg-[#f7ca00] text-black py-3 rounded-full font-bold shadow-md border border-yellow-400 transition">
                    カートに追加する
                </button>
            </form>
        </div>
    </div>
@endsection