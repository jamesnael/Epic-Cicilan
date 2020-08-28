<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Handover extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'booking_id',
    	'handover_date',
        'time',
        'location',
        'address',
        'handover_doc_file_name',
        'approval_client_status',
        'approval_developer_status',
        'approval_notaris_status',
        'handover_doc_sign_name',
        'handover_sign_date',
    ];
}
