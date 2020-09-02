<?php

namespace Modules\SalesAgent\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainCoordinator extends Model
{

	use Sluggable, SoftDeletes;

    protected $fillable = [
        'slug', 
        'full_name', 
        'email', 
        'phone_number', 
        'address',
        'pph_final',
        'bank_name',
        'rek_number',
        'account_name'
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

    protected $appends = [
        'total_point'
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

    public function getTotalPointAttribute()
    {
        $collection = collect($this->point)->sum(function($item) {
            if (!empty($item->point)) {
                return $item->point;
            }
            return 0;
        });
        return $collection;
    }

    /**
     * Get the relationship for the model.
     */
    public function regional_coordinators()
    {
        return $this->hasMany('Modules\SalesAgent\Entities\RegionalCoordinator', 'main_coordinator_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function sales()
    {
        return $this->hasMany('Modules\SalesAgent\Entities\Sales', 'main_coordinator_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function point()
    {
        return $this->hasMany('Modules\RewardPoint\Entities\KoorUmumPoint', 'koordinator_umum_id');
    }
}
