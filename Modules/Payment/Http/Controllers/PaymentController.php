<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Installment\Entities\Booking;
use Modules\Installment\Entities\BookingPayment;
use DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($booking)
    {
        $table_headers = [
            [
                "text" => '#',
                "align" => 'center',
                "sortable" => false,
                "value" => 'table_index',
            ],
            [
                "text" => 'Pembayaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment',
            ],
            [
                "text" => 'Jatuh Tempo',
                "align" => 'center',
                "sortable" => false,
                "value" => 'due_date',
            ],
            [
                "text" => 'Angsuran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'installment',
            ],
            [
                "text" => 'Tanggal Pembayaran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'payment_date',
            ],
            [
                "text" => 'Telat (hari)',
                "align" => 'center',
                "sortable" => false,
                "value" => 'number_of_delays',
            ],
            [
                "text" => 'Denda',
                "align" => 'center',
                "sortable" => false,
                "value" => 'fine',
            ],
            [
                "text" => 'Sisa Angsuran',
                "align" => 'center',
                "sortable" => false,
                "value" => 'credit',
            ],
            [
                "text" => 'Aksi',
                "align" => 'center',
                "sortable" => false,
                "value" => 'actions',
            ],
        ];
        return view('payment::index', [
            'data' => $booking,
            'table_headers' => $table_headers,
        ]);
    }

    /**
     *
     * Handle incoming request for specific data
     *
     */
    public function data(Booking $booking)
    {
        $data = $booking->load('unit','client','sales','payments','sales.user','sales.main_coordinator', 'sales.agency', 'sales.regional_coordinator');
        try {
            return response_json(true, null, 'Sukses mengambil data.', $data);
        } catch (Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }
    }

    /**
     *
     * Handle POST request payment installment
     *
     */
    public function payment(Request $request, Booking $booking, BookingPayment $payment)
    {
        $order_number = $this->generateUniqueOrderId($payment);
        $item_details = [
            [
                'name' => $payment->payment,
                'quantity' => 1,
                'price' => (int) $payment->installment
            ]
        ];
        if ($payment->number_of_delays > 0) {
            $item_details[] = [
                'name' => 'Denda',
                'quantity' => (int) $payment->number_of_delays,
                'price' => (int) $payment->fine
            ];
        }
        $postfields = [
            'transaction_details' => [
                'order_id' => $order_number,
                'gross_amount' => (int) $payment->installment + $payment->fine * $payment->number_of_delays,
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => $booking->client->client_name,
                'last_name' => "",
                'email' => $booking->client->client_email,
                'phone' => $booking->client->client_mobile_number
            ],
            'enabled_payments' => ["bni_va", "permata_va", "other_va"],
            'expiry' => [
                'unit' => 'hours',
                'duration' => 24
            ],
            'callbacks' => [
                'finish' => route('pembayaran.cicilan.index', [$booking->slug])
            ]
        ];

        try {
            $response = json_decode($this->getSNAPToken($postfields), true);
            if (isset($response['redirect_url'])) {
                $payment->update(['pg_number' => $order_number]);
                return response_json(true, null, 'Sukses mengambil data.', $response);
            }
            return response_json(false, null, 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.', $response);
        } catch (\Exception $e) {
            return response_json(false, $e->getMessage() . ' on file ' . $e->getFile() . ' on line number ' . $e->getLine(), 'Terdapat kesalahan saat mengambil data, silahkan dicoba kembali beberapa saat lagi.');
        }

    }

    /**
     *
     * Handle generate unique Order Number for Midtrans
     *
     */
    public function generateUniqueOrderId($payment)
    {
        $order_number = 'EPICADM'.\Carbon\Carbon::now()->locale('id')->format('Ym').sprintf("%06d", $payment->id);
        if ($payment->pg_number) {
            $split = explode('-', $payment->pg_number);
            if ($split[0] == $order_number) {
                if (isset($split[1])) {
                    $suffix = $split[1] + 1;
                } else {
                    $suffix = '1';
                }
            } else {
                $suffix = '1';
            }

        } else {
            $suffix = '1';
        }
        return $order_number.'-'.$suffix;
    }

    /**
     *
     * Handle API GET TOKEN
     *
     */
    public function getSNAPToken($postfields)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => option('midtrans_url'),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($postfields),
          CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode(option('midtrans_server_key') . ':')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    /**
     *
     * Handle Notification from Midtrans
     *
     */
    public function handleMidtransNotification(Request $request)
    {
        \Log::info(json_encode($request->all(), JSON_PRETTY_PRINT));
        DB::beginTransaction();
        try {
            $installment = BookingPayment::where('pg_number', $request->input('order_id'))->firstOrFail();
            if ($request->input('transaction_status') == 'settlement' || $request->input('transaction_status') == 'capture' ) {
                $installment->update([
                    'payment_status' => 'Paid',
                    'payment_date' => $request->input('settlement_time'),
                    'payment_method' => $request->input('payment_type'),
                    'va_number' => $request->input('va_numbers')[0]['va_number'] ?? $request->input('permata_va_number'),
                    'total_paid' => $request->input('gross_amount'),
                    'paid_mail' => true
                ]);
                $booking = $installment->booking;
                // Send Email Paid
                // if (count($booking->unpaid_payments) == 0) {
                //     $booking->booking_status = $booking->payment_type == 'KPR/KPA' ? 'akad' : 'ajb_handover';
                //     $booking->save();
                // }

                if (count($booking->akad_kredit_payments) == 1) {
                    if (count($booking->unpaid_payments) == 0) {

                        if ($booking->booking_status == 'cicilan') {
                            $booking->booking_status = $booking->payment_type == 'KPR/KPA' ? 'akad' : 'ajb_handover';
                            $booking->save();
                        }else{
                            $booking->booking_status = 'ajb_handover';
                            $booking->save();
                        }

                    }
                }else{
                    if (count($booking->unpaid_payments) == 0) {

                        if ($booking->booking_status == 'cicilan') {
                            $booking->booking_status = $booking->payment_type == 'KPR/KPA' ? 'akad' : 'ajb_handover';
                            $booking->save();
                        }else{
                            $booking->booking_status = 'ajb_handover';
                            $booking->save();
                        }

                    }
                }
                
                DB::commit();
                return response_json(true, null, 'Notification Received.', $request->all());
            } else {
                if (!$installment->pending_mail) {
                    $order->update([
                        'payment_method' => $request->input('payment_type'),
                        'va_number' => $request->input('va_numbers')[0]['va_number'] ?? $request->input('permata_va_number'),
                        'pending_mail' => true,
                    ]);
                    // Send Email Pending
                }
                DB::commit();
                return response_json(true, null, 'Notification Received.', $request->all());
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response_json(true, null, $e->getMessage(), $request->all());
        }
    }
}
