<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->view('emails.reset-password', ['token' => $this->token])
            ->subject('إعادة تعيين كلمة المرور')
            ->line('تلقّيتم هذه الرسالة لأننا تلقينا طلب إعادة تعيين كلمة المرور لحسابكم.')
            ->line('إذا لم تطلبوا إعادة تعيين كلمة المرور، فلا حاجة لاتخاذ أي إجراء.')
            ->action('إعادة تعيين كلمة المرور', url(config('app.url') . route('password.reset', $this->token, false)));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
