<?php

namespace App\Jobs;

use App\Tag;
use App\Feed;
use App\Post;
use App\Entry;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Managers\UploadManager;
use Illuminate\Queue\SerializesModels;
use App\Handlers\Editor\ContentFetcher;
use Illuminate\Queue\InteractsWithQueue;
use Vedmant\FeedReader\Facades\FeedReader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchFeedPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $feed;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $f = FeedReader::read($this->feed->url);

            if ($f) {
                collect($f->get_items())->slice(0, $this->feed->post_fetch_count)
                    ->each(function ($feed_item) {
                        if ($this->feed->checked_at === null || Carbon::create($feed_item->get_date())->greaterThan($this->feed->checked_at->toDateTimeString())) {
                            $content_fetcher = new ContentFetcher();
                            $content = $content_fetcher->run($feed_item->get_link());
                            if (isset($content['status']) && $content['status'] === 'error') {
                                return true;
                            }

                            if ($this->feed->content_fetcher === 'custom' && empty($content['preview'])) {
                                return true;
                            }

                            $title = $this->sanitize_text($feed_item->get_title());
                            $slug = sanitize_title_with_dashes($title);

                            if (Post::where('slug', $slug)->first()) {
                                return true;
                            }

                            $post = new Post();
                            $post->title = $title;
                            $post->slug = $slug;
                            $post->body = isset($content['description']) ? $content['description'] : '';
                            $post->type = 'news';
                            $post->user_id = $this->feed->post_user_id;
                            $post->ordertype = null;
                            $post->pagination = null;
                            $post->published_at = now();
                            $post->language = isset($this->feed->language) ? $this->feed->language  : get_default_language();

                            if (!empty($content['preview'])) {
                                $image = new UploadManager();
                                $image->path('upload/media/posts');
                                $image->name($post->slug . '_' . time());
                                $image->setUrlFile($content['preview']);
                                $image->make();
                                $image->mime('jpg');
                                $image->save(
                                    [
                                        'fit_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_big_width', 768),
                                        'fit_height' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_big_height', 440),
                                        'image_size' => 'b',
                                    ]
                                ); // move big image
                                $image->save(
                                    [
                                        'fit_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_small_width', 400),
                                        'fit_height' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_small_height', 266),
                                        'image_size' => 's',
                                    ]
                                );

                                $post->thumb = $image->getPathforSave();
                            }

                            $post->approve = 'yes';
                            $post->save();

                            $post->categories()->sync(explode(',', $this->feed->post_categories));

                            $tagIds = (isset($content['tags']) && !empty($content['tags'])) ? collect(explode(',', $content['tags']))->map(function ($tagName) use ($post) {
                                if (trim($tagName) === '') {
                                    return null;
                                }
                                return Tag::firstOrCreate([
                                    'name' => $tagName,
                                    'slug' => Str::slug($tagName, '-', $post->language),
                                    'type' => 'post_tag'
                                ]);
                            })->pluck('id') : [];

                            $post->tags()->sync($tagIds);

                            $entry = new Entry;
                            $entry->user_id = $post->user_id;
                            $entry->post_id = $post->id;
                            $entry->type = 'text';
                            $entry->order = 0;
                            $entry->title = null;
                            $entry->body = $this->feed->content_fetcher === 'custom' ? $content['content'] : $feed_item->get_content();
                            $entry->source = $feed_item->get_link();
                            $entry->image = null;
                            $entry->save();
                        }
                    });
            }
        } catch (\Exception $th) {
            //
        }

        $this->feed->checked_at = now();

        return $this->feed->save();
    }

    public function sanitize_text($string)
    {
        if (!is_string($string)) {
            return '';
        }

        return htmlspecialchars_decode(strip_tags($string));
    }
}
