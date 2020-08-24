<?php

namespace Modules\DocumentClient\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentClient extends Model
{
	use Sluggable, SoftDeletes;

    protected $fillable = [
    	'slug',
    	'booking_id',
    	'submission_date',
    	'client_profesion',
    	'file_ktp_pemohon',
    	'file_ktp_suami_istri',
    	'file_kk',
    	'file_surat_nikah',
    	'file_akta_lahir_ijazah',
    	'file_npwp',
    	'file_siup',
    	'file_tdp',
    	'file_akta',
    	'file_pengesahan',
    	'file_izin_praktek',
    	'file_slip_gaji',
    	'file_rekening_tabungan',
    	'file_rekening_koran',
    	'file_surat_rekomendasi',
    	'file_sk_domisili',
    	'file_keterangan_usaha',
    	'file_spt',
        'file_keterangan_kerja',
        'file_tabungan_3_bulan_terakhir',
    	'approval_agent',
    	'approval_developer',
    	'approval_agent_by',
    	'approval_developer_by',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['slug_name'],
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the model's slug_name.
     *
     * @return string
     */
    public function getSlugNameAttribute()
    {
        return 'document-' . $this->attributes['booking_id'];
    }

    /**
     * Get the relations for the model.
     */
    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking');
    }
}
