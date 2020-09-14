<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AkteJualBeli extends Model
{
    protected $fillable = [
    	'booking_id',
    	'ajb_date',
    	'ajb_time',
    	'location',
    	'address',
    	'ajb_doc_file_name',
    	'approval_client_status',
    	'approval_developer_status',
    	'approval_notaris_status',
    	'ajb_sign_date',
    	'ajb_doc_sign_file_name',
    ];

    protected $appends = [
        'url_ajb_doc_file_name',
        'url_ajb_doc_sign_file_name',
    ];

    /**
     * Get the model's url ktp pemohon file.
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlAjbDocFileNameAttribute()
    {
        return (!empty($this->attributes['ajb_doc_file_name'])) ? Storage::disk('public')->url('app/public/ajb/dokumen_awal/'.$this->attributes['ajb_doc_file_name']) : null;
    }

    /**
     *
     * Get the model's url ktp suami istri file.
     * @param  string  $value
     * @return string
     */
    public function getUrlAjbDocSignFileNameAttribute()
    {
        return (!empty($this->attributes['ajb_doc_sign_file_name'])) ? Storage::disk('public')->url('app/public/ajb/dokumen_akhir/'.$this->attributes['ajb_doc_sign_file_name']) : null;
    }

    /**
     * Get the relationship for the model.
     */
    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking', 'booking_id');
    }
}
