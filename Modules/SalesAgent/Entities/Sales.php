<?php

namespace Modules\SalesAgent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;

class Sales extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'agency_id',
        'sales_nip',
        'file_ktp',
        'file_npwp',
        'main_coordinator_id',
        'regional_coordinator_id',
        'sales_commission',
        'agency_commission',
        'regional_coordinator_commission',
        'main_coordinator_commission',
        'status',
        'no_ktp'
    ];

    protected $appends = [
        'url_file_ktp',
        // 'url_file_npwp',
        'total_point',
        'allowed_point',
        'exchanged_point',
    ];

    /**
     * Get the model's url ktp image.
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlFileKtpAttribute()
    {
        return $this->attributes['file_ktp'] ? Storage::disk('public')->url('app/public/sales/ktp/'.$this->attributes['file_ktp']) : null;
    }

    /**
     *
     * Get the model's url npwp image.
     * @param  string  $value
     * @return string
     */
    // public function getUrlFileNpwpAttribute()
    // {
    //     return $this->attributes['file_npwp'] ? Storage::disk('public')->url('app/public/sales/npwp/'.$this->attributes['file_npwp']) : null;
    // }

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
    public function agency()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\Agency', 'agency_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function user()
    {
        return $this->belongsTo('Modules\AppUser\Entities\User', 'user_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function booking()
    {
        return $this->hasMany('Modules\Installment\Entities\Booking', 'sales_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function exchange()
    {
        return $this->hasMany('Modules\RewardPoint\Entities\ExchangePointSales', 'sales_id');
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
    public function regional_coordinator()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\RegionalCoordinator', 'regional_coordinator_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function point()
    {
        return $this->hasMany('Modules\RewardPoint\Entities\SalesPoint');
    }
}
