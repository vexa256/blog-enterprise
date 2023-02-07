<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Show Tags
     *
     * @param  Tag $tag
     *
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function show($tag)
    {
        $tag = Tag::byType('post_tag')->where("slug", $tag)->firstOrFail();

        $posts = $tag->posts()->byPublished()->byLanguage()->byApproved()->paginate(15);

        return view("pages.tag", compact("posts", "tag"));
    }

    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $q = strip_tags($request->get('q'));
        $tags = Tag::byType('post_tag')->where('name', 'LIKE', "$q%")->take(10)->get();

        return response()->json($tags);
    }
}
