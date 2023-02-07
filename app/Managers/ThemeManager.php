<?php

namespace App\Managers;

use Illuminate\Support\Arr;

/**
 * Class Theme
 * @package YAAP\Theme
 */
class ThemeManager
{
    /**
     * theme config
     *
     */
    protected $config;

    /**
     * parent themes
     *
     */
    protected $parents;

    /**
     *  cache for paths
     */
    protected $cache;

    /**
     *  current theme
     */
    protected $theme;


    /**
     *
     * Initialize a theme by name
     * @param $theme
     * @throws Exception
     */
    public function init($theme)
    {
        if (empty($theme)) throw new \Exception('Theme name should not be empty');

        $this->theme = $theme;

        // read theme path
        $path = app('config')->get('theme.path', base_path('themes'));

        //init config
        $this->config = $this->readConfig($path . '/' . $theme . '/config.php');

        // theme parents
        $this->parents = array();

        while (!empty($theme)) {
            if (!is_dir($path . '/' . $theme)) throw new \Exception('Theme ' . $theme . ' not found.');

            // add theme's root folder
            app('view')->getFinder()->addLocation($path . '/' . $theme);

            // add folder with views
            app('view')->getFinder()->addLocation($path . '/' . $theme . '/' . config('theme.containerDir.view'));

            // read theme config
            $current_theme_config = $this->readConfig($path . '/' . $theme . '/config.php');

            $theme = Arr::get($current_theme_config, 'inherit');

            if (!empty($theme)) {
                $this->parents[] = $theme;
            }
        }

        app('translator')->getLoader()->addNamespace($this->theme, $path . '/' . $this->theme . '/' . 'lang');
    }

    /**
     * Returns the list of available themes names in an array.
     *
     * @return array
     */
    public function getList()
    {
        // read theme path
        $path = $this->app['config']->get('theme.path', base_path('themes'));

        if (file_exists($path)) {
            $dir_list = dir($path);
            while (false !== ($entry = $dir_list->read())) {
                if (file_exists($path . '/' . $entry . '/' . 'config.php'))
                    $list[] = $entry;
            }
        }

        return $list;
    }

    /**
     * @param $path
     * @return array|mixed
     */
    private function readConfig($path)
    {
        if (file_exists($path))
            return include($path);

        return array();
    }
}
