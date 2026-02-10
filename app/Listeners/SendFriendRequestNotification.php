<?php

namespace App\Listeners;

use App\Events\FriendRequestSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFriendRequestNotification
{
    /**
     * Create the event listener.
     */

    public $user;
    public $friend;
    public function __construct($user,$friend)
    {
        //
        $this->user = $user;
        $this->friend = $friend;

    }

    /**
     * Handle the event.
     */
    public function handle(FriendRequestSent $event): void
    {
        $event->friend->notify(
            new FriendRequestSentNotification($event->user, $event->friend)
        );
    }
}
