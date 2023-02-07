<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Handlers\FeedFetcher\FeedPostsFetcher;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\FindTranslations::class,
        \App\Console\Commands\TranslateFilesCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(new FeedPostsFetcher('hourly'))->hourly();
        $schedule->call(new FeedPostsFetcher('daily'))->daily();
        $schedule->call(new FeedPostsFetcher('weekly'))->weekly();
        $schedule->call(new FeedPostsFetcher('monthly'))->monthly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
