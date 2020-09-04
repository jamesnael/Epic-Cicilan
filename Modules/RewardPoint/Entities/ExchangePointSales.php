<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangePointSales extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'sales_id',
    	'reward_point_id',
    	'exchange_point'
    ];

    public function sales_point()
    {
        return $this->belongsTo('Modules\RewardPoint\Entities\SalesPoint', 'sales_id');
    }

    public function reward_point()
    {
        return $this->belongsTo('Modules\RewardPoint\Entities\RewardPoint', 'reward_point_id');
    }
}
