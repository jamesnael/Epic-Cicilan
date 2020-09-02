<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;

class SubAgentPoint extends Model
{
    protected $fillable = [

    	'sub_agent_id',
    	'booking_id',
    	'point'
    ];
}
