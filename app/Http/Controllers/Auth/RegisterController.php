<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\Auth\RedirectsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        if (get_buzzy_config('DisableRegister') === 'yes') {
            if (request()->ajax()) {
                return new Response('', 403);
            }

            return redirect()->route('home');
        }

        if ($request->ajax()) {
            return view('_particles.auth.register');
        }

        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->all();

        $this->validator($data)->validate();

        try {
            event(new Registered($user = $this->create($data)));
        } catch (\Exception $e) {
            //
        }

        Auth::guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 201)
            : redirect($this->redirectPath());
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'user_username' => 'required|string|max:35|min:3|unique:users,username',
            'user_email' => 'required|string|email|max:255|unique:users,email',
            'user_password' => 'required|string|min:6'
        ];

        if (get_buzzy_config('BuzzyRegisterCaptcha') == "on" && get_buzzy_config('reCaptchaKey') !== '') {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $slug = sanitize_title_with_dashes($data['user_username']);

        if (empty($slug)) {
            $slug = Str::slug($data['user_username']);
        }

        if (empty($slug)) {
            $slug = substr(md5(time()), 0, 10);
        }

        return User::create([
            'username' => $data['user_username'],
            'username_slug' => $slug,
            'email' => $data['user_email'],
            'password' => bcrypt($data['user_password']),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'title' => trans('auth.congratz'),
                'text' => trans('auth.joined'),
                'url' => $this->redirectTo(),
            ]);
        }

        return redirect($this->redirectTo());
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        return request()->query('redirectTo') ?: auth()->user()->profile_link;
    }
}
