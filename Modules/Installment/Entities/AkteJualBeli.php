<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;

class AkteJualBeli extends Model
{
    protected $fillable = [
    	'booking_id',
    	'ajb_date',
    	'ajb_time',
    	'location',
    	'address',
    	'ajb_doc_file_name',
    	'approval_client_status',
    	'approval_developer_status',
    	'approval_notaris_status',
    	'ajb_sign_date',
    	'ajb_doc_sign_file_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Get the relationship for the model.
     */
    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking', 'booking_id');
    }
}
