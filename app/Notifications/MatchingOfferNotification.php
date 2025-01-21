<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class MatchingOfferNotification extends Notification
{
    use Queueable;

    private $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.matching', ['offer' => $this->offer])
            ->subject('وجدنا طلبات تبادل قد تناسبك');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'offer' => $this->offer,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'offer_id' => $this->offer->id,
            'message' => 'وجدنا طلبات تبادل قد تناسبك.',
        ];
    }
}
