<?php

namespace Modules\Installment\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Installment\Entities\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Modules\Installment\Notifications\HMin7Installment;
use Modules\Installment\Notifications\HMin1Installment;
use Modules\Installment\Notifications\SP1Installment;
use Modules\Installment\Notifications\SP2Installment;
use Modules\Installment\Notifications\SP3Installment;

class SendMailUpdateFine extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'installments:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update installment for fine and notification email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = Booking::has('unpaid_payments')
                        ->with('unpaid_payments')
                        ->get();

        foreach ($data as $key => $booking) {
            foreach ($booking->unpaid_payments as $key => $installment) {
                $due_date = Carbon::parse($installment->due_date . ' 23:59:59');
                $sp1_date = Carbon::parse($installment->sp1_date . ' 23:59:59');
                $sp2_date = Carbon::parse($installment->sp2_date . ' 23:59:59');
                $sp3_date = Carbon::parse($installment->sp3_date . ' 23:59:59');

                $today = Carbon::now('Asia/Jakarta');
                $diff = $due_date->diffInDays($today, false);
                $sp1_diff = $sp1_date->diffInDays($today, false);
                $sp2_diff = $sp2_date->diffInDays($today, false);
                $sp3_diff = $sp3_date->diffInDays($today, false);

                // Check -7 Notification
                if ($diff == -7 && !$installment->notification_mail_7) {
                    // Send Email -7 Notification
                    try {
                        Notification::route('mail', $booking->client->client_email)
                                    ->notify(new HMin7Installment($installment, $booking));
                        $installment->notification_mail_7 = true;
                        $installment->save();
                    } catch (\Exception $e) {
                        \Log::error(json_encode([
                            'action' => 'Send Email -7 Notification',
                            'data' => $booking,
                            'error' => $e->getMessage()
                        ], JSON_PRETTY_PRINT));
                    }
                }

                // Check -1 Notification
                if ($diff == -1 && !$installment->notification_mail_1) {
                    // Send Email -1 Notification
                    try {
                        Notification::route('mail', $booking->client->client_email)
                                    ->notify(new HMin1Installment($installment, $booking));
                        $installment->notification_mail_1 = true;
                        $installment->save();
                    } catch (\Exception $e) {
                        \Log::error(json_encode([
                            'action' => 'Send Email -1 Notification',
                            'data' => $booking,
                            'error' => $e->getMessage()
                        ], JSON_PRETTY_PRINT));
                    }
                }

                // Update Fine
                if ($diff > 0) {
                    // Update Fine
                    $installment->number_of_delays = $diff;
                    $installment->fine = option('persen_denda', 0.0001) * $booking->total_amount;
                    $installment->save();
                }
                
                // Check SP 1 Notification
                if ($sp1_diff == 0 && !$installment->notification_mail_sp1) {
                    // Send Email SP 1 Notification
                    try {
                        Notification::route('mail', $booking->client->client_email)
                                    ->notify(new SP1Installment($installment, $booking));
                        $installment->notification_mail_sp1 = true;
                        $installment->save();
                    } catch (\Exception $e) {
                        \Log::error(json_encode([
                            'action' => 'Send Email SP1 Notification',
                            'data' => $booking,
                            'error' => $e->getMessage()
                        ], JSON_PRETTY_PRINT));
                    }
                }

                // Check SP 2 Notification
                if ($sp2_diff == 0 && !$installment->notification_mail_sp2) {
                    // Send Email SP 2 Notification
                    try {
                        Notification::route('mail', $booking->client->client_email)
                                    ->notify(new SP2Installment($installment, $booking));
                        $installment->notification_mail_sp2 = true;
                        $installment->save();
                    } catch (\Exception $e) {
                        \Log::error(json_encode([
                            'action' => 'Send Email SP2 Notification',
                            'data' => $booking,
                            'error' => $e->getMessage()
                        ], JSON_PRETTY_PRINT));
                    }
                }

                // Check SP 3 Notification
                if ($sp3_diff == 0 && !$installment->notification_mail_sp3) {
                    // Send Email SP 3 Notification
                    try {
                        Notification::route('mail', $booking->client->client_email)
                                    ->notify(new SP3Installment($installment, $booking));
                        $installment->notification_mail_sp3 = true;
                        $installment->save();
                    } catch (\Exception $e) {
                        \Log::error(json_encode([
                            'action' => 'Send Email SP3 Notification',
                            'data' => $booking,
                            'error' => $e->getMessage()
                        ], JSON_PRETTY_PRINT));
                    }
                }
            }

        }
    }
}
