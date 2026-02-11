<?php

namespace App\Notifications;

use App\Models\Application;
use App\Models\Joboffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $application;
    public function __construct( Application $application)
    {
        $this->application = $application->load('jobOffer');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return BroadcastMessage
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        if ($this->application->status == 'accepted'){
            return new BroadcastMessage([
                'message'=> $this->application->jobOffer->title.' has accepted your application',
                'time'=>now()->diffForHumans()
            ]);
        }  return new BroadcastMessage([
        'message'=> $this->application->jobOffer->title.' has declined your application',
        'time'=>now()->diffForHumans()
    ]);


    }

    public function toDatabase(Object $notifiable): array
    {
       if($this->application->status == 'declined'){ return [
                   'message'=> $this->application->jobOffer->title.' has declined your application'
        ];}
       else {
           return [
               'message'=> $this->application->jobOffer->title.' has accepted your application'
           ];
       }
    }
}
