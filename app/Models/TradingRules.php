<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradingRules extends Model
{

    protected $table = 'trading_rules';

    protected $fillable = [
        'content',
    ];
}
