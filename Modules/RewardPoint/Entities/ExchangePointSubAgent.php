<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangePointSubAgent extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'agency_id',
    	'reward_point_id',
    	'exchange_point'
    ];
}
