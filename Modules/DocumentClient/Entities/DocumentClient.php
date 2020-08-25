<?php

namespace Modules\DocumentClient\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
    	'file_npwp',
    	'file_kk',
    	'file_surat_nikah',
    	'file_rekening_tabungan',
    	'file_slip_gaji',
        'file_keterangan_kerja',
        'file_tabungan_3_bulan_terakhir',
    	'file_rekening_koran',
    	'file_siup',
    	'file_tdp',
    	'file_akta',
    	'file_pengesahan',
    	'file_izin_praktek',
    	'file_sk_domisili',
    	'file_keterangan_usaha',
    	'file_spt',
        
    	'file_akta_lahir_ijazah',
    	'file_surat_rekomendasi',
    	'approval_agent',
    	'approval_developer',
    	'approval_agent_by',
    	'approval_developer_by',
    ];

    protected $appends = [
        'url_file_ktp_pemohon',
        'url_file_ktp_suami_istri',
        'url_file_kk',
        'url_file_surat_nikah',
        'url_file_npwp',
        'url_file_siup',
        'url_file_tdp',
        'url_file_akta',
        'url_file_pengesahan',
        'url_file_izin_praktek',
        'url_file_slip_gaji',
        'url_file_rekening_tabungan',
        'url_file_rekening_koran',
        'url_file_surat_rekomendasi',
        'url_file_sk_domisili',
        'url_file_keterangan_usaha',
        'url_file_spt',
        'url_file_keterangan_kerja',
        'url_file_tabungan_3_bulan_terakhir',
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
     * Get the model's url ktp pemohon file.
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlFileKtpPemohonAttribute()
    {
        return $this->attributes['file_ktp_pemohon'] ? Storage::disk('public')->url('app/public/document/ktp_pemohon/'.$this->attributes['file_ktp_pemohon']) : null;
    }

    /**
     *
     * Get the model's url ktp suami istri file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileKtpSuamiIstriAttribute()
    {
        return $this->attributes['file_ktp_suami_istri'] ? Storage::disk('public')->url('app/public/document/ktp_suami_istri/'.$this->attributes['file_ktp_suami_istri']) : null;
    }

    /**
     *
     * Get the model's url kk file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileKkAttribute()
    {
        return $this->attributes['file_kk'] ? Storage::disk('public')->url('app/public/document/kk/'.$this->attributes['file_kk']) : null;
    }

    /**
     *
     * Get the model's url surat nikah file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileSuratNikahAttribute()
    {
        return $this->attributes['file_surat_nikah'] ? Storage::disk('public')->url('app/public/document/surat_nikah/'.$this->attributes['file_surat_nikah']) : null;
    }

    /**
     *
     * Get the model's url npwp file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileNpwpAttribute()
    {
        return $this->attributes['file_npwp'] ? Storage::disk('public')->url('app/public/document/npwp/'.$this->attributes['file_npwp']) : null;
    }

    /**
     *
     * Get the model's url siup file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileSiupAttribute()
    {
        return $this->attributes['file_siup'] ? Storage::disk('public')->url('app/public/document/siup/'.$this->attributes['file_siup']) : null;
    }

    /**
     *
     * Get the model's url tdp file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileTdpAttribute()
    {
        return $this->attributes['file_tdp'] ? Storage::disk('public')->url('app/public/document/tdp/'.$this->attributes['file_tdp']) : null;
    }

    /**
     *
     * Get the model's url akta file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileAktaAttribute()
    {
        return $this->attributes['file_akta'] ? Storage::disk('public')->url('app/public/document/akta/'.$this->attributes['file_akta']) : null;
    }

    /**
     *
     * Get the model's url pengesahan file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFilePengesahanAttribute()
    {
        return $this->attributes['file_pengesahan'] ? Storage::disk('public')->url('app/public/document/pengesahan/'.$this->attributes['file_pengesahan']) : null;
    }

    /**
     *
     * Get the model's url izin praktek file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileIzinPraktekAttribute()
    {
        return $this->attributes['file_izin_praktek'] ? Storage::disk('public')->url('app/public/document/izin_praktek/'.$this->attributes['file_izin_praktek']) : null;
    }

    /**
     *
     * Get the model's url izin slip gaji file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileSlipGajiAttribute()
    {
        return $this->attributes['file_slip_gaji'] ? Storage::disk('public')->url('app/public/document/slip_gaji/'.$this->attributes['file_slip_gaji']) : null;
    }

    /**
     *
     * Get the model's url izin rekening tabungan file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileRekeningTabunganAttribute()
    {
        return $this->attributes['file_rekening_tabungan'] ? Storage::disk('public')->url('app/public/document/rekening_tabungan/'.$this->attributes['file_rekening_tabungan']) : null;
    }


    /**
     *
     * Get the model's url izin rekening koran file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileRekeningKoranAttribute()
    {
        return $this->attributes['file_rekening_koran'] ? Storage::disk('public')->url('app/public/document/rekening_koran/'.$this->attributes['file_rekening_koran']) : null;
    }

    /**
     *
     * Get the model's url izin surat rekomendasi file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileSuratRekomendasiAttribute()
    {
        return $this->attributes['file_surat_rekomendasi'] ? Storage::disk('public')->url('app/public/document/surat_rekomendasi/'.$this->attributes['file_surat_rekomendasi']) : null;
    }

    /**
     *
     * Get the model's url sk domisili file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileSkDomisiliAttribute()
    {
        return $this->attributes['file_sk_domisili'] ? Storage::disk('public')->url('app/public/document/sk_domisili/'.$this->attributes['file_sk_domisili']) : null;
    }

    /**
     *
     * Get the model's url keterangan_usaha file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileKeteranganUsahaAttribute()
    {
        return $this->attributes['file_keterangan_usaha'] ? Storage::disk('public')->url('app/public/document/keterangan_usaha/'.$this->attributes['file_keterangan_usaha']) : null;
    }

    /**
     *
     * Get the model's spt file.
     * @param  string  $value
     * @return string
     */
    public function getUrlFileSptAttribute()
    {
        return $this->attributes['file_spt'] ? Storage::disk('public')->url('app/public/document/spt/'.$this->attributes['file_spt']) : null;
    }

    /**
     *
     * Get the model's keterangan_kerja
     * @param  string  $value
     * @return string
     */
    public function getUrlFileKeteranganKerjaAttribute()
    {
        return $this->attributes['file_keterangan_kerja'] ? Storage::disk('public')->url('app/public/document/keterangan_kerja/'.$this->attributes['file_keterangan_kerja']) : null;
    }

    /**
     *
     * Get the model's tabungan 3 bulan terakhir
     * @param  string  $value
     * @return string
     */
    public function getUrlFileTabungan3BulanTerakhirAttribute()
    {
        return $this->attributes['file_tabungan_3_bulan_terakhir'] ? Storage::disk('public')->url('app/public/document/tabungan_3_bulan_terakhir/'.$this->attributes['file_tabungan_3_bulan_terakhir']) : null;
    }


    /**
     * Get the relations for the model.
     */
    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking');
    }
}
