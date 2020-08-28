<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spr extends Model
{
	use SoftDeletes;

    protected $fillable = ['booking_id', 'print_date', 'sent_date', 'received_date', 'approval_status'];

    /**
     * Get the relationship for the model.
     */
    public function bookings()
    {
        return $this->hasMany('Modules\Installment\Entities\Booking', 'client_id');
    }
}
