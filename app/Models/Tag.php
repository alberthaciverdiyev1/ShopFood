<?php

namespace Modules\Keyword\Http\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['key', 'value'];
}
