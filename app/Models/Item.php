<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',    // ★ 出品者ID（必須！）
        'title',      // 商品名
        'category',   // カテゴリー
        'price',      // 値段
        'stock',      // 在庫
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'image6',
        'description', // ★ 設計図を description にした場合はここも合わせる
        'delete_flg'
    ];

    /**
     * この商品を出品したユーザー（管理者）を取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cartとの関係
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // BuyHistoryとの関係
    public function buyHistories()
    {
        return $this->hasMany(BuyHistory::class);
    }

    // 商品の1枚目の画像を自動で取得する設定
    public function getMainImageAttribute()
    {
        return $this->image1 ?: ($this->image2 ?: 'no_image.jpg');
    }
}