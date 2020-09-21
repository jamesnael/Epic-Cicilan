<?php

namespace Modules\Installment\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class HMin7Installment extends Notification
{
    use Queueable;

    public $installment;
    public $booking;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($installment, $booking)
    {
        $this->installment = $installment;
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Reminder H-7 Tagihan')
                    ->view('installment::emails.h_min_7_mail', 
                        ['installment' => $this->installment, 'booking' => $this->booking]
                    );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
