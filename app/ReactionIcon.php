<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReactionIcon extends Model
{
    protected $table = 'reactions_icons';

    protected $fillable = ['ord', 'icon', 'name', 'reaction_type', 'display', 'language'];

    /**
     * Reaction belongs to a post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reactions()
    {
        return $this->hasMany('App\Reaction', 'reaction_type', 'reaction_type');
    }

    /**
     * Get reaction icons by language
     *
     * @param  $query
     * @param  $language
     * @return mixed
     */
    public function scopeByLanguage($query, $language = null)
    {
        if ($language) {
            return $query->where('language', $language);
        }

        return $query->where('language', get_buzzy_query_locale());
    }

    /**
     * Get active reaction icons
     *
     * @param  $query
     * @return mixed
     */
    public function scopeByActive($query)
    {
        return $query->where('display', 'on');
    }
}
