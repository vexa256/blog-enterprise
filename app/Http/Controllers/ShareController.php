<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class ShareController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->route('home');
        }

        $inputs = $request->all();

        $id = Arr::get($inputs, 'contentId');
        $shareType = Arr::get($inputs, 'shareType');
        $post = Post::findOrFail($id);

        if (!isset($shareType)) {
            $shareType = 'facebook';
        }

        if (null ==  Cookie::get('BuzzyPostShared' . $shareType . $post->id)) {
            cookie('BuzzyPostShared' . $shareType . $post->id, $post->id, 15000, $post->post_link);
        } else {
            return "ok";
        }

        $oshared = (array) $post->shared;

        $oshared[$shareType] = isset($oshared[$shareType]) ? (int) $oshared[$shareType] + 1 : 0;

        $post->shared = $oshared;
        $post->save();

        return "ok";
    }
}
