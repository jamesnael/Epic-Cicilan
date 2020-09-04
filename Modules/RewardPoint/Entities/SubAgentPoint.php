<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubAgentPoint extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'sub_agent_id',
    	'booking_id',
    	'point'
    ];

    /**
     * Get the relationship for the model.
     */
    public function agency()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\Agency', 'sub_agent_id');
    }
}
