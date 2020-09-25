<?php

namespace Modules\ActivityLog\Entities;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';
    protected $fillable = ['*'];

   public function getUser(){
       return $this->hasOne('Modules\AppUser\Entities\User','id','causer_id');
   }
 
   public function getSubject(){
       return $this->hasOne('Modules\AppUser\Entities\User','id','causer_id');
   }

}
