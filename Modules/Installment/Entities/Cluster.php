<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cluster extends Model
{
    protected $fillable = ['cluster_name'];
}
