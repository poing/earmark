<?php

namespace Poing\Earmark\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EarMarkRefill
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    //public $prefix;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->prefix = $prefix;
    }

    /**
     * Get the channels the event should broadcast on.
     * @codeCoverageIgnore
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
