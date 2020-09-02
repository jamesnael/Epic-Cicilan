<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;

class ExchangePointSales extends Model
{
    protected $fillable = [
    	'sales_point_id',
    	'reward_point_id',
    	'exchange_point'

    ];
}
