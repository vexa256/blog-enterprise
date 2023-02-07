<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DemoAdmin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('APP_DEMO') && Auth::check() && Auth::user()->isDemoAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'errors' => trans('index.nopermission')], 401);
            }

            Session::flash('error.message', trans('index.nopermission'));
            return redirect()->back();
        }

        return $next($request);
    }
}
