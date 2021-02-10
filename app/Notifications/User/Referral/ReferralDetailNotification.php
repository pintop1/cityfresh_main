<?php

namespace App\Notifications\User\Referral;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralDetailNotification extends Notification
{
    use Queueable;

    public $name;
    public $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                ->line('Thank you for joining our platform.')
                ->line('You can also earn more by referring users to our platform with your unique referral code and earn commissions on your referrals investment.')
                ->line('Your referral code is: <b>'.$this->code.'</b>')
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
            
        ];
    }
}
