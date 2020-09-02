<?php

namespace Modules\RewardPoint\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;


class SalesPoint extends Model
{
	use Sluggable,SoftDeletes;



    protected $fillable = [
    	'sales_id',
    	'booking_id',
    	'point'

    ];
}
