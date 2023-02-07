<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Show search page
     *
     * @param  Request $req
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function index(Request $req)
    {
        $q = clean($req->query('q'), 'titles');

        $posts = Post::where(
            function ($query) use ($q) {
                $query->where("posts.title", "LIKE", "%$q%");

                $query->orWhereHas('tags', function ($query) use ($q) {
                    $query->where("tags.name", "LIKE", "%$q%");
                });
            }
        )
            ->byPublished()
            ->byLanguage()
            ->byApproved()
            ->paginateCached('search_' . Str::slug($q), 10, now()->addMinutes(5));

        if ($req->query('page')) {
            if ($req->ajax()) {
                return view('pages.catpostloadpage', compact('posts'));
            }
        }

        $search = trans('updates.searchfor', ['word' => $q]);

        return view('pages.search', compact("posts", "search"));
    }

    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function searchUsers(Request $request)
    {
        $q = clean($request->get('q'), 'titles');
        $users = User::where('username', 'LIKE', "$q%")->take(10)->get();

        return response()->json($users);
    }
}
