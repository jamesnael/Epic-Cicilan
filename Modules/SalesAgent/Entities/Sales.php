<?php

namespace Modules\SalesAgent\Entities;

use Illuminate\Database\Eloquent\Model;

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
        'main_coordinator_commission'
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
