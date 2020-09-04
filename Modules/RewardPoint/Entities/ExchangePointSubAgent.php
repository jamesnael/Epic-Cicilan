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

    public function agency()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\Agency', 'agency_id');
    }

    public function reward_point()
    {
        return $this->belongsTo('Modules\RewardPoint\Entities\RewardPoint', 'reward_point_id');
    }
}
