<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Visit_logs;

class NewVisit extends Notification
{
    use Queueable;
    public $visit_user;

    public function __construct(Visit_logs $visit)
    {
        $this->visit_user = $visit;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user' => $this->visit_user
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'user' => $this->visit_user
        ];
    }
}
