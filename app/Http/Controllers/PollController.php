<?php

namespace App\Http\Controllers;

use App\Entry;
use App\PollVotes;
use App\Http\Controllers\Controller;

class PollController extends Controller
{
    public function __construct()
    {
        if (get_buzzy_config('sitevoting') == "1") {
            $this->middleware('auth');
        }
    }

    public function vote(Entry $entry, Entry $answer)
    {
        if (!request()->ajax()) {
            return redirect()->route('home');
        }

        PollVotes::firstOrNew([
            'post_id' => $entry->id,
            'option_id' => $answer->id,
            'user_id' => auth()->check() ? auth()->user()->id : request()->ip(),
        ])->save();

        $post = $entry->post;

        return view('_particles.post._entries._poll_answers', compact("post", "entry"));
    }
}
