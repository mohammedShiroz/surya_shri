<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Points_Commission;

class NewDonation extends Notification
{
    use Queueable;
    public $points;

    public function __construct(Points_Commission $points)
    {
        $this->points =$points;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'points' => $this->points
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'points' => $this->points
        ];
    }
}
