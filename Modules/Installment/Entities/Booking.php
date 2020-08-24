<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{

	use Sluggable, SoftDeletes;

    protected $fillable = [
    	'slug',
    	'unit_id',
    	'client_id',
        'sales_id',
    	'total_amount',
    	'ppn',
    	'payment_type',
    	'payment_method',
    	'dp_amount',
    	'first_payment',
    	'principal',
    	'installment',
    	'installment_time',
    	'due_date',
    	'credits',
        'amount',
    	'payment_method_utj',
    	'bank_name',
    	'card_number',
    	'point'
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
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['client.client_name', 'unit.unit_number'],
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the relationship for the model.
     */
    public function unit()
    {
        return $this->belongsTo('Modules\Installment\Entities\Unit', 'unit_id');
    }

     /**
     * Get the relationship for the model.
     */
    public function sales()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\Sales', 'sales_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function client()
    {
        return $this->belongsTo('Modules\Installment\Entities\Client', 'client_id');
    }

    /**
     * Get the relations for the model.
     */
    public function payments()
    {
        return $this->hasMany('Modules\Installment\Entities\BookingPayment', 'booking_id');
    }
}
