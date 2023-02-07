<?php

namespace App\Http\Controllers;

use App\Post;
use App\Reaction;
use App\ReactionIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReactionController extends Controller
{
    public function __construct()
    {
        if (get_buzzy_config('sitevoting') == "1") {
            $this->middleware('auth', ['only' => ['vote']]);
        }
    }

    /**
     * Show Reaction Pages
     *
     * @param  $catname
     * @param  Request $req
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function show(ReactionIcon $reactionIcon)
    {
        $posts = Post::withCount([
            'reactions' => function ($query) use ($reactionIcon) {
                $query->where('reaction_type', $reactionIcon->reaction_type);
            },
        ])
            ->latest('reactions_count')
            ->byPublished()
            ->byLanguage()
            ->byApproved()
            ->paginateCached('reaction_posts_' . $reactionIcon->reaction_type, 15, now()->addMinutes(5));

        $reaction = $reactionIcon;

        return view("pages.reaction", compact("posts", "reaction"));
    }

    public function vote(ReactionIcon $reactionIcon, Post $post)
    {
        if (!request()->ajax()) {
            return redirect()->route('home');
        }

        if (Reaction::currentUserHasVoteOnPost($post->id)->count() <= 2) {
            Reaction::firstOrNew([
                'post_id' => $post->id,
                'user_id' => auth()->check() ? auth()->user()->id : request()->ip(),
                'reaction_type' => $reactionIcon->reaction_type
            ])->save();
        }

        return view('_particles.post.reactions', compact("post"));
    }
}
