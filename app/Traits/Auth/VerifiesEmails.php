<?php

namespace App\Traits\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Access\AuthorizationException;

trait VerifiesEmails
{
    use RedirectsUsers;

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        try {
            if (!hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
                throw new AuthorizationException;
            }

            if (!hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
                throw new AuthorizationException;
            }

            if ($request->user()->hasVerifiedEmail()) {
                return $request->wantsJson()
                    ? new Response('', 204)
                    : redirect($this->redirectPath());
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            if ($response = $this->verified($request)) {
                return $response;
            }

            return $request->wantsJson()
                ? new Response('', 204)
                : redirect($this->redirectPath())->with('success.message', __('Your email address has been verified.'));
        } catch (\Exception $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->with('error.message', $e->getMessage());
        }
    }

    /**
     * The user has been verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function verified(Request $request)
    {
        //
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect($this->redirectPath());
        }
        try {
            $request->user()->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            return back()->with('error.message', $e->getMessage());
        }

        return $request->wantsJson()
            ? new Response('', 202)
            : back()->with('success.message', __('A fresh verification link has been sent to your email address.'));
    }
}
