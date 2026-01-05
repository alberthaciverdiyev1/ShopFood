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


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

//    public function getProductAttribute()
//    {
//        $allProducts = products();
//        $productId = $this->product_id;
//
//        foreach ($allProducts as $product) {
//            if (!empty($product['id']) && $product['id'] == $productId) {
//                return $product;
//            }
//        }
//
//        return null;
//    }
}
