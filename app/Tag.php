<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $hidden = ['pivot'];
    protected $guarded = ['id'];
    protected $fillable = [
        'name', 'slug', 'icon', 'color', 'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany;
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function scopeByType($query, $type)
    {
        return $query->where("type", $type);
    }
}
