<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ID:1 - テスト太郎（管理者1）
        User::create([
            'name' => 'kanri',
            'email' => 'kanri@techis.jp',
            'password' => Hash::make('testkanri'),
            'billing_name' => 'テスト太郎',
            'billing_post_code' => '1234567',
            'billing_address1' => '東京都渋谷区',
            'role' => 1, // 管理者権限
            'delete_flg' => 0,
        ]);

        // ID:2 - kanri2（管理者2）
        User::create([
            'name' => 'kanri2',
            'email' => 'kanri2@techis.jp',
            'password' => Hash::make('testkanri2'),
            'role' => 1, // 管理者権限
            'delete_flg' => 0,
        ]);
    }
}