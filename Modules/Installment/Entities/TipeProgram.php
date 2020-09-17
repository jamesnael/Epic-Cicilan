<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipeProgram extends Model
{
    use Sluggable, SoftDeletes;

    protected $fillable = [
    	'slug',
    	'nama_program',
    	'harga_termasuk',
    	'harga_tidak_termasuk',
    	'gimmick',
    	'keterangan',
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
        'harga_termasuk' => 'array',
        'harga_tidak_termasuk' => 'array',
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
                'source' => ['nama_program'],
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
    public function bookings()
    {
        return $this->hasMany('Modules\Installment\Entities\Booking', 'program_id');
    }
}
