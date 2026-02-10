<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendRequestSentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public  $friendRequest;
    public User $sender;

    public function __construct($friendRequest,$sender)
    {
        $this->friendRequest = $friendRequest;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
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
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message'=>"{$this->sender->name} sent you a friend request",
            'sender_id' => $this->sender->id
        ];
    }

    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage([
            'message'=>"{$this->sender->name} sent you a friend request",
            'sender_id' => $this->sender->id,
        ]);
    }
}
