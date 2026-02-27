<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    public function run()
    {
        Cart::create([
            'user_id' => 1,
            'item_id' => 1,
            'quantity' => 2,
        ]);

        Cart::create([
            'user_id' => 1,
            'item_id' => 2,
            'quantity' => 1,
        ]);
    }
}