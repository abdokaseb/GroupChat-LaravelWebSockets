<?php

namespace App\Events;

use App\User;
use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var \App\User
     */
    public $user;

    /**
     * Message details
     *
     * @var \App\Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */

     /**
     * Room  Details 
     *
     * @var \Room
     */
    public $room;

    public function __construct(User $user, Message $message,String $room)
    {
        $this->user = $user;

        $this->message = $message;

        $this->room = $room;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {   
        return new PresenceChannel($this->room);
    }
}
