<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\Uri\Http;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getProductAttribute()
    {
        return Http::get("https://api.site.com/products/{$this->product_id}")->json();
    }
}
