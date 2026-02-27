<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'price',
        'stock',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'image6',
        'detail',
        'user_id'
    ];

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
        // もし image1 が空なら image2、それも空なら no_image を出す
        return $this->image1 ?: $this->image2 ?: 'no_image.jpg';
    }
}