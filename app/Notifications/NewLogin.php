<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Admins;
class NewLogin extends Notification
{
    use Queueable;

    public $admin;
    public function __construct(Admins $admin)
    {
        $this->admin = $admin;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return [
            'admin' => $this->admin
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'admin' => $this->admin
        ];
    }
}
