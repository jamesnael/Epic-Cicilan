<?php

namespace Modules\Installment\Http\Controllers\Booking;

class BookingHelper
{
    /**
     *
     * Save Booking Payments
     *
     */
    public function saveBookingPayments($booking)
    {
        $booking->payments()->delete();

        switch ($booking->payment_type) {
            case 'Hard Cash':
                $payments = $this->saveHardCashPayments($booking);
                break;
            
            case 'Installments':
                $payments = $this->saveInstallmentsPayments($booking);
                break;
            
            default:
                $payments = $this->saveKprKpaPayments($booking);
                break;
        }

        $booking->payments()->createMany($payments);
    }

    /**
     *
     * Save Hard Cash Payments
     *
     */
    public function saveHardCashPayments($booking)
    {
        $payments = [];
        $payment = [];
        $payment['payment'] = 'Uang Tanda Jadi';
        $payment['due_date'] = null;
        $payment['installment'] = $booking->nup_amount + $booking->utj_amount;
        $payment['credit'] = $booking->principal;
        $payment['payment_status']= 'Unpaid';
        $payment['payment_date']= \Carbon\Carbon::parse($booking->utj_date)->format('Y-m-d');

        $payments[] = $payment;

        $credits = $booking->principal;
        $mth = $booking->due_date == \Carbon\Carbon::now()->day ? 1 : 0;
        for ($i = 1; $i <= $booking->installment_time; $i++) {
            if ($i == 1) {
                $credits = $credits - $booking->first_payment;
            } else {
                $credits = $credits - $booking->installment;
            }            
            $date = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth));
            $payment = [];
            $payment['payment'] = 'Pembayaran ' . ($i*1 + 1);
            $payment['due_date'] = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth))->format('Y-m-d');
            $payment['sp1_date'] = $date->addDays(option('sp1_date', 14))->format('Y-m-d');
            $payment['sp2_date'] = $date->addDays(option('sp2_date', 21))->format('Y-m-d');
            $payment['sp3_date'] = $date->addDays(option('sp3_date', 28))->format('Y-m-d');
            $payment['installment'] = $i == 1 ? $booking->first_payment : ($i == $booking->installment_time ? $booking->installment + $credits : $booking->installment);
            $payment['credit'] = $i == $booking->installment_time ? 0 : $credits;
            $payments[] = $payment;
            $mth++;
        }

        return $payments;
    }

    /**
     *
     * Save Installments Payments
     *
     */
    public function saveInstallmentsPayments($booking)
    {
        $payments = [];
        $payment = [];
        $payment['payment'] = 'Uang Tanda Jadi';
        $payment['due_date'] = null;
        $payment['installment'] = $booking->nup_amount + $booking->utj_amount;
        $payment['credit'] = $booking->principal;
        $payment['payment_status']= 'Unpaid';
        $payment['payment_date']= \Carbon\Carbon::parse($booking->utj_date)->format('Y-m-d');

        $payments[] = $payment;

        $credits = $booking->principal;
        $mth = $booking->due_date == \Carbon\Carbon::now()->day ? 1 : 0;
        for ($i = 1; $i <= $booking->installment_time; $i++) {
            if ($i == 1) {
                $credits = $credits - $booking->first_payment;
            } else {
                $credits = $credits - $booking->installment;
            }
            $date = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth));
            $payment = [];
            $payment['payment'] = 'Cicilan ' . $i;
            $payment['due_date'] = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth))->format('Y-m-d');
            $payment['sp1_date'] = $date->addDays(option('sp1_date', 14))->format('Y-m-d');
            $payment['sp2_date'] = $date->addDays(option('sp2_date', 21))->format('Y-m-d');
            $payment['sp3_date'] = $date->addDays(option('sp3_date', 28))->format('Y-m-d');
            $payment['installment'] = $i == 1 ? $booking->first_payment : ($i == $booking->installment_time ? $booking->installment + $credits : $booking->installment);
            $payment['credit'] = $i == $booking->installment_time ? 0 : $credits;
            $payments[] = $payment;
            $mth++;
        }

        return $payments;
    }

    /**
     *
     * Save KPR / KPA Payments
     *
     */
    public function saveKprKpaPayments($booking)
    {
        $payments = [];
        $payment = [];
        $payment['payment'] = 'Uang Tanda Jadi';
        $payment['due_date'] = null;
        $payment['installment'] = $booking->nup_amount + $booking->utj_amount;
        $payment['credit'] = $booking->principal;
        $payment['payment_status']= 'Unpaid';
        $payment['payment_date']= \Carbon\Carbon::parse($booking->utj_date)->format('Y-m-d');
        
        $payments[] = $payment;

        $credits = $booking->principal;
        $mth = $booking->due_date == \Carbon\Carbon::now()->day ? 1 : 0;
        for ($i = 1; $i <= $booking->installment_time; $i++) {
            if ($i == 1) {
                $credits = $credits - $booking->first_payment;
            } else {
                $credits = $credits - $booking->installment;
            }
            $date = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth));
            $payment = [];
            $payment['payment'] = 'Cicilan DP ' . $i;
            $payment['due_date'] = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth))->format('Y-m-d');
            $payment['sp1_date'] = $date->addDays(option('sp1_date', 14))->format('Y-m-d');
            $payment['sp2_date'] = $date->addDays(option('sp2_date', 21))->format('Y-m-d');
            $payment['sp3_date'] = $date->addDays(option('sp3_date', 28))->format('Y-m-d');
            $payment['installment'] = $i == 1 ? $booking->first_payment : ($i == $booking->installment_time ? $booking->installment + $credits : $booking->installment);
            $payment['credit'] = $i == $booking->installment_time ? 0 : $credits;
            $payments[] = $payment;
            $mth++;
        }

        $payment = [];
        $payment['payment'] = 'Akad Kredit';
        $payment['due_date'] = null;
        $payment['installment'] = $booking->credits;
        $payment['credit'] = $booking->credits;
        $payments[] = $payment;

        return $payments;
    }
}
