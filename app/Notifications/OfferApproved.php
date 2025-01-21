<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferApproved extends Notification
{
    use Queueable;

    protected $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.offer-approved')
            ->with([
                'offer' => $this->offer,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'offer_id' => $this->offer->id,
            'message' => 'تمت الموافقة على نشر طلبكم رقم :',
            'status' => 'approved'
        ];
    }
}
