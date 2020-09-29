<?php

namespace Modules\Installment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

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
        'no_bast',
        'nama_petugas'
    ];

    protected $appends = [
        'url_doc_file_name',
        'url_doc_sign_file_name',
    ];

    /**
     * Get the model's url ktp pemohon file.
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlDocFileNameAttribute()
    {
        return (!empty($this->attributes['handover_doc_file_name'])) ? Storage::disk('public')->url('app/public/handover/handover_doc_file_names/'.$this->attributes['handover_doc_file_name']) : null;
    }

    /**
     *
     * Get the model's url ktp suami istri file.
     * @param  string  $value
     * @return string
     */
    public function getUrlDocSignFileNameAttribute()
    {
        return (!empty($this->attributes['handover_doc_sign_name'])) ? Storage::disk('public')->url('app/public/handover/handover_doc_sign_names/'.$this->attributes['handover_doc_sign_name']) : null;
    }

    /**
     * Get the relationship for the model.
     */
    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking', 'booking_id');
    }
}
