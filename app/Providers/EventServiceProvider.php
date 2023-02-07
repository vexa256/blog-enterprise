<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            'App\Listeners\SendEmailVerificationNotification',
        ],
        'App\Events\MessageReceived' => [
            'App\Listeners\NewMessageListener',
        ],
        'App\Events\PostUpdated' => [
            'App\Listeners\PostUpdatedListener',
        ],
        'App\Events\CommentUpdated' => [
            'App\Listeners\CommentUpdatedListener',
        ],
        'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'SocialiteProviders\VKontakte\VKontakteExtendSocialite@handle'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
