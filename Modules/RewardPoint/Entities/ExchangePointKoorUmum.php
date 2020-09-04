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

    public function main_coordinator()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\MainCoordinator', 'main_coordinator_id');
    }

    public function reward_point()
    {
        return $this->belongsTo('Modules\RewardPoint\Entities\RewardPoint', 'reward_point_id');
    }
}
