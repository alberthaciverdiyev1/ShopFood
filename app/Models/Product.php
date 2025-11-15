<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
        'external_ids' => 'array',
        'media' => 'array',
        'warehouses' => 'array',
        'all_fields' => 'array',
    ];
}
