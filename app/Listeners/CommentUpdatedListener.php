<?php

namespace App\Listeners;

use Exception;
use App\Events\CommentUpdated;
use App\Mail\Comment\CommentAdded;
use App\Mail\Comment\CommentTrashed;
use Illuminate\Support\Facades\Mail;
use App\Mail\Comment\CommentApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Comment\CommentAwaitingApproval;

class CommentUpdatedListener implements ShouldQueue
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
     * @param  CommentUpdated  $event
     * @return void
     */
    public function handle(CommentUpdated $event)
    {
        $action = $event->action;
        $comment = $event->comment;

        try {
            if ($action == 'Approved' && get_buzzy_config('COMMENTS_SEND_MAIL_APPROVED', true)) {
                Mail::to($comment->user)->send(new CommentApproved($comment));
            } elseif ($action == 'Trash' && get_buzzy_config('COMMENTS_SEND_MAIL_DELETED', true)) {
                Mail::to($comment->user)->send(new CommentTrashed($comment));
            } elseif ($action == 'Added') {
                if (!$comment->approve && get_buzzy_config('COMMENTS_SEND_MAIL_AWAIT_APPROVE', true)) {
                    Mail::to(config('mail.from.address'))->send(new CommentAwaitingApproval($comment));
                } elseif (
                    !$comment->parent_id && get_buzzy_config('COMMENTS_SEND_MAIL_ADDED', false)
                    || $comment->parent_id && get_buzzy_config('COMMENTS_SEND_MAIL_REPLY_ADDED', false)
                ) {
                    Mail::to(config('mail.from.address'))->send(new CommentAdded($comment));
                }
            }
        } catch (Exception $e) {
            //
        }
    }
}
