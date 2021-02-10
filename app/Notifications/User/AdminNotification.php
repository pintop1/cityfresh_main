<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;
    
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
                    ->greeting('Hello '.ucwords($this->user->name).',')
                    ->line('Welcome to City Fresh Farms administration platform. Your login details are as follows:')
                    ->line('Email address: <b>'.$this->user->email.'</b>')
                    ->line('Password: <b>'.explode(' ', $this->user->name)[0].'@cityfreshfarms'.date('Y'))
                    ->action('Sign In', route('admin.dashboard'))
                    ->line('Please keep your login details private!');
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
            'body' => '<b>Registration successful</b><span class="text-muted">Your account has been created successfully, your are now part of city fresh farms administrator.</span>',
            'icon' => '<div class="notify-icon bg-success"><i class="fas fa-user-check"></i></div>',
        ];
    }
}
