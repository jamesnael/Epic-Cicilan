<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangePointKoorWilayah extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'reward_point_id',
    	'regional_coordinator_id',
    	'exchange_point',
    ];

    public function regional_coordinator()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\RegionalCoordinator', 'regional_coordinator_id');
    }

    public function reward_point()
    {
        return $this->belongsTo('Modules\RewardPoint\Entities\RewardPoint', 'reward_point_id');
    }
}
