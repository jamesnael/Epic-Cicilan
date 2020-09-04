<?php

namespace Modules\Commission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SalesCommission extends Model
{
    protected $fillable = [
	    'booking_id',
        'agency_commission',
        'commission_1',
        'payment_date_1',
       	'invoice_commission_1',
       	'payment_proof_1',
        'commission_2',
        'payment_date_2',
       	'invoice_commission_2',
       	'payment_proof_2',
        'sales_id',
       	'sales_name',
        'closing_fee_sales',
       	'sales_bank_name',
       	'sales_no_rek',
       	'sales_bank_account',
        'sales_payment_date',
       	'sales_invoice',
       	'sales_evidence',
        'agency_id',
       	'agency_name',
        'closing_fee_agency',
        'agency_payment_date',
       	'agency_invoice',
       	'agency_evidence',
        'korwil_id',
       	'korwil_name',
        'closing_fee_korwil',
        'korwil_payment_date',
       	'korwil_invoice',
       	'korwil_evidence',
        'korut_id',
       	'korut_name',
        'closing_fee_korut',
        'korut_payment_date',
       	'korut_invoice',
       	'korut_evidence',
    ];

    protected $appends = [
        'url_payment_proof_one',
        'url_payment_proof_two',
        'url_sales_evidence',
        'url_agency_evidence',
        'url_korwil_evidence',
        'url_korut_evidence',
    ];

    /**
     * Get the relations for the model.
     */
    public function booking()
    {
        return $this->belongsTo('Modules\Installment\Entities\Booking');
    }

    /**
     * Get the model's image.
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlPaymentProofOneAttribute()
    {
        return $this->attributes['payment_proof_1'] ? Storage::disk('public')->url('app/public/Komisi/'.$this->attributes['payment_proof_1']) : '';
    }

    /**
     *
     * Get the model's image.
     * @param  string  $value
     * @return string
     */
    public function getUrlPaymentProofTwoAttribute()
    {
        return $this->attributes['payment_proof_2'] ? Storage::disk('public')->url('app/public/Komisi/'.$this->attributes['payment_proof_2']) : '';
    }

    /**
     *
     * Get the model's image.
     * @param  string  $value
     * @return string
     */
    public function getUrlSalesEvidenceAttribute()
    {
        return $this->attributes['sales_evidence'] ? Storage::disk('public')->url('app/public/Komisi/'.$this->attributes['sales_evidence']) : null;
    }

    /**
     *
     * Get the model's image.
     * @param  string  $value
     * @return string
     */
    public function getUrlAgencyEvidenceAttribute()
    {
        return $this->attributes['agency_evidence'] ? Storage::disk('public')->url('app/public/Komisi/'.$this->attributes['agency_evidence']) : null;
    }

    /**
     *
     * Get the model's image.
     * @param  string  $value
     * @return string
     */
    public function getUrlKorwilEvidenceAttribute()
    {
        return $this->attributes['korwil_evidence'] ? Storage::disk('public')->url('app/public/Komisi/'.$this->attributes['korwil_evidence']) : null;
    }

    /**
     *
     * Get the model's image.
     * @param  string  $value
     * @return string
     */
    public function getUrlKorutEvidenceAttribute()
    {
        return $this->attributes['korut_evidence'] ? Storage::disk('public')->url('app/public/Komisi/'.$this->attributes['korut_evidence']) : null;
    }
}
