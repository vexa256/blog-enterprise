<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Traits\Post\PostStats;
use App\Managers\UploadManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes, PostStats;

    protected $table = 'posts';

    protected $fillable = [
        'slug', 'title', 'body', 'user_id', 'pagination', 'shared',
        'type', 'ordertype', 'thumb', 'approve', 'language',
        'show_in_homepage', 'featured_at', 'published_at', 'deleted_at',
        'one_day_stats', 'seven_days_stats', 'thirty_days_stats', 'all_time_stats', 'raw_stats'
    ];

    protected $dates = ['created_at', 'featured_at', 'published_at', 'deleted_at'];

    protected $casts = ['shared' => 'json'];

    protected $appends = [
        'post_link',
    ];

    protected $softDelete = true;

    /**
     * Post belongs to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Post has many entries
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entries()
    {
        return $this->hasMany('App\Entry', 'post_id');
    }

    /**
     * Post belongs to many category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'post_categories', 'post_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    /**
     * Post has many comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }

    /**
     * Post has many comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function popularComments()
    {
        return $this->comments()->parent()->approved()->popular();
    }

    /**
     * Post has many poll votes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollvotes()
    {
        return $this->hasMany('App\PollVotes', 'post_id');
    }

    /**
     * Post has many poll options
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reactions()
    {
        return $this->hasMany('App\Reaction', 'post_id');
    }

    public function getSharedAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get cached posts
     */
    public function scopeGetCached($query, $key, $cacheTime = 60)
    {
        $locale = app()->getLocale();
        $cache_key = 'posts_' . $key . $locale;
        $posts = Cache::get($cache_key);

        if (!empty($posts)) {
            return $posts;
        }

        $posts = $query->get();

        Cache::put($cache_key, $posts, $cacheTime);

        return $posts;
    }

    /**
     * Get paginated cached posts
     */
    public function scopePaginateCached($query, $key, $paginate, $cacheTime = 60)
    {
        $page = request()->query('page', 1);
        $locale = app()->getLocale();
        $cache_key = 'paginate_posts_' . $key . $locale . $page;
        $posts = Cache::get($cache_key);
        if (!empty($posts)) {
            return $posts;
        }

        $posts = $query->paginate($paginate);

        Cache::put($cache_key, $posts, $cacheTime);

        return $posts;
    }

    /**
     * Get posts by type
     *
     * @param  $type
     * @return mixed
     */
    public function scopeByType($query, $type)
    {
        if ($type == 'all') {
            return $query;
        }
        return $query->where('type', $type);
    }

    /**
     * Get posts by category and its childs
     *
     * @param  $query
     * @param  $category_id
     * @return mixed
     */
    public function scopeByCategories($query, $category_ids)
    {
        if (!is_array($category_ids)) {
            $category_ids = Arr::wrap($category_ids);
        }

        return $query->whereHas('categories', function ($query) use ($category_ids) {
            $query->whereIntegerInRaw('categories.id', $category_ids);
        });
    }

    /**
     * Get posts by category
     *
     * @param  $query
     * @param  $category_id
     * @return mixed
     */
    public function scopeByCategory($query, $category_id)
    {
        return $query->whereHas('categories', function ($query) use ($category_id) {
            $query->where('categories.id', $category_id);
        });
    }

    /**
     * Get approval posts
     *
     * @param  $type
     * @return mixed
     */
    public function scopeApprove($query, $type)
    {
        return $query->where('approve', $type);
    }

    /**
     * Get approval posts
     *
     * @param  $type
     * @return mixed
     */
    public function scopeByApproved($query)
    {
        return $query->where('approve', 'yes');
    }

    /**
     * Get post by category
     *
     * @param  $query
     * @param  $categoryid
     * @return mixed
     */
    public function scopeByPublished($query)
    {
        return $query->whereNotNull("published_at")
            ->where("published_at", '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->latest('published_at');
    }

    /**
     * Get post by language
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
     * Get post by featured
     *
     * @param  $query
     * @return mixed
     */
    public function scopeByFeatured($query)
    {
        return $query->whereNotNull("featured_at")
            ->latest("featured_at");
    }

    /**
     * Get post for home
     *
     * @param  $query
     * @param  $categoryid
     * @return mixed
     */
    public function scopeForHome($query, $features = null)
    {
        if ($features !== null || get_buzzy_config('AutoInHomepage') == 'no') {
            return $query->where("show_in_homepage", 'yes');
        }

        return $query;
    }

    public function scopeByAcceptedTypes($query, $types)
    {
        if (is_bool($types) && !$types) {
            return $query;
        }

        $types = is_array($types) ? $types : json_decode($types);
        $only_types = [];
        $only_ids = [];

        foreach ($types as $type) {
            if (in_array($type, ['news', 'list', 'quiz', 'poll', 'video'])) {
                $only_types[] = $type;
            } else {
                $only_ids[] = intval($type);
            }
        }

        if (!empty($only_types)) {
            $query->whereIn("type", $only_types);
        } elseif (!empty($only_ids)) {
            $query->byCategories(get_category_ids_recursively($only_ids));
        }

        return $query;
    }

    public $main_url;

    public function getPostLinkAttribute()
    {
        if (!empty($this->main_url)) {
            return $this->main_url;
        }

        $type =  get_buzzy_config('siteposturl', 1);

        if ($type == "" || $type == null || $type == 1 || $type == 2 || $type == 5) {
            $slug = $this->slug;

            if ($type == 2 || empty($this->slug)) {
                $slug = $this->id;
            } elseif ($type == 5) {
                $slug = $this->slug . '-' . $this->id;
            }

            $category = $this->categories()->first();

            if ($category) {
                $cat_slug = $category->posturl_slug ? $category->posturl_slug : $category->name_slug;
            } else {
                $cat_slug = $this->type;
            }

            $url = route('post.show', ['catname' => $cat_slug, 'slug' => $slug]);
        } elseif ($type == 3 && $this->user) {
            $url = route('post.show', ['catname' => $this->user->username_slug, 'slug' => $this->slug]);
        } elseif ($type == 4 && $this->user) {
            $url = route('post.show', ['catname' => $this->user->username_slug, 'slug' => $this->id]);
        } else {
            $url = route('post.show', ['catname' => 'post', 'slug' => $this->id]);
        }

        $this->main_url = $url;

        return $url;
    }

    /**
     * Force a hard delete on a soft deleted model.
     *
     * This method protects developers from running forceDelete when trait is missing.
     *
     * @return bool|null
     */
    public function forceDelete()
    {
        $this->forceDeleting = true;

        // @TODO move this to repository
        if (!empty($this->thumb)) {
            $imageM = new UploadManager();
            $imageM->delete(makepreview($this->thumb, 'b', 'posts'));
            $imageM->delete(makepreview($this->thumb, 's', 'posts'));
        }

        $this->entries()->withTrashed()->forceDelete();

        $this->reactions()->forceDelete();
        $this->pollvotes()->forceDelete();
        $this->comments()->forceDelete();
        $this->categories()->detach();
        $this->tags()->detach();

        $this->delete();

        $this->forceDeleting = false;
    }
}
