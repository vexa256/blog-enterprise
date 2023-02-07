<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Support\Arr;
use App\Events\CommentUpdated;
use App\Traits\RepositoryResponse;
use Illuminate\Support\Facades\Auth;

class CommentRepository
{
    use RepositoryResponse;

    /**
     * Get comments.
     *
     * @param array $args Filters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Comment[]
     */
    public function get($args, $excludeIds = [])
    {
        $pageCount = get_buzzy_config('COMMENTS_PAGE_COUNT', 15);
        $postId = Arr::get($args, 'post_id');
        $userId = Arr::get($args, 'user_id');
        $sort = Arr::get($args, 'sort');

        $comments = Comment::withRelations()
            ->onlyParent()
            ->approved()
            ->byPost($postId)
            ->byUser($userId)
            ->when($excludeIds, function ($query, $excludeIds) {
                return $query->whereNotIn('id', $excludeIds);
            })
            ->orderCommentsBy($sort)
            ->paginate($pageCount);

        return $comments;
    }

    /**
     * Get popular comments.
     *
     * @param array $args Filters
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function getPopular($args)
    {
        $popularLikeCount = get_buzzy_config('COMMENTS_POPULAR_LIKE_COUNT', 10);
        $popularCount = get_buzzy_config('COMMENTS_POPULAR_COUNT', 3);
        $postId = Arr::get($args, 'post_id');
        $userId = Arr::get($args, 'user_id');

        $comments = Comment::withRelations()
            ->onlyParent()
            ->approved()
            ->byPost($postId)
            ->byUser($userId);

        $comments = $comments
            ->has('likes', '>=', $popularLikeCount)
            ->orderBy('likes_count', 'desc')
            ->take($popularCount)
            ->get();

        return $comments;
    }

    /**
     * Get comments.
     *
     * @param int $id Comment ID
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function getReplies($id)
    {
        $repliesCount = get_buzzy_config('COMMENTS_SHOW_REPLY_COUNT', 3);
        $repliesSort = get_buzzy_config('COMMENTS_REPLIES_DEFAULT_SORT', 'old');

        $replies = Comment::withRelations()
            ->byParent($id)
            ->approved()
            ->orderCommentsBy($repliesSort)
            ->paginate($repliesCount);

        return $replies;
    }

    /**
     * Get a comment.
     *
     * @param int $id Comment ID
     *
     * @return \App\Comment
     */
    public function show($id)
    {
        return Comment::findOrFail($id);
    }

    /**
     * Store a comment.
     *
     * @param array $data
     *
     * @return $this
     */
    public function store($data)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;

