<?php

namespace Modules\SalesAgent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sales extends Model
{
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
        'status'
    ];

    protected $appends = [
        'url_file_ktp',
        'url_file_npwp'
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
    public function getUrlFileNpwpAttribute()
    {
        return $this->attributes['file_npwp'] ? Storage::disk('public')->url('app/public/sales/npwp/'.$this->attributes['file_npwp']) : null;
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

}
