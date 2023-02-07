<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PostController extends Controller
{
    /**
     * Show a Post
     *
     * @return \Illuminate\View\View
     */
    public function index($catname, $slug)
    {
        $type =  get_buzzy_config('siteposturl', 1);

        $post = Post::with('user')->byLanguage();

        if ($type == 1) {
            $post = $post->where('slug', $slug)->firstOrFail();
        } elseif ($type == 2) {
            $post = $post->findOrFail((int) $slug);
        } elseif ($type == 3) {
            $usera = User::bySlug($catname)->firstOrFail();
            $post = $post->where('user_id', $usera->id)->where('slug', $slug)->firstOrFail();
        } elseif ($type == 4) {
            $usera = User::bySlug($catname)->firstOrFail();
            $post = $post->where('user_id', $usera->id)->where('id', (int) $slug)->firstOrFail();
        } elseif ($type == 5) {
            $parts = explode("-", $slug);
            $post = $post->findOrFail((int) end($parts));
        }

        $publish_from_now = $post->published_at && $post->published_at->getTimestamp() > Carbon::now()->getTimestamp();

        if ($post->approve !== 'yes' || $publish_from_now) {
            if (!Auth::check() || Auth::user()->usertype != 'Admin' && Auth::user()->id != $post->user->id) {
                abort(404);
            }
        }

        $this->postHit($post);

        $entries = $post->entries()->where('type', '!=', 'answer');
        if ($post->pagination !== null) {
            $entries =  $entries->orderBy('order', $post->ordertype == 'desc' ? 'desc' : 'asc')->paginate($post->pagination);
        } else {
            $entries =  $entries->orderBy('order', 'asc')->get();
        }

        $categories = $post->categories()->get();
        $tags = $post->tags()->get();

        $lastTrending = Post::getStats('one_day_stats', 'DESC', 10)
            ->byPublished()
            ->byLanguage()
            ->byApproved()
            ->getCached('post_trending', now()->addMinutes(5));


        $has_video_player = collect($entries)->contains(function ($entry) {
            return !empty($entry->type) && $entry->type === 'video' && in_array(substr($entry->video, -3),  ['mp4', 'webm']);
        });

        return view(
            "pages/post",
            compact(
                'post',
                'entries',
                'tags',
                'categories',
                'lastTrending',
                'publish_from_now',
                'has_video_player'
            )
        );
    }

    /**
     *
     * @return \Illuminate\View\View
     */
    public function autoload(Request $request)
    {
        $post = "";
        $id = $request->query('id');
        $type = $request->query('type');
        $pid = $request->query('pid');

        $posta = Post::with('user')->byPublished()->byApproved()->find($id);

        if (!$posta || $posta->type == 'quiz') {
            return "no";
        }

        $categories = $posta->categories()->get();
        $tags = $posta->tags()->get();

        $idarays = array_filter(explode('|', $pid));

        $post = null;
        foreach ($categories as $tag) {
            if ($posto = $tag->posts()->where('posts.type', '!=', 'quiz')->whereNotIn('posts.id',  $idarays)->byPublished()->byLanguage()->byApproved()->first()) {
                $post = $posto;
                break;
            }
        }

        if (!$post) {
            foreach ($posta->categories()->get() as $category) {
                if ($posto = $category->posts()->where('posts.type', '!=', 'quiz')->whereNotIn('posts.id',  $idarays)->byPublished()->byLanguage()->byApproved()->first()) {
                    $post = $posto;
                    break;
                }
            }
        }


        if (!$post) {
            return "no";
        }

        $entries = $post->entries()->where('type', '!=', 'answer');
        if ($post->pagination == null) {
            $entries =  $entries->orderBy('order', $post->ordertype == 'desc' ? 'desc' : 'asc')->get();
        } else {
            $entries =  $entries->orderBy('order', $post->ordertype == 'desc' ? 'desc' : 'asc')->paginate($post->pagination);
        }

        $publish_from_now = '';

        return view("pages._article", compact(
            "post",
            'entries',
            'tags',
            'categories',
            'publish_from_now'
        ));
    }

    public function postHit($post)
    {
        if (null == Cookie::get('BuzzyPostHit' . $post->id)) {
            $post->hit();
            Cookie::queue('BuzzyPostHit' . $post->id, "1", 10, $post->post_link);
        }
    }
}
