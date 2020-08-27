<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AkadKpr extends Model
{
    protected $fillable = [
    	'booking_id',
    	'akad_date',
    	'akad_time',
    	'location',
    	'address',
    	'akad_doc_file_name',
    	'approval_client_status',
    	'approval_developer_status',
    	'approval_notaris_status',
    	'akad_sign_date',
    	'akad_doc_sign_file_name',
    ];

    protected $appends = [
        'url_akad_doc_file_name',
        'url_akad_doc_sign_file_name',
    ];

    /**
     * Get the model's url ktp pemohon file.
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlAkadDocFileNameAttribute()
    {
        return $this->attributes['akad_doc_file_name'] ? Storage::disk('public')->url('app/public/akad_kpr/dokumen_awal/'.$this->attributes['akad_doc_file_name']) : null;
    }

    /**
     *
     * Get the model's url ktp suami istri file.
     * @param  string  $value
     * @return string
     */
    public function getUrlAkadDocSignFileNameAttribute()
    {
        return $this->attributes['akad_doc_sign_file_name'] ? Storage::disk('public')->url('app/public/akad_kpr/dokumen_akhir/'.$this->attributes['akad_doc_sign_file_name']) : null;
    }

    /**
     * Get the relationship for the model.
     */
    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking', 'booking_id');
    }
}
