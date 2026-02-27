<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. まずUserSeederを呼ぶ（ここでテスト太郎が作られる）
        // 2. 次に商品(Item)を作る
        // 3. 最後にそれらを紐付けたカート(Cart)を作る
        $this->call([
            UserSeeder::class,      // ここで「テスト太郎」が作られる
            ItemSeeder::class,      // 商品A、商品Bが作られる
            CartSeeder::class,      // 太郎のカートに商品が入る
            BuyHistorySeeder::class,
        ]);
    }
}