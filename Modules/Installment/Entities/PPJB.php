<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPJB extends Model
{
	protected $table = "ppjbs";
    protected $fillable = ['ppjb_date',
    					   'ppjb_time',
    						'location',
    						'address',
    						'status_ppjb',
    						'approval_client_status',
    						'approval_developer_status',
    						'approval_notaris_status',
    						'ppjb_sign_date',
    						'booking_id',
                            'ppjb_doc_file_name',
                           'ppjb_doc_sign_file_name', 
    						'status_ppjb'
    					];

    protected $appends = [
        'url_file_doc',
        'url_file_doc_sign'
    ];


        public function getUrlFileDocAttribute()
    {
        return $this->attributes['ppjb_doc_file_name'] ? Storage::disk('public')->url('app/public/ppjb/suratPPJBAwal/'.$this->attributes['ppjb_doc_file_name']) : null;
    }

        public function getUrlFileDocSignAttribute()
    {
        return $this->attributes['ppjb_doc_sign_file_name'] ? Storage::disk('public')->url('app/public/ppjb/suratPPJBSigned/'.$this->attributes['ppjb_doc_sign_file_name']) : null;
    }



   public function document()
    {
        return $this->hasOne('Modules\DocumentClient\Entities\DocumentClient', 'booking_id');
    }

public function sales()
    {
        return $this->belongsTo('Modules\SalesAgent\Entities\Sales', 'sales_id');
    }

    /**
     * Get the relationship for the model.
     */
    public function client()
    {
        return $this->belongsTo('Modules\Installment\Entities\Client', 'client_id');
    }




}

