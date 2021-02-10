<?php

namespace App\Notifications\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionNotification extends Notification
{
    use Queueable;

    public $name;

    public $isPending;
    public $isFailed;
    public $isSuccess;

    public $transaction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $isPending, $isFailed, $isSuccess, $transaction)
    {
        $this->name = $name;
        $this->isPending = $isPending;
        $this->isFailed = $isFailed;
        $this->isSuccess = $isSuccess;
        $this->transaction = $transaction;
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
        if($this->isPending){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>'.$this->transaction->data()->description.'</B> transaction of <b>₦'.number_format($this->transaction->data()->amount,2).'</b> has been saved and pending administrative approval.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }elseif($this->isFailed){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>'.$this->transaction->data()->description.'</B> transaction of <b>₦'.number_format($this->transaction->data()->amount,2).'</b> failed.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }elseif($this->isSuccess){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>'.$this->transaction->data()->description.'</B> transaction of <b>₦'.number_format($this->transaction->data()->amount,2).'</b> was successful.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }
        
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if($this->isPending){
            return [
                'body' => '<b>Transaction Saved</b><span class="text-muted">Your '.$this->transaction->data()->description.' transaction of ₦'.number_format($this->transaction->data()->amount,2).' has been saved and pending administrative approval.</span>',
                'icon' => '<div class="notify-icon bg-warning"><i class="mdi mdi-chart-areaspline"></i></div>',
            ];
        }elseif($this->isFailed){
            return [
                'body' => '<b>Transaction Failed</b><span class="text-muted">Your '.$this->transaction->data()->description.' transaction of ₦'.number_format($this->transaction->data()->amount,2).' failed.</span>',
                'icon' => '<div class="notify-icon bg-danger"><i class="mdi mdi-chart-areaspline"></i></div>',
            ];
        }elseif($this->isSuccess){
            return [
                'body' => '<b>Transaction Successful</b><span class="text-muted">Your '.$this->transaction->data()->description.' transaction of ₦'.number_format($this->transaction->data()->amount,2).' was successful.</span>',
                'icon' => '<div class="notify-icon bg-success"><i class="mdi mdi-chart-areaspline"></i></div>',
            ];
        }
    }
}
