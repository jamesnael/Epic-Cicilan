<?php

namespace Modules\SalesAgent\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Agency extends Model
{
    use Notifiable, Sluggable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regional_coordinator_id',
        'agency_name',
        'agency_email',
        'agency_phone',
        'agency_address',
        'province',
        'city',
        'bank_name',
        'rek_number',
        'account_name',
        'pph_final',
        'id_commission',
        'id_sales_commission',
        'id_agency_commision',
        'id_regional_coordinator_commission',
        'id_main_coordinator_commission',
        'sales_commission',
        'agency_commission',
        'regional_coordinator_commission',
        'main_coordinator_commission',
        'commission_type',
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
                'source' => ['agency_name', 'province'],
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
    public function sales()
    {
        return $this->hasMany('Modules\SalesAgent\Entities\Sales', 'role_id');
    }

     /**
     * Get the relationship for the model.
     */
    public function regional_coordinator()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\RegionalCoordinator', 'regional_coordinator_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function point()
    {
        return $this->hasMany('Modules\RewardPoint\Entities\SubAgentPoint', 'sub_agent_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function booking()
    {
        return $this->hasMany('Modules\Installment\Entities\Booking', 'agent_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function exchange()
    {
        return $this->hasMany('Modules\RewardPoint\Entities\ExchangePointSubAgent', 'agency_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function user()
    {
        return $this->belongsTo('Modules\AppUser\Entities\User', 'user_id');
    }
}
