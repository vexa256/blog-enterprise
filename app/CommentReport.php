<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CommentReport extends Model
{
    public $table = 'comment_reports';
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
}
