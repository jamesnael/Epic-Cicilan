<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;

class ExchangePointSubAgent extends Model
{
    protected $fillable = [

    	'sub_agent_point_id',
    	'reward_point_id',
    	'exchange_point'

    ];
}
