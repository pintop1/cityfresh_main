<?php

namespace App\Notifications\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CardNotification extends Notification
{
    use Queueable;

    public $name;

    public $isRemoved;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $isRemoved)
    {
        $this->name = $name;
        $this->isRemoved = $isRemoved;
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
        if($this->isRemoved){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('You successfully removed a debit/credit card from your account.')
                    ->line('If you did not perform this action, please contact support to resolve this issue.')
                    ->line('Thank you for trusting us!');
        }
        return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('You successfully added a credit/debit card to your account.')
                    ->line('If you did not perform this action, please contact support to resolve this issue.')
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
        if($this->isRemoved){
            return [
                'body' => '<b>Card Deleted</b><span class="text-muted">You successfully removed a debit/credit card from your account.</span>',
                'icon' => '<div class="notify-icon bg-danger"><i class="fab fa-cc-mastercard"></i></div>',
            ];
        }
        return [
            'body' => '<b>Card Added</b><span class="text-muted">You successfully added a credit/debit card to your account</span>',
            'icon' => '<div class="notify-icon bg-success"><i class="fab fa-cc-mastercard"></i></div>',
        ];
    }
}
