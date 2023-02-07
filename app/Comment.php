<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];


    public static function boot()
    {
        parent::boot();

        static::deleting(function (Comment $comment) {
            $comment->votes()->delete();
            $comment->reports()->delete();
            $comment->replies()->delete();
        });
    }

    public function replies()
    {
        return $this->hasMany('App\Comment', 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function votes()
    {
        return $this->hasMany(CommentVote::class, 'comment_id');
    }

    public function likes()
    {
        return $this->votes()->where('vote', 1);
    }

    public function dislikes()
    {
        return $this->votes()->where('vote', 0);
    }

    public function reports()
    {
        return $this->hasMany(CommentReport::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function allParents()
    {
        return $this->parent()->with('allParents');
    }

    /**
     * Filter get with relations.
     */
    public function scopeWithRelations($query)
    {
        $maxRepliesCount = env('COMMENTS_SHOW_REPLY_COUNT', 3);
        $repliesSort = env('COMMENTS_REPLIES_DEFAULT_SORT', 'old');

        return $query->with(
            [
                'user',
                'replies' => function ($query) use ($repliesSort, $maxRepliesCount) {
                    $query->withRelations()->approved()->orderCommentsBy($repliesSort)->take($maxRepliesCount);
                },
                'replies.user'
            ]
        )
            ->withCount('replies', 'likes', 'dislikes');
    }

    /**
     * Filter get only parent comments.
     */
    public function scopeOnlyParent($query)
    {
        return $query->where('parent_id', null);
    }

    /**
     * Filter get only parent comments.
     */
    public function scopeOnlyReplies($query)
    {
        return $query->where('parent_id', '!=', null);
    }

    /**
     * Filter get approved comments.
     */
    public function scopeApproved($query, $approve = true)
    {
        return $query->where('approve', $approve);
    }

    /**
     * Filter by content id.
     */
    public function scopeByParent($query, $parent_id)
    {
        if ($parent_id) {
            return $query->where('parent_id', $parent_id);
        }

        return $query;
    }

    /**
     * Filter by content id.
     */
    public function scopeByUser($query, $user_id)
    {
        if ($user_id) {
            return $query->where('user_id', intval($user_id));
        }

        return $query;
    }

    /**
     * Filter by content id.
     */
    public function scopeByPost($query, $content_id)
    {
        if ($content_id) {
            return $query->where('post_id', $content_id);
        }

        return $query;
    }

    /**
     * Filter get approved comments.
     */
    public function scopeOrderCommentsBy($query, $type = null)
    {
        if (!$type) {
            $type = get_buzzy_config('COMMENTS_DEFAULT_SORT', 'new');
        }

        if ($type === 'new') {
            return $query->latest();
        } elseif ($type === 'old') {
            return $query->oldest();
        } elseif ($type === 'best') {
            return $query->orderBy('likes_count', 'desc');
        }

        return $query;
    }

    public function getDataAttribute($value)
    {
        return (array) json_decode($value);
    }

    public function getLevelAttribute()
    {
        return !$this->parent_id ? 1 : $this->parent->level + 1;
    }

    public function isRepliesAllowed()
    {
        return $this->level < get_buzzy_config('COMMENTS_MAX_LEVEL', 3);
    }

    public function getUserdataAttribute()
    {
        $data = new \stdClass();

        if ($this->user) {
            $data->type = "auth";
            $data->id = $this->user->id;
            $data->link = $this->user->profile_link;
            $data->icon = makepreview($this->user->icon, 's', 'members/avatar');
            $data->username = $this->user->username;
            $data->usertype = $this->user->usertype;
        } else {
            $data->type = "guest";
            $data->id = null;
            $data->link = '#';
            $data->icon = makepreview(null, 's', 'members/avatar');
            $data->username = isset($this->data['guest']) && isset($this->data['username']) ? $this->data['username'] : __('Guest');
            $data->usertype = 'guest';
        }

        return $data;
    }
}
