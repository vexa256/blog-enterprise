<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name', 'name_slug', 'posturl_slug', 'disabled', 'description', 'language', 'type', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function allParents()
    {
        return $this->parent()->with('allParents');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('name', 'asc');
    }

    public function allChildrens()
    {
        return $this->children()->with('allChildrens');
    }

    /**
     * The posts that belong to the category.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'post_categories', 'category_id', 'post_id');
    }

    public function scopeByMain($query)
    {
        return $query->whereNull("parent_id");
    }

    public function scopeBySub($query)
    {
        return $query->whereNotNull("parent_id");
    }

    public function scopeByType($query, $type)
    {
        return $query->where("type", $type);
    }

    public function scopeByLanguage($query, $language = null)
    {
        if ($language) {
            return $query->where('language', $language);
        }

        return $query->where('language', get_buzzy_query_locale());
    }

    public function scopeByActive($query)
    {
        return $query->where("disabled", "0");
    }

    public function scopeByOrder($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Force a hard delete user.
     *
     * @return bool|null
     */
    public function delete()
    {
        //remove sub categories
        $this->children()->delete();

        //remove category
        parent::delete();
    }
}
