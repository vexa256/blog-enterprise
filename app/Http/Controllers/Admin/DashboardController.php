<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use Carbon\Carbon;

class DashboardController extends MainAdminController
{
    public function index()
    {
        $rangetoday = Carbon::now()->subDays(1);

        $postunapprove = Post::approve('no')->byLanguage()->count();

        $todaypost = Post::where('created_at', '>=', $rangetoday)->byLanguage()->count();

        $todayusers = User::where('created_at', '>=', $rangetoday)->count();

        $todaylogins = User::where('updated_at', '>=', $rangetoday)->count();

        $listcount = Post::byType('list')->byLanguage()->count();

        $videocount = Post::byType('video')->byLanguage()->count();

        $pollcount = Post::byType('poll')->byLanguage()->count();

        $newscount = Post::byType('news')->byLanguage()->count();

        $lastunappruves = Post::with('user')->byLanguage()->approve('no')->take('10')->latest()->get();

        $lastusers = User::latest("created_at")->take(12)->get();

        return view(
            '_admin.pages.index',
            compact(
                'todaypost',
                'todaypost',
                'postunapprove',
                'todayusers',
                'todaylogins',
                'listcount',
                'videocount',
                'pollcount',
                'newscount',
                'lastunappruves',
                'lastusers'
            )
        );
    }
}
