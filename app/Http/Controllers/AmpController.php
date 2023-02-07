<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Auth;

class AmpController extends Controller
{
    /**
     * Show a Amp Post
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (get_buzzy_config('p_amp') !== 'on') {
            return route('home');
        }

        $lastFeaturestop = Post::byPublished()->byLanguage()->byApproved()->byFeatured()->take(10)->get();

        $lastNews =   Post::byPublished()->byLanguage()->byApproved()->paginate(10);

        return view('amp.index', compact('lastFeaturestop',  'lastNews'));
    }

    /**
     * Show a Amp Post
     *
     * @return \Illuminate\View\View
     */
    public function post($catname, $id)
    {
        $post = Post::with('user')->where('id', $id)->byPublished()->firstOrFail();

        if (get_buzzy_config('p_amp') !== 'on') {
            return redirect($post->post_link);
        }

        if ($post->approve !== 'yes') {
            if (!Auth::check() || !Auth::user()->isAdmin() && Auth::user()->id != $post->user->id) {
                abort(404);
            }
        }

        $entries = $post->entries()->where('type', '!=', 'answer')->orderBy('order', $post->ordertype == 'desc' ? 'desc' : 'asc')->get();

        $lastFeatures = Post::getStats('one_day_stats', 'DESC', 6)->byType($post->type)->byPublished()->byLanguage()->byApproved()->get();

        return view("amp/post", compact('post', 'entries', 'lastFeatures'));
    }
}
