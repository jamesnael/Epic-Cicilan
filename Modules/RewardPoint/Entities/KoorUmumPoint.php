<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoorUmumPoint extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'koordinator_umum_id',
    	'booking_id',
    	'point',
    ];

    /**
     * Get the relationship for the model.
     */
    public function main_coordinator()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\MainCoordinator', 'koordinator_umum_id');
    }
}
