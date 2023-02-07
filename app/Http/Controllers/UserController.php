<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Followers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Managers\UploadManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['updatesettings']]);
    }

    public function index(User $user)
    {
        $lastPost = $user->posts()->with('user')->byLanguage();

        if (!Auth::check() || Auth::user()->id !== $user->id) {
            $lastPost = $lastPost->byPublished()->byApproved();
        }

        $lastPost = $lastPost->latest('published_at')->paginate(15);

        return view("pages.user.dashboard", compact('user', 'lastPost'));
    }

    public function draftposts(User $user)
    {
        $this->authorize('view', $user);

        $lastPost = $user->posts()->with('user')->byLanguage()->approve('draft')->latest('published_at')->paginate(15);

        $patitle = trans('index.draft');

        return view("pages.user.otherposts", compact('user', 'lastPost', 'patitle'));
    }

    public function deletedposts(User $user)
    {
        $this->authorize('view', $user);

        $lastPost = $user->posts()->with('user')->byLanguage()->onlyTrashed()->latest('published_at')->paginate(15);

        $patitle = trans('index.trash');

        return view("pages.user.otherposts", compact('user', 'lastPost', 'patitle'));
    }

    public function follow(User $user)
    {
        $this->authorize('follow', $user);

        $follow = Followers::where("followed_id", $user->id)->where("user_id", Auth::user()->id)->first();
        if ($follow) {
            $follow->delete();
        } else {
            $follow = new Followers;
            $follow->user_id = Auth::user()->id;
            $follow->followed_id = $user->id;
            $follow->save();
        }

        return view('_particles.user.follow_button', compact('user'));
    }


    public function following(User $user)
    {
        $follows = $user->following()->paginate(36);

        return view("pages.user.following", compact('user', 'follows'));
    }

    public function followers(User $user)
    {
        $follows = $user->followers()->paginate(36);

        return view("pages.user.followers", compact('user', 'follows'));
    }

    public function followfeed(User $user)
    {
        $this->authorize('update', $user);

        $userIds = $user->following()->pluck('followed_id');

        $lastPost = Post::whereIn('user_id', $userIds)->byPublished()->byLanguage()->byApproved()->paginate(10);

        return view("pages.user.feed", compact('user', 'lastPost'));
    }

    public function settings(User $user)
    {
        $this->authorize('update', $user);

        return view("pages.user.settings", compact('user'));
    }

    public function updatesettings(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $inputs = $request->all();

        $val = $this->validator($request, $user->id);

        if ($val->fails()) {
            Session::flash('error.message',  $val->errors()->first());

            return redirect()->back()->withInput($inputs);
        }

        $username = isset($inputs['username']) ? $inputs['username'] : Auth::user()->username;
        $email = isset($inputs['email']) ? $inputs['email'] : Auth::user()->email;
        $password = $inputs['password'];

        if ($request->hasFile('icon')) {
            try {
                $image = new UploadManager();
                $image->path('upload/media/members/avatar');
                $image->file($request, 'icon');
                $image->name(sanitize_title_with_dashes($username) . '-' . time());
                $image->make();
                $image->mime('jpg');
                $image->save([
                    'fit_width' => 200,
                    'fit_height' => 200,
                    'image_size' => 'b',
                ]);
                $image->save([
                    'fit_width' => 90,
                    'fit_height' => 90,
                    'image_size' => 's',
                ]);

                // delete previous image
                $image->delete(makepreview($user->icon, 'b', 'members/avatar'));
                $image->delete(makepreview($user->icon, 's', 'members/avatar'));

                $user->icon = $image->getPathforSave();
            } catch (\Exception $e) {
                Session::flash('error.message',  $e->getMessage());

                return redirect()->back()->withInput($inputs);
            }
        }

        if ($request->hasFile('splash')) {
            try {
                $image = new UploadManager();
                $image->file($request, 'splash');
                $image->path('upload/media/members/splash');
                $image->name(sanitize_title_with_dashes($username) . '-' . time());
                $image->make();
                $image->mime('jpg');
                $image->save([
                    'fit_width' => 910,
                    'fit_height' => 250,
                    'image_size' => 'b',
                ]);
                $image->save([
                    'fit_width' => 300,
                    'fit_height' => 120,
                    'image_size' => 's',
                ]);

                // delete previous image
                $image->delete(makepreview($user->splash, 'b', 'members/splash'));
                $image->delete(makepreview($user->splash, 's', 'members/splash'));

                $user->splash = $image->getPathforSave();
            } catch (\Exception $e) {
                Session::flash('error.message',  $e->getMessage());

                return redirect()->back()->withInput($inputs);
            }
        }

        if (get_buzzy_config('UserEditUsername') == 'true' or Auth::user()->usertype == 'Admin') {
            if ($username) {
                $user->username = $username;
                $slug = sanitize_title_with_dashes($username);
                if (empty($slug)) {
                    $slug = Str::slug($slug);
                }

                if (empty($slug)) {
                    $slug = substr(md5(time()), 0, 10);
                }

                $user->username_slug = $slug;
            }
        }

        if (get_buzzy_config('UserEditEmail') == 'true' or Auth::user()->usertype == 'Admin') {
            if ($email) {
                $user->email = $email;
            }
        }

        if ($password) {
            $user->password =  bcrypt($password);
        }

        if (isset($inputs['social_profiles'])) {
            $user->social_profiles = (array) $inputs['social_profiles'];
        }

        // if email is new set unverified
        if ($email != Auth::user()->email) {
            $user->email_verified_at = null;
        }

        $user->name = $inputs['name'];
        $user->town = $inputs['town'];
        $user->genre = $inputs['gender'];
        $user->about = $inputs['about'];

        $user->save();

        Session::flash('success.message',  trans('index.successupdated'));

        return redirect()->route('user.settings', ['user' => $user->username_slug]);
    }

    /**
     * Validator update.
     */
    public function validator($request, $userid)
    {
        $rules = [
            'username' => 'string|max:35|min:3|unique:users,username,' . $userid,
            'email' => 'email|max:75|unique:users,email,' . $userid,
            'icon' => 'nullable|mimes:jpg,jpeg,gif,png',
            'name' => 'string|nullable|max:20|min:3',
            'town' => 'string|nullable|max:20|min:3',
            'gender' => 'string|nullable|max:20|min:3',
            'about' => 'string|nullable|max:500|min:3',
        ];

        if ($request->input('password')) {
            $rules = array_merge($rules, [
                'password' => 'min:6|max:15',
            ]);
        }

        return Validator::make($request->all(), $rules);
    }
}
