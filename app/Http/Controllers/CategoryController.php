<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Show category
     *
     * @param  Request $request
     * @param  $category
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function __invoke(Request $request, $slug)
    {
        $category = Category::with(['children', 'allChildrens'])->where("name_slug", $slug)->firstOrFail();

        $allIds = get_category_all_childids_recursively($category);

        //top featured posts style
        $gridStyle = get_buzzy_theme_config('CatHeadlineStyle', 1);

        if ($gridStyle && $gridStyle != 'off') {
            $lastFeaturestop = Post::with('user')->byCategories($allIds)
                ->byPublished()
                ->byLanguage()
                ->byApproved()
                ->byFeatured()
                ->take(get_headline_posts_count(true))
                ->get();
            $lastFeaturestopIds = $lastFeaturestop->pluck('id')->all();
        } else {
            $lastFeaturestop = [];
            $lastFeaturestopIds = [];
        }

        $posts = Post::with('user')->whereNotIn('id', $lastFeaturestopIds)->byCategories($allIds)
            ->byPublished()->byLanguage()->byApproved()->paginate(16);

        $lastTrending = Post::getStats('seven_days_stats', 'DESC', 7)
            ->byCategories($allIds)
            ->byPublished()
            ->byLanguage()
            ->byApproved()
            ->getCached('cat_trending_' . $category->id, now()->addMinutes(5));

        if ($request->ajax() && $request->query('page')) {
            return view('pages.catpostloadpage', compact('posts'));
        }

        return view("pages.category", compact("category", "posts", "lastTrending", "lastFeaturestop"));
    }
}
