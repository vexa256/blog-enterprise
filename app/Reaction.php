<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Reaction extends Model
{
    protected $table = 'reactions';

    protected $fillable = ['post_id', 'user_id', 'reaction_type'];

    /**
     * Reaction belongs to a post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }

    /**
     * Reaction belongs to a post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reaction_icon()
    {
        return $this->belongsTo('App\ReactionIcon', 'reaction_type', 'reaction_type');
    }

    public function scopeVoteOnPost($query)
    {
        if (Auth::check()) {
            $auser = Auth::user()->id;
        } else {
            $auser = request()->ip();
        }

        return $query->where('user_id', $auser);
    }

    public function scopeCurrentUserHasVoteOnPost($query, $post)
    {
        if (Auth::check()) {
            $auser = Auth::user()->id;
        } else {
            $auser = request()->ip();
        }

        return $query->where('user_id', $auser)->where('post_id', $post);
    }

    public function scopeCurrentUserHasVoteOnReaction($query, $reaction_type)
    {
        if (Auth::check()) {
            $auser = Auth::user()->id;
        } else {
            $auser = request()->ip();
        }

        return $query->where('user_id', $auser)->where('reaction_type', $reaction_type);
    }
}
