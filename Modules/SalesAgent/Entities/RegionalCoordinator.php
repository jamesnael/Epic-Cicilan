<?php

namespace Modules\SalesAgent\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegionalCoordinator extends Model
{

	use Sluggable, SoftDeletes;

    protected $fillable = ['slug','main_coordinator_id' , 'full_name', 'email', 'phone_number', 'address','pph_final'];

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
                'source' => ['full_name'],
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
    public function main_coordinator()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\MainCoordinator', 'main_coordinator_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function agency()
    {
        return $this->hasMany('Modules\SalesAgent\Entities\Agency', 'regional_coordinator_id');
    }
    
}
