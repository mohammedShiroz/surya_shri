<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Withdrawal_points;
class NewWithdrawal extends Notification
{
    use Queueable;

    public $withdrawal;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Withdrawal_points $withdrawal)
    {
        $this->withdrawal =$withdrawal;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'withdrawal' => $this->withdrawal
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'withdrawal' => $this->withdrawal
        ];
    }
}
