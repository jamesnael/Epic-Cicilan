<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Cluster extends Model
{
	use Sluggable, SoftDeletes;

    protected $fillable = ['cluster_name','slug'];



 public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['cluster_name'],
            ]
        ];
    }

public function getRouteKeyName()
    {
        return 'slug';
    }


}

