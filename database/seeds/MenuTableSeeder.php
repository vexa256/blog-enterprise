<?php

namespace Database\Seeders;

use App\Menu;
use App\Page;
use App\MenuItem;
use App\Category;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $main_menu = Menu::firstOrCreate([
            'name' => 'Main Menu',
            'slug' => 'main-menu',
            'location' => 'main-menu',
        ]);
        $mobile_menu = Menu::firstOrCreate([
            'name' => 'Mobile Menu',
            'slug' => 'mobile-menu',
            'location' => 'mobile-menu',
        ]);

        $mega_menu = Menu::firstOrCreate([
            'name' => 'Mega Menu',
            'slug' => 'mega-menu',
            'location' => 'mega-menu',
        ]);

        $footer_menu = Menu::firstOrCreate([
            'name' => 'Footer Menu',
            'slug' => 'footer-menu',
            'location' => 'footer-menu',
        ]);

        //main menu
        $cats = Category::whereNull("parent_id")->byActive()->byOrder()->limit(9)->get();
        foreach ($cats as $cat) {
            $this->addMenu([
                'menu_id' => $main_menu->id,
                'title' => $cat->name,
                'order' => $cat->order,
                'url' => '/' . $cat->name_slug,
                'icon' => $this->getMenuIcon($cat->type),
            ]);
            $this->addMenu([
                'menu_id' => $mobile_menu->id,
                'title' => $cat->name,
                'order' => $cat->order,
                'url' => '/' . $cat->name_slug,
                'icon' => $this->getMenuIcon($cat->type),
            ]);
        }

        // mega menu
        $subcats = Category::whereNotNull('parent_id')->byActive()->orderBy('name')->get();
        foreach ($subcats as $cat) {
            $this->addMenu([
                'menu_id' => $mega_menu->id,
                'title' => $cat->name,
                'order' => $cat->order,
                'url' => '/' . $cat->name_slug,
            ]);
        }

        // footer menu
        $pages = Page::where('footer', '1')->get();
        foreach ($pages as $order => $page) {
            $this->addMenu([
                'menu_id' => $footer_menu->id,
                'title' => $page->title,
                'order' => $order,
                'url' => '/pages/' . $page->slug,
            ]);
        }
    }

    private function addMenu($menu)
    {
        MenuItem::firstOrCreate($menu);
    }

    private function getMenuIcon($type)
    {
        if ($type == 'news') {
            return 'library_books';
        }
        if ($type == 'list') {
            return 'collections';
        }
        if ($type == 'quiz') {
            return 'quiz';
        }
        if ($type == 'poll') {
            return 'library_add_check';
        }
        if ($type == 'video') {
            return 'video_library';
        }
    }
}
