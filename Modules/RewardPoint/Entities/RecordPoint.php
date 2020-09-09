<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecordPoint extends Model
{
	use SoftDeletes;

	protected $fillable = ['booking_id'];
	protected $appends  = ['total_point'];
    /**
     * Get the relationship for the model.
     */

    public function getTotalPointAttribute()
    {
        $collection = collect($this->booking->unit)->sum(function($item) {
            if (!empty($item->points)) {
                return $item->points;
            }
            return 0;
        });
    }

    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking', 'booking_id');
    }
}
