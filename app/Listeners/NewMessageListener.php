<?php

namespace App\Listeners;

use App\Events\MessageReceived;
use App\Mail\NewMessage;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NewMessageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MessageReceived $event)
    {
        $message = $event->message;

        try {
            foreach ($message->participants as $participant) {
                if ($participant->user_id === $message->user_id) {
                    continue;
                }

                Mail::to($participant->user)->send(new NewMessage($participant->user, $message));
            }
        } catch (Exception $e) {
            //
        }
    }
}
