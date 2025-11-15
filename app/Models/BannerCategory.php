<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerCategory extends Model
{
    use SoftDeletes;
    protected $table = 'banner_categories';
    protected $guarded = [];
}
