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
    	'point',
        'booking_status',
        'nup_amount',
        'utj_amount',
        'payment_method_nup',
        'nup_date',
        'utj_date',
        'main_coor_id',
        'regional_coor_id',
        'agent_id',
        'komisi_status',
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    protected $appends = [
        'total_cicilan',
        'total_pembayaran',
        'sisa_tunggakan',
        'total_denda',
        'tanggal_lunas_cicilan',
        'prosentase_pembayaran',
        // 'total_point',
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

    public function getTotalCicilanAttribute()
    {
        $collection = collect($this->payments)->sum(function($item) {
            if ($item->payment != 'Akad Kredit') {
                return ($item->installment?: 0);
            }
            return 0;
        });
        return $collection;
    }

    public function getTotalPembayaranAttribute()
    {
        $collection = collect($this->payments)->sum(function($item) {
            if ($item->payment_date) {
                return ($item->installment?: 0) + ($item->fine?: 0);
            }
            return 0;
        });
        return $collection;
    }

    public function getTotalDendaAttribute()
    {
        $collection = collect($this->payments)->sum(function($item) {
            if ($item->payment_date) {
                return ($item->fine?: 0);
            }
            return 0;
        });
        return $collection;
    }

    public function getSisaTunggakanAttribute()
    {
        $collection = collect($this->payments)->sum(function($item) {
            if ($item->payment != 'Akad Kredit') {
                return $item->installment;
            }
            return 0;
        });
        return $collection - $this->total_pembayaran;
    }

    public function getProsentasePembayaranAttribute()
    {
        if ($this->total_pembayaran && $this->total_denda) {
            return round(($this->total_pembayaran - $this->total_denda) / $this->total_cicilan * 100, 2) ;
        }
    }
    
    public function getTanggalLunasCicilanAttribute()
    {
        // return $collection = collect($this->payments)->last();
        $collection = collect($this->payments)->last(function($item) {
            if ($item->payment != 'Akad Kredit') {
                return $item;
            }
            return 0;
        });
        return $collection;
    }

    // public function getTotalPointAttribute()
    // {
    //     if($this->booking_status != 'dokumen' || $this->booking_status != 'spr')
    //     {
    //         $collection = collect($this->unit)->sum(function($item) {
    //             if (!empty($item->points)) {
    //                 return $item->points;
    //             }
    //             return 0;
    //         });
    //         return $collection;
    //     } else {
    //         return 0;
    //     }
    // }

    /**
     * Scope a query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCash($query)
    {
        return $query->where('payment_type', 'Hard Cash');
    }

    /**
     * Scope a query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInstallment($query)
    {
        return $query->where('payment_type', 'Installments');
    }

    /**
     * Scope a query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeKprKpa($query)
    {
        return $query->where('payment_type', 'KPR/KPA');
    }

    /**
     * Scope a query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBookingStatus($query, $status)
    {
        return $query->where('booking_status', $status);
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
    public function agency()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\Agency', 'agent_id');
    }

    /**
    * Get the relationship for the model.
    */
    public function main_coordinator()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\MainCoordinator', 'main_coor_id');
    }

    /**
    * Get the relationship for the model.
    */
    public function regional_coordinator()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\RegionalCoordinator', 'regional_coor_id');
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

    /**
     * Get the relations for the model.
     */
    public function unpaid_payments()
    {
        return $this->hasMany('Modules\Installment\Entities\BookingPayment', 'booking_id')
        ->whereNull('payment_date');
    }

    /**
     * Get the relations for the model.
     */
    public function document()
    {
        return $this->hasOne('Modules\DocumentClient\Entities\DocumentClient', 'booking_id');
    }


    public function ppjb()
    {
        return $this->hasOne('Modules\Installment\Entities\PPJB', 'booking_id');
    }

    /**
     * Get the relations for the model.
     */
    public function akad_kpr()
    {
        return $this->hasOne('Modules\Installment\Entities\AkadKpr', 'booking_id');
    }

    /**
     * Get the relations for the model.
     */
    public function ajb()
    {
        return $this->hasOne('Modules\Installment\Entities\AkteJualBeli', 'booking_id');
    }

     /**
     * Get the relations for the model.
     */
    public function spr()
    {
        return $this->hasOne('Modules\Installment\Entities\Spr', 'booking_id');
    }

    /**
     * Get the relations for the model.
     */
    public function handover()
    {
        return $this->hasOne('Modules\Installment\Entities\Handover', 'booking_id');
    }

    public function salespoint()
    {
        return $this->hasOne('Modules\RewardPoint\Entities\SalesPoint', 'booking_id');
    }

    public function subagentpoint()
    {
        return $this->hasOne('Modules\RewardPoint\Entities\SubAgentPoint', 'booking_id');
    }
    /**
     * Get the relations for the model.
     */
    public function commission()
    {
        return $this->hasOne('Modules\Commission\Entities\SalesCommission', 'booking_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function record()
    {
        return $this->hasMany('Modules\RewardPoint\Entities\RecordPoint', 'booking_id');
    }

}
