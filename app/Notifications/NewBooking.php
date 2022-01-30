<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Service_booking;

class NewBooking extends Notification
{
    use Queueable;

    public $booking;

    public function __construct(Service_booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'booking' => $this->booking
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'booking' => $this->booking
        ];
    }
}
