<?php

namespace App\Notifications\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Investment extends Notification
{
    use Queueable;

    public $name;
    public $inv;

    public $isDeclined;
    public $isPaid;
    public $isMatured;
    public $isActive;
    public $isQueued;
    public $isPending;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $inv, $isDeclined, $isPaid, $isMatured, $isActive, $isQueued, $isPending)
    {
        $this->name = $name;
        $this->inv = $inv;
        $this->isDeclined = $isDeclined;
        $this->isPaid = $isPaid;
        $this->isMatured = $isMatured;
        $this->isActive = $isActive;
        $this->isQueued = $isQueued;
        $this->isPending = $isPending;
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
        if($this->isDeclined){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>₦'.number_format($this->inv->amount,2).'</b> purchase of <b>'.$this->inv->units.' units</b> with <b>'.ucwords($this->inv->farm()->first()->name).'</b> farm has been declined.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }elseif($this->isPaid){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>₦'.number_format($this->inv->amount,2).'</b> purchase of <b>'.$this->inv->units.' units</b> with <b>'.ucwords($this->inv->farm()->first()->name).'</b> farm has been paid to your wallet.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }elseif($this->isMatured){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>₦'.number_format($this->inv->amount,2).'</b> purchase of <b>'.$this->inv->units.' units</b> with <b>'.ucwords($this->inv->farm()->first()->name).'</b> farm has matured for payouts.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }elseif($this->isActive){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>₦'.number_format($this->inv->amount,2).'</b> purchase of <b>'.$this->inv->units.' units</b> with <b>'.ucwords($this->inv->farm()->first()->name).'</b> farm is now active.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }elseif($this->isQueued){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>₦'.number_format($this->inv->amount,2).'</b> purchase of <b>'.$this->inv->units.' units</b> with <b>'.ucwords($this->inv->farm()->first()->name).'</b> farm has been queued for approval.')
                    ->line('If you have any complaints or queries, please reach out to our support desk.')
                    ->line('Thank you for trusting us!');
        }elseif($this->isPending){
            return (new MailMessage)
                    ->greeting('Dear '.ucwords($this->name).',')
                    ->line('Your <b>₦'.number_format($this->inv->amount,2).'</b> purchase of <b>'.$this->inv->units.' units</b> with <b>'.ucwords($this->inv->farm()->first()->name).'</b> farm is successful.')
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
        if($this->isDeclined){
            return [
                'body' => '<b>Investment Declined</b><span class="text-muted">Your ₦'.number_format($this->inv->amount,2).' purchase of '.$this->inv->units.' units with '.ucwords($this->inv->farm()->first()->name).' farm has been declined.</span>',
                'icon' => '<div class="notify-icon bg-danger"><i class="mdi mdi-diamond"></i></div>',
            ];
        }elseif($this->isPaid){
            return [
                'body' => '<b>Investment Paid</b><span class="text-muted">Your ₦'.number_format($this->inv->amount,2).' purchase of '.$this->inv->units.' units with '.ucwords($this->inv->farm()->first()->name).' farm has been paid to your wallet.</span>',
                'icon' => '<div class="notify-icon bg-success"><i class="mdi mdi-diamond"></i></div>',
            ];
        }elseif($this->isMatured){
            return [
                'body' => '<b>Investment Matured</b><span class="text-muted">Your ₦'.number_format($this->inv->amount,2).' purchase of '.$this->inv->units.' units with '.ucwords($this->inv->farm()->first()->name).' farm is now matured for payout.</span>',
                'icon' => '<div class="notify-icon bg-info"><i class="mdi mdi-diamond"></i></div>',
            ];
        }elseif($this->isActive){
            return [
                'body' => '<b>Investment is Active</b><span class="text-muted">Your ₦'.number_format($this->inv->amount,2).' purchase of '.$this->inv->units.' units with '.ucwords($this->inv->farm()->first()->name).' farm is now active.</span>',
                'icon' => '<div class="notify-icon bg-primary"><i class="mdi mdi-diamond"></i></div>',
            ];
        }elseif($this->isQueued){
            return [
                'body' => '<b>Investment Queued</b><span class="text-muted">Your ₦'.number_format($this->inv->amount,2).' purchase of '.$this->inv->units.' units with '.ucwords($this->inv->farm()->first()->name).' farm has been saved and pending approval.</span>',
                'icon' => '<div class="notify-icon bg-warning"><i class="mdi mdi-diamond"></i></div>',
            ];
        }elseif($this->isPending){
            return [
                'body' => '<b>Investment Saved</b><span class="text-muted">Your ₦'.number_format($this->inv->amount,2).' purchase of '.$this->inv->units.' units with '.ucwords($this->inv->farm()->first()->name).' farm is successful.</span>',
                'icon' => '<div class="notify-icon bg-warning"><i class="mdi mdi-diamond"></i></div>',
            ];
        }
        
    }
}
