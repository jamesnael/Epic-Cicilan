<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoorWilayahPoint extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'koordinator_wilayah_id',
    	'booking_id',
    	'point',
    ];
}
