<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangePointKoorUmum extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'reward_point_id',
    	'main_coordinator_id',
    	'exchange_point',
    ];
}
