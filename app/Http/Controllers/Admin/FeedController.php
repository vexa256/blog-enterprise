<?php

namespace App\Http\Controllers\Admin;

use App\Feed;
use App\Jobs\FetchFeedPosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Vedmant\FeedReader\Facades\FeedReader;

class FeedController extends MainAdminController
{
    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['store', 'update', 'destroy']]);

        parent::__construct();
    }

    public function index(Request $request)
    {
        $feeds = Feed::whereNotNull('url');
        if (get_multilanguage_enabled()) {
            $feeds = $feeds->where('language', get_buzzy_locale());
        }
        $feeds = $feeds->get();

        $feed = Feed::find($request->edit);
        return view('_admin.pages.feeds.index', compact('feeds', 'feed'));
    }

    /**
     * Create new menu.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (($errors = $this->validation($request->all())) !== true) {
            return $errors;
        }

        try {
            $f = FeedReader::read($request->input('url'));

            if (empty($f->get_title())) {
                throw new \Exception(trans('v4half.cant_fetch_feed'));
            }

            $feed = new Feed();
            $feed->title = $f->get_title();
            $feed->url = $request->input('url');
            $feed->interval = $request->input('interval');
            $feed->post_user_id = $request->input('post_user_id');
            $feed->post_fetch_count = $request->input('post_fetch_count', 10);
            $feed->content_fetcher = $request->input('content_fetcher', 'custom');
            $feed->post_categories = implode(',',  $request->input('post_categories'));
            $feed->language = $request->input('language', get_default_language());
            $feed->active = $request->input('active', 1);
            $feed->checked_at = null;
            $feed->save();

            if ($feed->active) {
                FetchFeedPosts::dispatch($feed);
            }
        } catch (\Exception $e) {
            Session::flash('error.message', $e->getMessage());
            return redirect()->back()->withInput($request->all());
        }

        return redirect()->back();
    }

    /**
     * Update the specified menu.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (($errors = $this->validation($request->all())) !== true) {
            return $errors;
        }
        if ($request->id && $feed = Feed::find($request->id)) {
            $feed->url = $request->input('url');
            $feed->interval = $request->input('interval');
            $feed->post_fetch_count = $request->input('post_fetch_count', 10);
            $feed->post_user_id = $request->input('post_user_id');
            $feed->post_categories = implode(',',  $request->input('post_categories'));
            $feed->content_fetcher = $request->input('content_fetcher', 'custom');
            $feed->language = $request->input('language', $feed->language);
            $feed->active = $request->input('active', 1);
            $feed->checked_at = null;
            $feed->update();

            if ($feed->active) {
                FetchFeedPosts::dispatch($feed);
            }
        }

        return redirect()->back();
    }

    /**
     * Delete the specified menu.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->id) {
            $menu = Feed::find($request->id);
            $menu->delete();
        }

        return redirect()->back();
    }

    /**
     * Validation.
     *
     * @param array $data
     *
     * @return \Illuminate\Http\Response|true
     */
    public function validation($data)
    {
        $validator = Validator::make($data, [
            'url' => 'required',
            'interval' => 'required',
            'post_user_id' => 'required',
            'post_categories' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('error.message', $validator->errors()->first());
            return redirect()->back()->withInput($data);
        }

        return true;
    }
}