            if (
                get_buzzy_config('UserVerifyEmail') == 'yes'
                && get_buzzy_config('UserCommentingVerifyEmail') == 'yes'
                && !Auth::user()->hasVerifiedEmail()
            ) {
                return $this->fail(__('You must be verify your email to comment. To verify your email go to profile settings.'));
            }
        } else {
            $user_id = Arr::get($data, 'user_id', null);
        }

        $is_guest = isset($data["data"]["guest"]);

        if (!$user_id && !$is_guest) {
            return $this->fail(__('You must be logged in'));
        }

        if (Auth::check() && in_array(Auth::user()->usertype, ['Admin', 'Staff'])) {
            $approve = 1;
        } else {
            $approve = get_buzzy_config('COMMENTS_USE_APPROVAL', true) || $is_guest && get_buzzy_config('COMMENTS_USE_GUEST_APPROVAL', true) ? 0 : 1;
        }

        $parent_id = Arr::get($data, 'parent_id');

        $data = array_merge(
            $data,
            [
                'user_id' => $user_id,
                'approve' => $approve,
                'parent_id' => $parent_id ? intval($parent_id) : null,
            ]
        );

        try {
            $comment = Comment::create($data);

            event(new CommentUpdated($comment, 'Added'));

            $approveMessage = !$approve ? __('Thanks for your comment. Your comment will appear after it is approved!')  : '';
            $response = $this->success($comment, $approveMessage);
        } catch (\Exception $e) {
            $response = $this->fail(env('APP_DEBUG') ? $e->getMessage() : null);
        }

        return $response;
    }

    /**
     * Update a comment.
     *
     * @param array $data
     *
     * @return $this
     */
    public function update($id, $data)
    {
        $comment  = Comment::find($id);

        if (
            !$comment ||
            $comment->user_id !== get_current_comment_user()->id
            && !get_buzzy_config('COMMENTS_USER_CAN_EDIT', true)
            && !get_current_comment_user()->isAdmin
        ) {
            $response = $this->fail();
        }

        if (Auth::check() && in_array(Auth::user()->usertype, ['Admin', 'Staff'])) {
            $approve = 1;
        } else {
            $approve = get_buzzy_config('COMMENTS_USE_APPROVAL', true) && get_buzzy_config('COMMENTS_USE_EDIT_APPROVAL', true) ? 0 : 1;
        }

        $data = array_merge(
            $data,
            [
                'approve' => $approve,
            ]
        );

        try {
            $comment = $comment->update($data);

            event(new CommentUpdated($comment, 'Updated'));

            $response = $this->success($comment, __('Updated'));
        } catch (\Exception $e) {
            $response = $this->fail(env('APP_DEBUG') ? $e->getMessage() : null);
        }

        return $response;
    }

    /**
     * Destroy a comment.
     *
     * @param int $id Comment Id
     * @param bool $force Force delete
     *
     * @return $this
     */
    public function destroy($id, $force = false)
    {
        $comment = Comment::withTrashed()->find($id);

        if (
            !$comment ||
            !auth()->check() ||
            $comment->user_id !== get_current_comment_user()->id
            && !get_buzzy_config('COMMENTS_USER_CAN_DELETE', true)
            && !get_current_comment_user()->isAdmin
        ) {
            return $this->fail();
        }

        try {
            if ($comment->deleted_at === null && $comment->user_id !== get_current_comment_user()->id) {
                event(new CommentUpdated($comment, 'Trash'));
            }

            if ($force) {
                $comment->forceDelete();
            } else {
                $comment->delete();
            }

            $response = $this->success(true, __('Comment Deleted'));
        } catch (\Exception $e) {
            $response = $this->fail(env('APP_DEBUG') ? $e->getMessage() : null);
        }

        return $response;
    }

    /**
     * Vote a comment.
     *
     * @param array $data
     *
     * @return $this
     */
    public function vote($data)
    {
        $data = array_merge(
            $data,
            [
                'type' => "comment",
                'user_id' => Auth::user()->id ?? null,
                'ipno' => request()->ip(),
            ]
        );

        try {
            $comment = Comment::findOrFail($data['comment_id']);
            $logged = Auth::check();
            $guest = get_buzzy_config('COMMENTS_GUEST_COMMENT_VOTING', false);

            if (!$logged && !$guest) {
                return $this->fail(__('You must login to vote!'));
            }

            if (
                $logged && in_array(Auth::user()->id, $comment->votes->pluck('user_id')->toArray())
                || $guest && in_array(request()->ip(), $comment->votes->pluck('ipno')->toArray())
            ) {
                return $this->fail(__('You have already voted this comment!'));
            }

            $vote = $comment->votes()->create($data);
            $response = $this->success($vote);
        } catch (\Exception $e) {
            $response = $this->fail(env('APP_DEBUG') ? $e->getMessage() : null);
        }

        return $response;
    }

    /**
     * Approve a comment.
     *
     * @param integer $id Comment Id
     *
     * @return $this
     */
    public function approve($id, $approve = 1)
    {
        if ($comment = Comment::findOrFail($id)) {
            $comment->update(['approve' => $approve]);

            if ($approve) {
                event(new CommentUpdated($comment, 'Approved'));
            }

            $response = $this->success(null, __('Comment Approved'));
        } else {
            $response = $this->fail();
        }

        return $response;
    }

    /**
     * Report a comment.
     *
     * @param integer $id Comment Id
     *
     * @return $this
     */
    public function report($id, $data)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->reports()->where('user_id', get_current_comment_user()->id)->exists()) {
            return $this->fail(__('You have already reported this comment!'));
        }

        if ($comment && get_buzzy_config('COMMENTS_USER_CAN_REPORT', true)) {
            $comment->reports()->create(array_merge([
                'user_id' => Auth::user()->id,
            ], $data));
            $response = $this->success(null, __('Comment Reported'));
        } else {
            $response = $this->fail();
        }

        return $response;
    }
}
