<?php

namespace App\Http\Controllers;

use App\Post;

class IndexController extends Controller
{
    public function __invoke()
    {
        if (Post::count() < 1) {
            return view('errors.starting');
        }

        $lastFeaturestop = [];
        $HomeColSec1Tit1 = null;
        $HomeColSec2Tit1 = null;
        $HomeColSec3Tit1 = null;
        $CurrentTheme = get_buzzy_theme();
        $HomeColSec1Type1 = config('buzzytheme_' . $CurrentTheme . '.HomeColSec1Type1', ["list", "quiz"]);
        $HomeColSec2Type1 = config('buzzytheme_' . $CurrentTheme . '.HomeColSec2Type1', ["news"]);
        $HomeColSec3Type1 = config('buzzytheme_' . $CurrentTheme . '.HomeColSec3Type1', ["video"]);

        if (get_buzzy_config('p_homepagebuilder') == "on" && (!get_multilanguage_enabled() || get_multilanguage_enabled() && get_default_language() === get_buzzy_Locale())) {
            $HomeColSec1Tit1 = get_buzzy_config('HomeColSec1Tit1');
            $HomeColSec2Tit1 = get_buzzy_config('HomeColSec2Tit1');
            $HomeColSec3Tit1 = get_buzzy_config('HomeColSec3Tit1');
            $HomeColSec1Type1 = get_buzzy_config('HomeColSec1Type1', $HomeColSec1Type1);
            $HomeColSec2Type1 = get_buzzy_config('HomeColSec2Type1', $HomeColSec2Type1);
            $HomeColSec3Type1 = get_buzzy_config('HomeColSec3Type1', $HomeColSec3Type1);
        }

        // Colums 1
        $lastFeatures = Post::forHome()->byAcceptedTypes($HomeColSec1Type1)->byPublished()->byLanguage()->byApproved()->paginate(10);

        // Colums 1 - Latest Videos
        $lastVideos  = Post::forHome()->byType('video')->byPublished()->byLanguage()->byApproved()->getStats('one_day_stats', 'DESC')->paginate(3);

        // Colums 1 - Latest Polls
        $lastPolls = Post::forHome()->byType('poll')->byPublished()->byLanguage()->byApproved()->paginate(2);

        // Colums 2
        $lastNews = Post::forHome()->byAcceptedTypes($HomeColSec2Type1)->byPublished()->byLanguage()->byApproved()->paginate(config('buzzytheme_' . $CurrentTheme . '.homepage_news_limit', 10));

        if (request()->query('page')) {
            if (!request()->ajax()) {
                return redirect()->route('home');
            }

            if (request()->query("timeline") == "right") {
                return view('pages.indexrightpostloadpage', compact('lastNews'));
            } else {
                return view('pages.indexpostloadpage', compact('lastFeatures', 'lastVideos', 'lastPolls'));
            }
        }

        // Featured Posts
        if (get_buzzy_theme_config('SiteHeadlineStyle') != 'off') {
            $lastFeaturestop = Post::with('user')->forHome('Features')->byPublished()->byLanguage()->byApproved()->byFeatured()->take(get_headline_posts_count())->get();
        }

        // Colums 3
        $lastTrendingVideos = Post::forHome()->byAcceptedTypes($HomeColSec3Type1)->byPublished()->byLanguage()->byApproved()->take(10)->get();

        // Trending Posts
        $lastTrending = Post::forHome()->getStats('one_day_stats', 'DESC', 10)->byPublished()->byLanguage()->byApproved()->getCached('home_trending', now()->addMinutes(5));

        return view(
            'pages.index',
            compact(
                'lastFeaturestop',
                'lastFeatures',
                'lastVideos',
                'lastPolls',
                'lastNews',
                'lastTrending',
                'lastTrendingVideos',
                'HomeColSec1Tit1',
                'HomeColSec2Tit1',
                'HomeColSec3Tit1'
            )
        );
    }
}
