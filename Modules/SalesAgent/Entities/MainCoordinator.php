<?php

namespace Modules\SalesAgent\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MainCoordinator extends Model
{

	use Notifiable, Sluggable, SoftDeletes;

    protected $fillable = [
        'slug', 
        'full_name', 
        'email', 
        'phone_number', 
        'address',
        'pph_final',
        'bank_name',
        'rek_number',
        'account_name',
        'principal',
        'no_hp_principal',
        'ppn',
        'pph_21',
        'pph_23',
        'user_id'
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
        'total_point',
        'allowed_point',
        'exchanged_point',
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
        $collection = collect($this->booking)->sum(function($item) {
            if($item->booking_status != 'dokumen' && $item->booking_status != 'spr'){
                if (!empty($item->unit->points)) {
                    return $item->unit->points;
                }
                return 0;
            } else {
                return 0;
            }
        });
        return $collection;
    }

    public function getAllowedPointAttribute()
    {
        $collection = collect($this->booking)->sum(function($item) {
            if($item->komisi_status == 'Pembayaran 2' || $item->komisi_status == 'Closing Fee'){
                if (!empty($item->unit->points)) {
                    return $item->unit->points;
                }
                return 0;
            } else {
                return 0;
            }
        });
        return $collection;
    }


    public function getExchangedPointAttribute()
    {
        $collection = collect($this->exchange)->sum(function($item) {
            if (!empty($item->exchange_point)) {
                return $item->exchange_point;
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

    /**
     * Get the relationship for the model.
     */
    public function booking()
    {
        return $this->hasMany('Modules\Installment\Entities\Booking', 'main_coor_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function exchange()
    {
        return $this->hasMany('Modules\RewardPoint\Entities\ExchangePointKoorUmum', 'main_coordinator_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function user()
    {
        return $this->belongsTo('Modules\AppUser\Entities\User', 'user_id');
    }
}
