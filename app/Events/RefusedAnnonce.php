<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefusedAnnonce implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $annonce;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($annonce)
    {
        $this->annonce = $annonce;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('annonce-refused');
    }
}
