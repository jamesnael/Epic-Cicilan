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

        $payments = $this->saveBookingInstallments($booking);
        $booking->payments()->delete();

        $booking->payments()->createMany($payments);
    }

    /**
     *
     * Save Hard Cash Payments
     *
     */
    public function saveBookingInstallments($booking)
    {
        $payments = [];
        $payment = [];
        $payment['payment'] = 'UTJ + NUP';
        $payment['due_date'] = \Carbon\Carbon::parse($booking->utj_date)->format('Y-m-d');
        $payment['installment'] = $booking->nup_amount + $booking->utj_amount;
        $payment['credit'] = $booking->payment_type == 'KPR/KPA' ? $booking->dp_amount - $booking->nup_amount - $booking->utj_amount : $booking->total_amount - $booking->nup_amount - $booking->utj_amount;
        $payment['payment_status']= 'Paid';
        $payment['payment_date']= \Carbon\Carbon::parse($booking->utj_date)->format('Y-m-d');
        $payment['payment_method'] = $booking->payment_method_utj;
        $payment['total_paid'] = $booking->nup_amount + $booking->utj_amount;

        $payments[] = $payment;

        $credits = $booking->payment_type == 'KPR/KPA' ? $booking->dp_amount - $booking->nup_amount - $booking->utj_amount : $booking->total_amount - $booking->nup_amount - $booking->utj_amount;
        // $mth = $booking->due_date == \Carbon\Carbon::now()->day ? 1 : 0;
        $mth = 0;

        for ($i = 1; $i <= $booking->installment_time; $i++) {
            if (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') {
                $credits = $credits - $booking->payments[$i]->installment;

                $payment = [];
                $payment['payment'] = $booking->payments[$i]->payment;
                $payment['due_date'] = $booking->payments[$i]->due_date;
                $payment['sp1_date'] = $booking->payments[$i]->sp1_date;
                $payment['sp2_date'] = $booking->payments[$i]->sp2_date;
                $payment['sp3_date'] = $booking->payments[$i]->sp3_date;
                $payment['installment'] = $booking->payments[$i]->installment;
                $payment['credit'] = $booking->payments[$i]->credit;
                $payment['payment_status'] = $booking->payments[$i]->payment_status;
                $payment['payment_date'] = $booking->payments[$i]->payment_date;
                $payment['payment_method'] = $booking->payments[$i]->payment_method;
                $payment['va_number'] = $booking->payments[$i]->va_number;
                $payment['total_paid'] = $booking->payments[$i]->total_paid;
                $payment['number_of_delays'] = $booking->payments[$i]->number_of_delays;
                $payment['fine'] = $booking->payments[$i]->fine;
                $payment['notification_mail_7'] = $booking->payments[$i]->notification_mail_7;
                $payment['notification_mail_1'] = $booking->payments[$i]->notification_mail_1;
                $payment['notification_mail_sp1'] = $booking->payments[$i]->notification_mail_sp1;
                $payment['notification_mail_sp2'] = $booking->payments[$i]->notification_mail_sp2;
                $payment['notification_mail_sp3'] = $booking->payments[$i]->notification_mail_sp3;
                $payment['pg_number'] = $booking->payments[$i]->pg_number;
                $payments[] = $payment;
                $mth++;
            } else {
                // if (!isset($booking->payments[$i])) {
                //     $mth++;
                // }
                if ($i == 1) {
                    $credits = $credits - $booking->first_payment;
                } else {
                    $credits = $credits - $booking->installment;
                }            
                $date = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth));
                $payment = [];
                if ($booking->payment_type == 'Hard Cash') {
                    $payment['payment'] = 'Pembayaran ' . $i;
                } elseif ($booking->payment_type == 'KPR/KPA') {
                    $payment['payment'] = 'Cicilan DP ' . $i;
                } else {
                    $payment['payment'] = 'Cicilan ' . $i;
                }
                $payment['due_date'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->due_date : \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth))->format('Y-m-d');
                $payment['sp1_date'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->sp1_date : $date->addDays(option('sp1_date', 14))->format('Y-m-d');
                $payment['sp2_date'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->sp2_date : $date->addDays(option('sp2_date', 21))->format('Y-m-d');
                $payment['sp3_date'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->sp3_date : $date->addDays(option('sp3_date', 28))->format('Y-m-d');
                $payment['installment'] = $i == 1 ? $booking->first_payment : ($i == $booking->installment_time ? $booking->installment + $credits : $booking->installment);
                $payment['credit'] = $i == $booking->installment_time ? 0 : $credits;
                $payment['payment_status'] = 'Unpaid';

                $payment['number_of_delays'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->number_of_delays : null;
                $payment['fine'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->fine : null;

                $payment['notification_mail_7'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->notification_mail_7 : null;
                $payment['notification_mail_1'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->notification_mail_1 : null;
                $payment['notification_mail_sp1'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->notification_mail_sp1 : null;
                $payment['notification_mail_sp2'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->notification_mail_sp2 : null;
                $payment['notification_mail_sp3'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->notification_mail_sp3 : null;
                $payment['pg_number'] = (isset($booking->payments[$i]) && $booking->payments[$i]->payment_status == 'Paid') ? $booking->payments[$i]->pg_number : null;

                $payments[] = $payment;
            }
            $mth++;
        }

        if ($booking->payment_type == 'KPR/KPA') {
            $payment = [];
            $payment['payment'] = 'Akad Kredit';
            $payment['due_date'] = null;
            $payment['installment'] = $booking->credits;
            $payment['credit'] = $booking->credits;
            $payments[] = $payment;
        }

        return $payments;
    }
}
