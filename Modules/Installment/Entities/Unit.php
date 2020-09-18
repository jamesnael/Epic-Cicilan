<?php

namespace Modules\Installment\Entities;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
	use Sluggable, SoftDeletes;

    protected $fillable = [
    	'slug',
    	'unit_type',
    	'unit_number',
    	'unit_block',
        'unit_address',
    	'surface_area',
    	'building_area',
    	'floor_name',
    	'floorplan_image',
    	'points',
    	'electrical_power',
    	'utj',
    	'closing_fee',
    	'available',
        'id_unit_type'
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
                'source' => ['unit_number', 'unit_block'],
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
    public function unit_bookings()
    {
        return $this->hasMany('Modules\Installment\Entities\Booking', 'unit_id');
    }
}
