<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'billing_name' => 'テスト太郎',
            'billing_post_code' => 1234567,
            'billing_address1' => '東京都渋谷区神南1-1-1',
            'billing_address2' => 'テックビル 5F',
            'billing_tel' => '09012345678',
            'role' => 1, // 管理者
            'delete_flg' => 0,
        ]);
    }
}