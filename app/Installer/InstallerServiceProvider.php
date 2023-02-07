<?php

namespace App\Installer;

use App\Installer\Installer;
use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->runningInConsole()) {
            $this->registerIfNotInstalled();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    private function registerIfNotInstalled()
    {
        $installed = file_exists(storage_path('installed'));
        $version = $installed ? @file_get_contents(storage_path('installed')) : false;
        $update = $version && version_compare(trim($version), config('buzzy.version'), '<');

        if (!$installed || $update) {
            if (
                $this->app['request']->is('/')
                || $this->app['request']->is('admin')
                || $this->app['request']->is('admin/*')
            ) {
                if ($update && $installed) {
                    return $this->redirectTo(url('installer/update'));
                }

                return $this->redirectTo(url('installer/welcome'));
            }
        }
    }

    /**
     * Redirect to url.
     *
     * @return void
     */
    private function redirectTo($url)
    {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit();
    }
}
