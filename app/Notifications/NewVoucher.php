<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use \App\Voucher_customers;

class NewVoucher extends Notification
{
    use Queueable;

    public $voucher;
    public function __construct(Voucher_customers $voucher)
    {
        $this->voucher = $voucher;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return [
            'voucher' => $this->voucher,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'voucher' => $this->voucher,
        ];
    }
}
