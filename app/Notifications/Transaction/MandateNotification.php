<?php

namespace App\Notifications\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MandateNotification extends Notification
{
    use Queueable;

    public $name;

    public $isRemoved;

    public $mandate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $isRemoved, $mandate)
    {
        $this->name = $name;
        $this->isRemoved = $isRemoved;
        $this->mandate = $mandate;
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
                    ->line('A non-withdrawable funds of <b>₦'.number_format($this->mandate->amount,2).'</b> has been made available for your withdrawal.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }
        return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('A sum of <b>₦'.number_format($this->mandate->amount,2).'</b> has been locked for investment rollover.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
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
                'body' => '<b>Funds Unlocked</b><span class="text-muted">A non-withdrawable funds of ₦'.number_format($this->mandate->amount,2).' has been made available for your withdrawal.</span>',
                'icon' => '<div class="notify-icon bg-danger"><i class="mdi mdi-wallet"></i></div>',
            ];
        }
        return [
            'body' => '<b>Funds Locked</b><span class="text-muted">A sum of ₦'.number_format($this->mandate->amount,2).' has been locked for investment rollover.</span>',
            'icon' => '<div class="notify-icon bg-success"><i class="mdi mdi-wallet"></i></div>',
        ];
    }
}
