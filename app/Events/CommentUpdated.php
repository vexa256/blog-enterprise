<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CommentUpdated extends Event
{
    use SerializesModels;

    public $comment;

    public $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($comment, $actiontype)
    {
        $this->comment = $comment;
        $this->action = $actiontype;
    }


    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
