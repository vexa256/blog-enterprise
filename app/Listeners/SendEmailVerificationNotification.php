<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        try {
            if (get_buzzy_config('UserVerifyEmail') == 'yes') {
                if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
                    $event->user->sendEmailVerificationNotification();
                }
            }
        } catch (\Exception $e) {
            //
        }
    }
}
