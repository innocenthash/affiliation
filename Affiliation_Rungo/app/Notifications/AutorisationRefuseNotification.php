<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AutorisationRefuseNotification extends Notification
{
    use Queueable;
    public $vendeurs;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vendeurs)
    {
        //
        $this->$vendeurs = $vendeurs ;
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
                    ->line($notifiable->name.' vous avez été bannie de notre plateforme !')
                    // ->action('Notification Action', url('/'))
                    ->line('merci de votre comprehension !');
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
            //
        ];
    }
}
