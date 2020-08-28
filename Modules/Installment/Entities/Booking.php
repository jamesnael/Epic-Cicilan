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
    	'point'
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
        // 'prosentase_pembayaran',
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

    public function getTanggalLunasCicilanAttribute()
    {
        return $collection = collect($this->payments)->last()->payment_date;
    }

    // public function getProsentasePembayaranAttribute()
    // {
    //     \Log::info(json_encode([
    //         'total_pembayaran' => $this->total_pembayaran,
    //         'total_denda' => $this->total_denda,
    //         'total_cicilan' => $this->total_cicilan,
    //     ], JSON_PRETTY_PRINT));
    //     return round(($this->total_pembayaran - $this->total_denda) / $this->total_cicilan * 100, 2) ;
    // }

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
    public function document()
    {
        return $this->hasOne('Modules\DocumentClient\Entities\DocumentClient', 'booking_id');
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

}
