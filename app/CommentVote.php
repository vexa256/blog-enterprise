<?php

namespace App;

use App\User;
use App\Comment;
use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model
{
    public $table = 'comment_votes';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Get Like vote types.
     */
    public function scopeType($query, $type = 'comment')
    {
        return $query->where('type', $type);
    }

    /**
     * Get Like vote types.
     */
    public function scopeLikes($query)
    {
        return $query->where('vote', 1);
    }

    /**
     * Get disLike vote types.
     */
    public function scopeDislikes($query)
    {
        return $query->where('vote', 0);
    }
}
