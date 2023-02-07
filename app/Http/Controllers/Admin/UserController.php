<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends MainAdminController
{
    public function __construct(Request $request)
    {
        if (
            $request->query('userlock')
            || $request->query('userunlock')
            || $request->query('useradmin')
            || $request->query('userunadmin')
            || $request->query('staff')
            || $request->query('unstaff')
            || $request->query('permadelete')
        ) {
            $this->middleware('DemoAdmin', ['only' => ['users']]);
        }

        parent::__construct();
    }

    public function users(Request $request)
    {
        if ($request->query('userlock')) {
            $user = User::findOrFail($request->query('userlock'));
            $user->usertype = 'banned';
            $user->save();
            Session::flash('success.message', trans("admin.Banned"));
            return redirect()->back();
        } elseif ($request->query('userunlock')) {
            $user = User::findOrFail($request->query('userunlock'));
            $user->usertype = null;
            $user->save();
            Session::flash('success.message', trans("admin.Unlocked"));
            return redirect()->back();
        } elseif ($request->query('useradmin')) {
            $user = User::findOrFail($request->query('useradmin'));
            $user->usertype = 'Admin';
            $user->save();
            Session::flash('success.message', trans("admin.ChangesSaved"));
            return redirect()->back();
        } elseif ($request->query('userunadmin')) {
            $user = User::findOrFail($request->query('userunadmin'));
            $user->usertype = null;
            $user->save();
            Session::flash('success.message', trans("admin.Nowuserisnotadmin"));
            return redirect()->back();
        } elseif ($request->query('staff')) {
            $user = User::findOrFail($request->query('staff'));
            $user->usertype = 'Staff';
            $user->save();
            Session::flash('success.message', trans("admin.ChangesSaved"));
            return redirect()->back();
        } elseif ($request->query('unstaff')) {
            $user = User::findOrFail($request->query('unstaff'));
            $user->usertype = null;
            $user->save();
            Session::flash('success.message', trans("admin.ChangesSaved"));
            return redirect()->back();
        } elseif ($request->query('permadelete')) {
            $user = User::findOrFail($request->query('permadelete'));
            $user->userDelete();
            Session::flash('success.message', trans("admin.Deleted"));
            return redirect()->back();
        }

        $typew = $request->query('only');

        return view('_admin.pages.users')->with(['type' => $typew]);
    }


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableData(Request $request)
    {
        $type = $request->query('only');

        $user = DB::table('users');
        $user->select('*');

        if ($type == 'admins') {
            $user->where('usertype', '=', 'Admin');
        } elseif ($type == 'staff') {
            $user->where('usertype', '=', 'Staff');
        } elseif ($type == 'banned') {
            $user->where('usertype', '=', 'banned');
        }

        return Datatables::of($user)
            ->editColumn('icon', function ($user) {
                return '<img src=" ' . makepreview($user->icon, 's', 'members/avatar') . '" width="55" height="55">';
            })
            ->editColumn('username', function ($user) {
                $out = '<a href="' . route('user.profile', ['user' => $user->username_slug]) . '"  target="_blank" > ' . $user->username . '  </a><div class=clear></div>';

                $social_profiles = json_decode($user->social_profiles, true);
                $social_links = collect(config('buzzy.social_links'))->filter(function ($item, $provider) use ($social_profiles) {
                    return !empty($social_profiles[$provider]);
                });

                foreach ($social_links as $provider => $item) {
                    $out .= '<a href="' . $social_profiles[$provider] . '" target="_blank" class="mr-5 mt-5"><img width="26px" src="' . $item['icon'] . '" /></a>';
                }

                return $out;
            })
            ->editColumn('email', function ($user) {
                if (auth()->user()->isDemoAdmin()) {
                    return trans("admin.youPERMISSION");
                }

                $output = $user->email;

                if ($user->email_verified_at) {
                    $output .= '<i data-toggle="tooltip" data-original-title="' . __('Verified') . '" class="fa fa-check-circle ml-5 text-green"></i>';
                } else {
                    $output .= '<i data-toggle="tooltip" data-original-title="' . __('Not verified') . '" class="fa fa-times-circle ml-5 text-gray"></i>';
                }

                return $output;
            })
            ->addColumn('status', function ($user) {
                if ($user->usertype == 'Admin') {
                    return '<div class="label label-default">' . trans("admin.admin") . '</div>';
                } elseif ($user->usertype == 'Staff') {
                    return '<div class="label label-warning">' . trans("admin.StaffEditor") . '</div>';
                } elseif ($user->usertype == 'banned') {
                    return '<div class="label label-danger">' . trans("admin.Banned") . '</div>';
                } else {
                    return '<div class="label label-info">' . trans("admin.Member") . '</div>';
                }
            })
            ->addColumn('action', function ($user) {
                $adminbutton = "";
                $staffbutton = "";
                $editbutton =   '  <a href="' . route('user.settings', ['user' => $user->username_slug]) . '"  target="_blank" class="btn btn-sm btn-success" role="button" data-toggle="tooltip" data-original-title="' . trans("admin.edit") . '"><i class="fa fa-edit"></i></a>';
                $deletebutton =  ' <a class="btn btn-sm btn-danger permanently" href="?permadelete=' . $user->id . '" role="button" data-toggle="tooltip" data-original-title="' . trans("admin.deletepermanently") . '"><i class="fa fa-trash"></i></a>';

                if ($user->usertype == 'banned') {
                    $lockbutton =      ' <a class="btn btn-sm btn-default permanently" href="?userunlock=' . $user->id . '" role="button" data-toggle="tooltip" data-original-title="' . trans("admin.UnlockUser") . '"><i class="fa fa-unlock"></i></a>';
                    $adminbutton =  $lockbutton . $deletebutton;
                } else {
                    $lockbutton =      ' <a class="btn btn-sm btn-danger permanently" href="?userlock=' . $user->id . '" role="button" data-toggle="tooltip" data-original-title="' . trans("admin.lockUser") . '"><i class="fa fa-lock"></i></a>';

                    if ($user->usertype == 'Admin') {
                        $adminbutton =     ' <a class="btn btn-sm btn-default " href="?userunadmin=' . $user->id . '" role="button" data-toggle="tooltip" data-original-title="' . trans("admin.NotAdmin") . '"><i class="fa fa-remove"></i></a>';
                    } else {
                        $adminbutton =  $lockbutton .   ' <a class="btn btn-sm btn-info " href="?useradmin=' . $user->id . '" role="button" data-toggle="tooltip" data-original-title="' . trans("admin.MakeAdmin") . '"><i class="fa fa-user-secret"></i></a>';

                        if ($user->usertype == 'Staff') {
                            $staffbutton =  ' <a class="btn btn-sm btn-default " href="?unstaff=' . $user->id . '" role="button" data-toggle="tooltip" data-original-title="' . trans("admin.NotEditorStaff") . '"><i class="fa fa-remove"></i></a>';
                        } else {
                            $staffbutton =  ' <a class="btn btn-sm btn-warning" href="?staff=' . $user->id . '" role="button" data-toggle="tooltip" data-original-title="' . trans("admin.MakeEditorStaff") . '"><i class="fa fa-thumbs-up"></i></a>';
                        }

                        $staffbutton .=  $deletebutton;
                    }
                }

                return $editbutton . $adminbutton . $staffbutton;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
