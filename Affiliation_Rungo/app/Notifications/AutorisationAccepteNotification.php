<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AutorisationAccepteNotification extends Notification
{
    use Queueable;
    public $vendeurs ;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vendeurs)
    {
        //
        $this->vendeurs = $vendeurs ;
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
                    ->line('Mr || Mme '.$notifiable->name.' vous etes autorisé a etre vendeur sur notre plateforme')
                    ->action('veuillez cliquez sur ce lien pour se connecter', 'http://localhost/Affiliation_Rungo/public/login')
                    ->line('Merci !');
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
