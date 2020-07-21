<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardPoint extends Model
{
	use Sluggable,SoftDeletes;

    protected $fillable = [
	    'category_reward_id',
	    'reward_name',
	    'redeem_point',
	    'kuota',
	    'description',
	    'status'
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
                'source' => ['reward_name', 'redeem_point'],
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
    public function category()
    {
        return $this->belongsTo('Modules\RewardCategory\Entities\RewardCategory', 'category_reward_id');
    }
}
