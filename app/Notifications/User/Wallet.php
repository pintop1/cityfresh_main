<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Wallet extends Notification
{
    use Queueable;

    public $name, $old_amount, $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $old_amount, $amount)
    {
        $this->name = $name;
        $this->old_amount = $old_amount;
        $this->amount = $amount;
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
        if($this->old_amount > $this->amount) return (new MailMessage)
            ->greeting('Dear '.ucwords($this->name).',')
            ->line('Your wallet was debited <b>₦'.number_format($this->old_amount - $this->amount, 2).'</b>')
            ->line('Your new wallet balance is <b>₦'.number_format($this->amount,2).'</b>')
            ->line('Thank you for using our application!');

        if($this->old_amount < $this->amount) return (new MailMessage)
            ->greeting('Dear '.ucwords($this->name).',')
            ->line('Your wallet has been credited with <b>₦'.number_format($this->old_amount - $this->amount, 2).'</b>')
            ->line('Your new wallet balance is <b>₦'.number_format($this->amount,2).'</b>')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if($this->old_amount > $this->amount) return [
            'body' => '<b>Debit Alert</b><span class="text-muted">Your wallet was debited ₦'.number_format($this->old_amount - $this->amount, 2).'. Your new wallet balance is ₦'.number_format($this->amount,2).'</span>',
            'icon' => '<div class="notify-icon bg-danger"><i class="fas fa-wallet"></i></div>',
        ];
        if($this->old_amount < $this->amount) return [
            'body' => '<b>Credit Alert</b><span class="text-muted">Your wallet has been credited with ₦'.number_format($this->amount- $this->old_amount, 2).'. Your new wallet balance is ₦'.number_format($this->amount,2).'</span>',
            'icon' => '<div class="notify-icon bg-success"><i class="fas fa-wallet"></i></div>',
        ];
    }
}
