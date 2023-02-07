<?php

namespace App\Mail\Post;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostAwaitingApproval extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('v4.new_post_await_approve', ['title' => $this->post->title]))
            ->view('emails.post.await-approve')->with([
                'link' => $this->post->post_link,
                'title' => $this->post->title,
                'from' => $this->post->user->username,
            ]);
    }
}
