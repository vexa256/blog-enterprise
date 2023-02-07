<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use Carbon\Carbon;
use App\Events\PostUpdated;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;

class PostsController extends MainAdminController
{
    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['bulkAction']]);

        parent::__construct();
    }

    public function index(Request $request)
    {
        $data_url = action("Admin\\PostsController@getTableData", [
            'type' => $request->query('type'),
            'only' => $request->query('only'),
            'category_id' => $request->query('category_id'),
        ]);

        $title = trans("admin.Posts");

        if ($request->query('type') == 'category') {
            $category = Category::find($request->query('category_id'));
            if ($category) {
                $title = $category->name;
            }
        }

        return view('_admin.pages.posts')->with(['title' => $title, 'desc' => '', 'type' => 'all', 'data_url' => $data_url]);
    }

    public function bulkAction(Request $request)
    {
        $ids = explode(',', $request->get('ids'));
        $action = $request->get('action');

        try {
            foreach ($ids as $id) {
                $post = Post::withTrashed()->find($id);

                if (!$post) {
                    continue;
                }

                if ($action == 'approve') {
                    $post->approve = 'yes';
                    $post->save();

                    event(new PostUpdated($post, 'Approved'));
                } elseif ($action == 'unApprove') {
                    $post->approve = 'no';
                    $post->save();
                } elseif ($action == 'restore') {
                    $comment = Post::withTrashed()->find($id);
                    if ($comment->deleted_at) {
                        $comment->restore();
                    }
                } elseif ($action == 'setFeatured') {
                    $post->featured_at = now();
                    $post->save();
                } elseif ($action == 'unsetFeatured') {
                    $post->featured_at = null;
                    $post->save();
                } elseif ($action == 'setForHomepage') {
                    $post->show_in_homepage = 'yes';
                    $post->save();
                } elseif ($action == 'unsetForHomepage') {
                    $post->show_in_homepage = null;
                    $post->save();
                } elseif ($action == 'delete') {
                    event(new PostUpdated($post, 'Trash'));
                    $post->delete();
                } elseif ($action == 'forceDelete') {
                    if (!$post->deleted_at) {
                        event(new PostUpdated($post, 'Trash'));
                    }
                    $post->forceDelete();
                }
            }
        } catch (\Exception $e) {
        }

        if ($request->wantsJson()) {
            return new Response('', 204);
        }

        Session::flash('success.message', '');

        return redirect()->back();
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableData(Request $request)
    {
        $type = $request->query('type');
        $only = $request->query('only');

        $post = Post::with('user')->withCount(['comments' => function ($query) {
            $query->approved();
        }])->byLanguage();

        if ($type === 'category') {
            $category_id = $request->query('category_id');
            $post->byCategories(get_category_ids_recursively($category_id));
        } elseif ($type) {
            $post->where('type', $type);
        }

        if ($only == 'featured') {
            $post->whereNotNull("featured_at");
        }

        if ($only == 'deleted') {
            $post->onlyTrashed();
        } else {
            $post->whereNull('deleted_at');
        }

        if ($only == 'unapprove') {
            $post->approve('no');
        } else {
            $post->byApproved();
        }

        return Datatables::of($post)
            ->addColumn('selection', function ($post) {
                return '<input type="checkbox" name="selection[]" value="' . $post->id . '">';
            })
            ->editColumn('thumb', function ($post) {
                return '<img src="' . makepreview($post->thumb, 's', 'posts') . '" width="125">';
            })
            ->editColumn('title', function ($post) {
                $categories = $post->categories()->get()->implode('name', ', ');

                $comments = get_buzzy_config('p_buzzycomment') == 'on' ? '<a href="' . route('admin.comments',  ['type' => 'post', 'post_id' => $post->id]) . '">' . __(':count Comments', ['count' => $post->comments_count]) . '</a>' : '';

                return '<a href="' . $post->post_link . '" target=_blank>
                        ' . $post->title . '
                        </a>
                        <p class="text-gray mt-5">' . Str::limit($post->body, 45) . '</p>
                        <div class="post-meta">' . $categories . ' - ' . $comments . '</div>
                    ';
            })
            ->editColumn('user', function ($post) {
                return $post->user ? '<div><a href="' . $post->user->profile_link . '" target="_blank"><img src="' . makepreview($post->user->icon, 's', 'members/avatar') . '" width="32" class="mr-5">' . $post->user->username . '</a></div>' : '';
            })
            ->editColumn('approve', function ($post) {
                $result = '';
                if ($post->deleted_at !== null) {
                    $result = '<div class="label label-danger">' . trans("admin.OnTrash") . '</div>';
                } elseif ($post->approve == 'draft') {
                    $result = '<div class="label label-info">' . trans("admin.DraftPost") . '</div>';
                } elseif ($post->approve == 'no') {
                    $result = '<div class="label label-info">' . trans("admin.AwaitingApproval") . '</div>';
                } elseif ($post->featured_at !== null) {
                    $result =  '<div class="clear"></div><div class="label label-featured">' . trans("admin.FeaturedPost") . '</div>';
                } elseif ($post->approve == 'yes') {
                    $result = '<div class="label label-info">' . trans("admin.Active") . '</div>';
                }

                if ($post->show_in_homepage == 'yes') {
                    $result .= '<div class="clear"></div><div class="label label-success">' . trans("admin.Pickedforhomepage") . '</div>';
                }

                if ($post->published_at->getTimestamp() > Carbon::now()->getTimestamp()) {
                    $result .= '<div class="label bg-gray ml-5">' . trans('v3.scheduled_date', ['date' => $post->published_at->format('j M Y, h:i A')])  . '</div>';
                }

                return $result;
            })
            ->editColumn('language', function ($post) {
                if ($post->language) {
                    return get_language_list($post->language);
                }
                return "-";
            })
            ->editColumn('published_at', function ($post) {
                if ($post->published_at) {
                    return $post->published_at->format('Y-m-d H:i:s');
                }
                return "-";
            })
            ->editColumn('featured_at', function ($post) {
                if ($post->featured_at) {
                    return $post->featured_at->format('Y-m-d H:i:s');
                }
                return "-";
            })
            ->addColumn('action', function ($post) {
                $edion = '<div class="input-group-btn">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . trans("admin.actions") . ' <span class="fa fa-caret-down"></span></button>
                                  <ul class="dropdown-menu pull-left">';
                if ($post->deleted_at == null) {
                    if ($post->approve == 'no') {
                        $edion = $edion . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'approve']) . '"><i class="fa fa-check"></i>  ' . trans("admin.Approve") . '</a></li>';
                    } elseif ($post->approve == 'yes') {
                        $edion = $edion . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'unApprove']) . '"><i class="fa fa-remove"></i> ' . trans("admin.UndoApprove") . '</a></li>';
                    }
                    if ($post->approve == 'yes') {
                        if ($post->featured_at == null) {
                            $edion = $edion .  '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'setFeatured']) . '"><i class="fa fa-star"></i> ' . trans("admin.PickforFeatured") . '</a></li>';
                        } else {
                            $edion = $edion .  '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'unsetFeatured']) . '"><i class="fa fa-remove"></i> ' . trans("admin.UndoFeatured") . '</a></li>';
                        }

                        if ($post->show_in_homepage == null) {
                            $edion = $edion .  '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'setForHomepage']) . '"><i class="fa fa-dashboard"></i> ' . trans("admin.PickforHomepage") . '</a></li>';
                        } elseif ($post->show_in_homepage == 'yes') {
                            $edion = $edion .  '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'unsetForHomepage']) . '"><i class="fa fa-remove"></i>   ' . trans("admin.UndofromHomepage") . '</a></li>';
                        }
                    }

                    $edion = $edion .  '<li class="divider"></li>';

                    $edion = $edion .  '<li><a target="_blank" href="' . route('post.edit', ['post_id' => $post->id]) . '"><i class="fa fa-edit"></i> ' . trans("admin.EditPost") . '</a></li>';

                    $edion = $edion .  '<li class="divider"></li>';
                }

                if ($post->deleted_at == null) {
                    $edion = $edion . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'delete']) . '"><i class="fa fa-trash"></i> ' . trans("admin.SendtoTrash") . '</a></li>';
                } else {
                    $edion = $edion . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'restore']) . '"><i class="fa fa-trash"></i> ' . trans("admin.RetrievefromTrash") . '</a></li>';
                }

                $edion = $edion .  '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\PostsController@bulkAction", ['ids' => $post->id, 'action' => 'forceDelete']) . '"><i class="fa fa-remove"></i> ' . trans("admin.Deletepermanently") . '</a></li>';

                $edion = $edion .  '</ul>
                            </div>';

                return $edion;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
