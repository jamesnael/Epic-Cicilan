<?php

namespace Modules\Commission\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{

	use Sluggable, SoftDeletes;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'slug',
        'sales_commission',
        'agency_commission',
        'regional_coordinator_commission',
        'main_coordinator_commission',
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
                'source' => ['slug_name'],
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
     * Get the model's slug_name.
     *
     * @return string
     */
    public function getSlugNameAttribute()
    {
        return 'komisi-' . $this->attributes['main_coordinator_commission'];
    }
   
}
