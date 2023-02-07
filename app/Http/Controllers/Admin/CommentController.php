<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Comment;
use App\CommentReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\CommentUpdated;
use Yajra\Datatables\Datatables;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Session;

class CommentController extends MainAdminController
{
    /**
     * @var \App\Repositories\CommentRepository
     */
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->middleware('DemoAdmin', ['only' => ['bulkAction']]);

        parent::__construct();

        $this->commentRepository = $commentRepository;
    }

    public function index(Request $request)
    {
        $data_url = action("Admin\\CommentController@getTableData", [
            'type' => $request->query('type'),
            'only' => $request->query('only'),
            'comment_id' => $request->query('comment_id'),
            'post_id' => $request->query('post_id'),
        ]);

        return view('_admin.pages.comments.index')->with(['data_url' => $data_url]);
    }

    public function getCommentReportsModal(Request $request)
    {
        $id = $request->get('id');

        if (!$id) {
            return response()->json([
                'html' => '',
            ]);
        }

        $reports = CommentReport::where('comment_id', $id)->get();

        return response()->json([
            'reports' => $reports,
            'html' => view('_admin.pages.comments.reports-modal', ['modal_id' => $id, 'reports' => $reports])->render(),
        ]);
    }

    public function bulkAction(Request $request)
    {
        $ids = explode(',', $request->get('ids'));
        $action = $request->get('action');

        try {
            foreach ($ids as $id) {
                if ($action == 'approve') {
                    $this->commentRepository->approve($id, 1);
                } elseif ($action == 'unapprove') {
                    $this->commentRepository->approve($id, 0);
                } elseif ($action == 'restore') {
                    $comment = Comment::withTrashed()->find($id);
                    if ($comment->deleted_at) {
                        $comment->restore();
                    }
                } elseif ($action == 'deleteReports') {
                    $comment = Comment::withTrashed()->find($id);
                    if ($comment) {
                        $comment->reports()->delete();
                    }
                } elseif ($action == 'delete') {
                    $this->commentRepository->destroy($id);
                } elseif ($action == 'forceDelete') {
                    $this->commentRepository->destroy($id, true);
                }
            }
        } catch (\Exception $e) {
            //
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

        $comment = Comment::with('user')->withCount('reports');

        if ($type === 'comment') {
            $comment->where('comment_id', $request->query('comment_id'));
        }

        if ($type === 'post') {
            $comment->where('post_id', $request->query('post_id'));
        }

        if ($only == 'reported') {
            $comment->has('reports');
        }

        if ($only == 'deleted') {
            $comment->onlyTrashed();
        } else {
            $comment->whereNull('deleted_at');
        }

        if ($only == 'unapprove') {
            $comment->approved(false);
        } else {
            $comment->approved(true);
        }

        return Datatables::of($comment)
            ->addColumn('selection', function ($comment) {
                return '<input type="checkbox" name="selection[]" value="' . $comment->id . '">';
            })
            ->editColumn('comment', function ($comment) {
                $output = '';
                if (Str::length($comment->comment) > 100) {
                    $output = '<div class="comment-content expand_comment">';
                    $output .= '<div class="comment-body-short">';
                    $output .= Str::limit($comment->comment, 100);
                    $output .= '</div>';
                    $output .= '<div class="comment-body-full">';
                    $output .= parse_comment_text($comment->comment);
                    $output .= '</div>';
                    $output .= '</div>';
                } else {
                    $output .= parse_comment_text($comment->comment);
                }

                return $output;
            })
            ->editColumn('post', function ($comment) {
                if (!$comment->post) {
                    return "-";
                }

                return '<a href="' . generate_comment_url($comment) . '" target="_blank">
                        ' . $comment->post->title . '
                        </a>
                        <div class="product-meta"></div>
                    ';
            })
            ->editColumn('user', function ($comment) {
                if (!$comment->userdata) {
                    return "-";
                }

                if ($comment->userdata->type == 'guest') {
                    $email = isset($comment->data['email']) ? $comment->data['email'] : '-';
                    return $comment->userdata->username . ' (' . $email . ')';
                }

                return '<a href="' . $comment->userdata->link . '" target="_blank"><img src="' . $comment->userdata->icon . '" width="32" class="mr-10">' . $comment->userdata->username . '</a>';
            })
            ->addColumn('approve', function ($comment) {
                if ($comment->deleted_at !== null) {
                    $result = '<div class="label label-danger">' . trans("admin.OnTrash") . '</div>';
                } elseif (!$comment->approve) {
                    $result = '<div class="label label-info">' . trans("admin.AwaitingApproval") . '</div>';
                } elseif ($comment->approve) {
                    $result = '<div class="label label-info">' . trans("admin.Active") . '</div>';
                }

                if ($comment->reports_count > 0) {
                    $result .= '<div class="label label-warning ml-5">' . __('Reported') . '</div>';
                }

                if ($comment->userdata->type == 'guest') {
                    $result .= '<div class="label label-success ml-5">' . __('Guest') . '</div>';
                }

                if ($comment->parent_id) {
                    $result .= '<div class="label label-default ml-5">' . __('Reply') . '</div>';
                }

                return $result;
            })
            ->editColumn('created_at', function ($comment) {
                if ($comment->created_at) {
                    return $comment->created_at->format('Y-m-d H:i:s');
                }
                return "-";
            })
            ->addColumn('action', function ($comment) {
                $result = '<div class="input-group-btn">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . trans("admin.actions") . ' <span class="fa fa-caret-down"></span></button>
                                  <ul class="dropdown-menu pull-left">';

                if ($comment->reports_count > 0) {
                    $result = $result . '<li><a href="javascript:void(0);" class="get_comment_reports" data-url="' . action("Admin\CommentController@getCommentReportsModal", ['id' => $comment->id]) . '"><i class="fa fa-flag"></i>  ' . __("View Reports") . '</a></li>';
                    $result = $result . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\CommentController@bulkAction", ['ids' => $comment->id, 'action' => 'deleteReports']) . '"><i class="fa fa-flag"></i>  ' . __("Delete Reports") . '</a></li>';
                    $result = $result .  '<li class="divider"></li>';
                }

                if ($comment->deleted_at == null) {
                    if (!$comment->approve) {
                        $result = $result . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\CommentController@bulkAction", ['ids' => $comment->id, 'action' => 'approve']) . '"><i class="fa fa-check"></i>  ' . trans("admin.Approve") . '</a></li>';
                    } elseif ($comment->approve) {
                        $result = $result . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\CommentController@bulkAction", ['ids' => $comment->id, 'action' => 'unapprove']) . '"><i class="fa fa-remove"></i> ' . trans("admin.UndoApprove") . '</a></li>';
                    }

                    $result = $result .  '<li class="divider"></li>';

                    $result = $result .  '<li><a target="_blank" href="' . generate_comment_url($comment) . '"><i class="fa fa-edit"></i> ' . __('Edit Comment') . '</a></li>';

                    $result = $result .  '<li class="divider"></li>';
                }

                if ($comment->deleted_at == null) {
                    $result = $result . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\CommentController@bulkAction", ['ids' => $comment->id, 'action' => 'delete']) . '"><i class="fa fa-trash"></i> ' . trans("admin.SendtoTrash") . '</a></li>';
                } else {
                    $result = $result . '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\CommentController@bulkAction", ['ids' => $comment->id, 'action' => 'restore']) . '"><i class="fa fa-trash"></i> ' . trans("admin.RetrievefromTrash") . '</a></li>';
                }

                $result = $result .  '<li><a href="javascript:void(0);" class="do_table_action" data-url="' . action("Admin\CommentController@bulkAction", ['ids' => $comment->id, 'action' => 'forceDelete']) . '"><i class="fa fa-remove"></i> ' . trans("admin.Deletepermanently") . '</a></li>';

                $result = $result .  '</ul>
                            </div>';

                return $result;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
