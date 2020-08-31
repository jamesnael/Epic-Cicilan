<?php

namespace Modules\Installment\Http\Controllers\Booking;

class BookingHelper
{
    /**
     *
     * Handle negotiate booking
     *
     */
    public function saveInstallment($request)
    {
        $booking = Booking::findByHash($request->input('hashid'));
        $booking->update([
            'total_amount' => $request->input('total_amount'),
            'ppn' => $request->input('ppn'),
            'payment_method' => $request->input('payment_method'),
            'dp_amount' => $request->input('dp_amount'),
            'installment' => $request->input('installment'),
            'installment_time' => $request->input('installment_time'),
            'due_date' => $request->input('due_date'),
        ]);

        $booking->client()->update(['status' => 6]);

        return $booking;
    }

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
        $payment['due_date'] = \Carbon\Carbon::now()->format('Y-m-d');
        $payment['installment'] = $booking->unit->utj;
        $payment['credit'] = $booking->principal;
        $payment['installment'] =$booking->installment;
        $payment['credit']= $booking->credits;
        $payment['payment_status']= 'Unpaid';
        $payment['payment_date']= \Carbon\Carbon::now()->format('Y-m-d');
        $payment['payment_method']= $booking->payment_method;
        $payment['va_number']= 0;
        $payment['total_paid']= 0;
        $payment['number_of_delays']= 0;
        $payment['fine']= 0;

        $payments[] = $payment;

        $credits = $booking->principal;
        $mth = $booking->due_date == \Carbon\Carbon::now()->day ? 1 : 0;
        for ($i = 1; $i <= $booking->installment_time; $i++) {
            $credits = $credits - $booking->installment;
            $date = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth));
            $payment = [];
            $payment['payment'] = 'Pembayaran ' . ($i*1 + 1);
            $payment['due_date'] = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth))->format('Y-m-d');
            $payment['sp1_date'] = $date->addDays(option('sp1_date', 14))->format('Y-m-d');
            $payment['sp2_date'] = $date->addDays(option('sp2_date', 21))->format('Y-m-d');
            $payment['sp3_date'] = $date->addDays(option('sp3_date', 28))->format('Y-m-d');
            $payment['installment'] = $i == $booking->installment_time ? $booking->installment + $credits : $booking->installment;
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
        $payment['due_date'] = \Carbon\Carbon::now()->format('Y-m-d');
        $payment['installment'] = $booking->unit->utj;
        $payment['credit'] = $booking->principal;
        $payment['installment'] =$booking->installment;
        $payment['credit']= $booking->credits;
        $payment['payment_status']= 'Unpaid';
        $payment['payment_date']= \Carbon\Carbon::now()->format('Y-m-d');
        $payment['payment_method']= $booking->payment_method;
        $payment['va_number']= 0;
        $payment['total_paid']= 0;
        $payment['number_of_delays']= 0;
        $payment['fine']= 0;
        $payments[] = $payment;

        $credits = $booking->principal;
        $mth = $booking->due_date == \Carbon\Carbon::now()->day ? 1 : 0;
        for ($i = 1; $i <= $booking->installment_time; $i++) {
            $credits = $credits - $booking->installment;
            $date = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth));
            $payment = [];
            $payment['payment'] = 'Cicilan ' . $i;
            $payment['due_date'] = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth))->format('Y-m-d');
            $payment['sp1_date'] = $date->addDays(option('sp1_date', 14))->format('Y-m-d');
            $payment['sp2_date'] = $date->addDays(option('sp2_date', 21))->format('Y-m-d');
            $payment['sp3_date'] = $date->addDays(option('sp3_date', 28))->format('Y-m-d');
            $payment['installment'] = $i == $booking->installment_time ? $booking->installment + $credits : $booking->installment;
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
        $payment['due_date'] = \Carbon\Carbon::now()->format('Y-m-d');
        $payment['installment'] = $booking->unit->utj;
        $payment['credit'] = $booking->principal;
        $payment['installment'] =$booking->installment;
        $payment['credit']= $booking->credits;
        $payment['payment_status']= 'Unpaid';
        $payment['payment_date']= \Carbon\Carbon::now()->format('Y-m-d');
        $payment['payment_method']= $booking->payment_method;
        $payment['va_number']= 0;
        $payment['total_paid']= 0;
        $payment['number_of_delays']= 0;
        $payment['fine']= 0;
        $payments[] = $payment;

        $credits = $booking->principal;
        $mth = $booking->due_date == \Carbon\Carbon::now()->day ? 1 : 0;
        for ($i = 1; $i <= $booking->installment_time; $i++) {
            $credits = $credits - $booking->installment;
            $date = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth));
            $payment = [];
            $payment['payment'] = 'Cicilan DP ' . $i;
            $payment['due_date'] = \Carbon\Carbon::parse(get_next_month(get_next_date($booking->due_date), $mth))->format('Y-m-d');
            $payment['sp1_date'] = $date->addDays(option('sp1_date', 14))->format('Y-m-d');
            $payment['sp2_date'] = $date->addDays(option('sp2_date', 21))->format('Y-m-d');
            $payment['sp3_date'] = $date->addDays(option('sp3_date', 28))->format('Y-m-d');
            $payment['installment'] = $i == $booking->installment_time ? $booking->installment + $credits : $booking->installment;
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

    /**
     *
     * Generate Installment PDF
     *
     */
    public function generateInstallment($booking)
    {
        $pdf = \PDF::loadView('template::docs.booking_letter_ind', [
            'booking' => $booking
        ]);
        $options = $pdf->setPaper('a4', 'portrait')->setWarnings(false);

        $pdf_path = public_path('/docs/booking_docs/booking-').$booking->hashid.'.pdf';
        if(file_exists($pdf_path)){
            unlink($pdf_path);
        }

        $pdf->save('public/docs/booking_docs/booking-'.$booking->hashid.'.pdf');
    }
}
