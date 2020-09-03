<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPoint extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'sales_id',
    	'booking_id',
    	'point'
    ];

    /**
     * Get the relationship for the model.
     */
    public function sales()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\Sales', 'sales_id');
    }
}
