@extends('layouts.app')

@section('title', 'ご購入ありがとうございました')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 text-center">
        <div class="bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            {{-- チェックマークアイコン --}}
            <div class="flex justify-center mb-6">
                <div class="bg-green-100 p-4 rounded-full">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-4">ご注文ありがとうございました！</h1>
            <p class="text-gray-600 mb-8">
                商品の発送準備が整い次第、メールにてお知らせいたします。<br>
                お手元に届くまで今しばらくお待ちください。
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('item_list') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">
                    お買い物を続ける
                </a>
                <a href="{{ route('buy_history') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-8 rounded-lg transition">
                    購入履歴を見る
                </a>
            </div>
        </div>
    </div>
@endsection