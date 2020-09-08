<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class BookingPayment extends Model
{
    use Sluggable;

    protected $fillable = [
    	'slug',
    	'booking_id',
    	'payment',
    	'due_date',
        'sp1_date',
        'sp2_date',
        'sp3_date',
    	'installment',
    	'credit',
    	'payment_status',
    	'payment_date',
    	'payment_method',
    	'va_number',
    	'total_paid',
    	'number_of_delays',
    	'fine',

        'pg_number',
        'paid_mail',
        'notification_mail_7',
        'notification_mail_1',
        'notification_mail_sp1',
        'notification_mail_sp2',
        'notification_mail_sp3',
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
                'source' => ['booking_id', uniqid()],
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
     * Get the relations for the model.
     */
    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking');
    }
}
