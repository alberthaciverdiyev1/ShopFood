<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table = 'user_baskets';
    protected $fillable = ['user_id', 'product_id', 'quantity'];

}
