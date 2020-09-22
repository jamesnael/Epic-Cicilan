<?php

namespace Modules\RewardPoint\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PenukaranPoint extends Notification
{
    use Queueable;

    public $name;
    public $point;
    public $reward;
    public $date;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $point, $reward, $date)
    {
        $this->name = $name;
        $this->point = $point;
        $this->reward = $reward;
        $this->date = $date;
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
                    ->subject('Penukaran Reward Point')
                    ->view('rewardpoint::emails.penukaran_point', 
                        [
                            'name' => $this->name,
                            'point' => $this->point,
                            'reward' => $this->reward,
                            'date' => $this->date,
                        ]
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
