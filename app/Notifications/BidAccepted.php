<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BidAccepted extends Notification
{
    use Queueable;

    protected $bid;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bid)
    {
        $this->bid = $bid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Adjust channels as needed
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.bid-accepted', ['bid' => $this->bid])
            ->subject('قبول عرضك');
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
            'message' => 'تم فتح نقاش معك بخصوص عرضك.',
            'bid_id' => $this->bid->id,
            'chat_room_id' => $this->bid->chatRoom->id,
        ];
    }
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'تم فتح نقاش معك بخصوص عرضك.',
            'bid_id' => $this->bid->id,
            'chat_room_id' => $this->bid->chatRoom->id,
        ];
    }
}
