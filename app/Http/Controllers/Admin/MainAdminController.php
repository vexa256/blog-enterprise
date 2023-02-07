<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\Comment;
use App\Contacts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Api\AkProductApi;

class MainAdminController extends Controller
{
    /**
     * Update API.
     *
     * @var AkProductApi
     */
    public $product_api;

    public function __construct()
    {
        $unapprovenews = Post::approve('no')->byLanguage()->byType('news')->count();

        $unapprovelists = Post::approve('no')->byLanguage()->byType('list')->count();

        $unapprovequizzes = Post::approve('no')->byLanguage()->byType('quiz')->count();

        $unapprovepolls = Post::approve('no')->byLanguage()->byType('poll')->count();

        $unapprovevideos = Post::approve('no')->byLanguage()->byType('video')->count();

        $waitapprove = Post::approve('no')->byLanguage()->take(15)->get();

        $cat = Tag::byType('mailcat')->where('name', 'inbox')->first();

        if ($cat) {
            $unapproveinbox = Contacts::where('category_id', $cat->id)->where('read', 0)->count();
        } else {
            $unapproveinbox = 0;
        }

        $this->product_api = app(AkProductApi::class);
        $updates = $this->product_api->getUpdates();

        $unapprove_comments = Comment::approved(false)->count();

        View::share(
            [
                'waitapprove' => $waitapprove,
                'total_approve' => $unapprovenews + $unapprovelists + $unapprovepolls + $unapprovevideos,
                'napprovenews' => $unapprovenews,
                'napprovelists' => $unapprovelists,
                'unapprovequizzes' => $unapprovequizzes,
                'napprovepolls' => $unapprovepolls,
                'napprovevideos' => $unapprovevideos,
                'unapproveinbox' => $unapproveinbox,
                'total_comment_approve' => $unapprove_comments,
                'updates' => $updates
            ]
        );
    }
}
