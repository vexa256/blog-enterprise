<?php

namespace App\Http\Controllers;

use App\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Show Page
     *
     * @param  Page $page
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function __invoke(Page $page)
    {
        return view("pages.page", compact("page"));
    }
}
