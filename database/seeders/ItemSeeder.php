<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run()
    {
        Item::create([
            'user_id' => 1,
            'title' => 'サンプル商品A',
            'category' => 1,
            'price' => 1200,
            'stock' => 50,
            'image1' => 'sample1.jpg',
            'image2' => 'sample1_2.jpg',
            'image3' => 'sample1_3.jpg',
            'image4' => null,
            'image5' => null,
            'image6' => null,
            'detail' => 'これはサンプル商品の詳細です。',
        ]);

        Item::create([
            'user_id' => 1,
            'title' => 'サンプル商品B',
            'category' => 2,
            'price' => 2500,
            'stock' => 30,
            'image1' => 'sample2.jpg',
            'image2' => 'sample2_2.jpg',
            'image3' => null,
            'image4' => null,
            'image5' => null,
            'image6' => null,
            'detail' => '別のサンプル商品の詳細です。',
        ]);
    }
}