<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Traits\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        if ($request->ajax()) {
            return view('_particles.auth.login');
        }

        return view('auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->usertype === 'banned') {
            auth()->logout();
            return response()->json([
                'errors' => trans('v3.your_account_banned'),
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'url' => $this->redirectPath(),
            ]);
        }

        return redirect($this->redirectTo());
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $rules = [
            'user_email' => 'required|email',
            'user_password' => 'required|string',
        ];
        if (get_buzzy_config('BuzzyLoginCaptcha') == "on" && get_buzzy_config('reCaptchaKey') !== '') {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }

        $this->validate($request, $rules);
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        return request()->query('redirectTo') ?: Auth::user()->profile_link;
    }
}
