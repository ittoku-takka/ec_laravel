<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // 太郎さんの商品 (user_id: 1)
        Item::create([
            'user_id' => 1,
            'title' => '太郎の出品：サンプルA',
            'category' => 'ペン',
            'price' => 1200,
            'stock' => 50,
            'image1' => 'sample1.jpg',
            'description' => 'これはID:1（太郎）が管理する商品です。',
        ]);

        // kanri2さんの商品 (user_id: 2)
        Item::create([
            'user_id' => 2,
            'title' => 'kanri2の出品：サンプルB',
            'category' => 'ノート',
            'price' => 2500,
            'stock' => 30,
            'image1' => 'sample2.jpg',
            'description' => 'これはID:2（kanri2）が管理する商品です。',
        ]);
    }
}