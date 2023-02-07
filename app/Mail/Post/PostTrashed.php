<?php

namespace App\Mail\Post;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostTrashed extends Mailable
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
        return $this->subject(trans('emails.trashsubject'))->view('emails.post.trashed')->with([
            'username' => $this->post->user->username,
            'title' => $this->post->title,
            'link' => $this->post->post_link,
        ]);
    }
}
