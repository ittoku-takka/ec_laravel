<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'buy_number',
        'quantity',
        'title',
        'category',
        'price',
        'image',
        'billing_name',
        'billing_post_code',
        'billing_address1',
        'billing_address2',
        'billing_tel',
        'delivery_method',
        'payment_method'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}