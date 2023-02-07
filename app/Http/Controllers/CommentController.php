<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    /**
     * @var \App\Repositories\CommentRepository
     */
    protected $commentRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $except = ['index', 'replies'];

        if (get_buzzy_config('COMMENTS_GUEST_COMMENT', false)) {
            $except = array_merge($except, ['store']);
        }
        if (get_buzzy_config('COMMENTS_GUEST_COMMENT_VOTING', false)) {
            $except = array_merge($except, ['vote']);
        }

        $this->middleware('auth', ['except' => $except]);
        $this->middleware('DemoAdmin', ['only' => ['update', 'destroy']]);

        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        if (!request()->ajax()) {
            return redirect()->route('home');
        }

        $data = [
            'post_id' => request()->get('post_id'),
            'user_id' => request()->get('user_id'),
            'sort' => request()->get('sort'),
        ];

        return $this->ajax($data);
    }

    /**
     * Init comment page
     *
     * @param array $args
     * @return void
     */
    public function init()
    {
        $args = [
            'post_id' => request()->get('post_id'),
            'user_id' => request()->get('user_id'),
            'sort' => request()->get('sort'),
        ];

        $popularComments = $this->commentRepository->getPopular($args);
        $comments = $this->commentRepository->get($args, $popularComments->pluck('id'));

        $json_data = [
            'requestData' => $args,
        ];

        $data =  compact(
            'popularComments',
            'comments',
            'json_data'
        );

        if ($args['user_id']) {
            return view('comments.user_comments', $data);
        }

        return view('comments.index', $data);
    }

    public function ajax($args)
    {
        $comments = $this->commentRepository->get($args);

        return response()->json(['status' => 'success', 'html' => view(
            'comments.pages._comments_list',
            compact(
                'comments'
            )
        )->render()]);
    }

    public function replies($id)
    {
        $comments = $this->commentRepository->getReplies($id);
        $moreExist = $comments->hasMorePages();
        $hideLinks = true;

        return response()->json(['status' => 'success', 'moreExist' => $moreExist, 'html' => view(
            'comments.pages._comments_list',
            compact(
                'comments',
                'hideLinks'
            )
        )->render()]);
    }

    public function vote(Request $request)
    {
        $this->validate(
            $request,
            [
                'comment_id' => 'required',
                'vote' => 'required',
            ]
        );

        $response = $this->commentRepository->vote(
            $request->only(
                [
                    'comment_id',
                    'vote',
                ]
            )
        );

        return $response->json();
    }

    /**
     * Store a comment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'comment' => 'required|between:1,1500',
            'post_id' => 'required|exists:posts,id',
            'user_email' => 'email',
        ];

        if (
            get_buzzy_config('BuzzyGuestCommentCaptcha') == 'on'
            && get_buzzy_config('reCaptchaKey') !== ''
            && !get_current_comment_user()->authenticated
        ) {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }

        $this->validate($request, $rules);

        $commentData = $request->only([
            'parent_id',
            'spoiler',
            'type',
            'post_id',
        ]);

        $commentData = array_merge($commentData, [
            'comment' => clean($request->input('comment')),
        ]);

        $user_username = clean($request->input('user_username'), 'titles');
        $user_email = clean($request->input('user_email'), 'titles');

        if ($user_username && $user_email) {
            $commentData = array_merge($commentData, ["data" => [
                'guest' => true,
                'ipno' => $request->ip(),
                'username' => $user_username,
                'email' => $user_email,
            ]]);
        }

        $response = $this->commentRepository->store($commentData);

        if ($response->failed()) {
            return $response->json();
        }

        return $response->json([
            'comment' => $response->data(),
            'html' => view(
                'comments.pages._comment',
                [
                    'comment' => $response->data()
                ]
            )->render()
        ]);
    }

    /**
     * Update a comment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'comment' => 'required|between:1,1500',
        ];

        $this->validate($request, $rules,  [
            'required' => __('You need to write something!'),
        ]);

        $commentData = $request->only([
            'comment',
            'spoiler',
        ]);

        $response = $this->commentRepository->update($id, $commentData);

        if ($response->failed()) {
            return $response->json();
        }

        $comment = $this->commentRepository->show($id);

        return $response->json([
            'comment' => $comment,
            'html' => parse_comment_text($comment->comment)
        ]);
    }

    /**
     * Destroy
     *
     * @param  int $id
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->commentRepository->destroy($id);

        return $response->json();
    }

    /**
     * Store Report
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id comment id
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'body' => 'max:500',
            ]
        );

        $response = $this->commentRepository->report($id, [
            'body' => $request->input('body'),
        ]);

        return $response->json();
    }
}
