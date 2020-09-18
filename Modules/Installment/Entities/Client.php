<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{

	use Sluggable, SoftDeletes;

    protected $fillable = [
    	'slug',
    	'client_number',
    	'client_name',
    	'client_email',
    	'client_phone_number',
    	'client_mobile_number',
        'profession',
    	'client_address',
        'province',
        'city',
        'alamat_ktp',
        'no_ktp',
        'npwp',
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
                'source' => ['client_number', 'client_name'],
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
    public function client_bookings()
    {
        return $this->hasMany('Modules\Installment\Entities\Booking', 'client_id');
    }

}
