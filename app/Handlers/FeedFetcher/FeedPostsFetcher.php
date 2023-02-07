<?php

namespace App\Handlers\FeedFetcher;

use App\Feed;
use App\Jobs\FetchFeedPosts;

class FeedPostsFetcher
{
    public $interval = 'daily';

    public function __construct($interval)
    {
        $this->interval = $interval;
    }

    public function __invoke()
    {
        $feeds = Feed::where('interval', $this->interval)->active()->get();
        foreach ($feeds as $feed) {
            FetchFeedPosts::dispatch($feed);
        }
    }
}
