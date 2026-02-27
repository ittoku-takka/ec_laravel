<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // 設計書通り：user_id, item_id, quantity
    protected $fillable = [
        'user_id',
        'item_id',
        'quantity'
    ];

    // 設計書：item_idでitemsテーブルから情報を引っ張る
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // 設計書：user_idでusersテーブルから請求先情報を引っ張る
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}