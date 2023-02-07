<?php

namespace App\Mail;

use App\User;
use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Message $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('v4.new_message_received', ['subject' => $this->message->thread->subject]))
            ->markdown('emails.message.new')->with([
                'link' => route('user.message.show',  ['user' => $this->user->username_slug, 'id' => $this->message->thread->id]),
                'subject' => $this->message->thread->subject,
                'body' => $this->message->body,
                'from' => $this->message->user->username,
            ]);
    }
}
