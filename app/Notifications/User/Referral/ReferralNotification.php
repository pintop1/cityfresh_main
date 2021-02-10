<?php

namespace App\Notifications\User\Referral;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralNotification extends Notification
{
    use Queueable;

    public $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
                    ->greeting('Hello '.ucwords($this->name).',')
                    ->line('You have a new referral')
                    ->line('Thank you for trusting us!');
        
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
            'body' => '<b>New Referral</b><span class="text-muted">A new user just signed up using your referral link.s</span>',
            'icon' => '<div class="notify-icon bg-success"><i class="fas fa-users"></i></div>',
        ];
    }
}
