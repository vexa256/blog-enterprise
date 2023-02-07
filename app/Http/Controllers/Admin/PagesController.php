<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PagesController extends MainAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('DemoAdmin', ['only' => ['delete', 'addnew']]);
    }

    public function index()
    {
        $pages = Page::all();

        $page = null;
        if ($page_id = request()->query('edit')) {
            $page = Page::findOrFail($page_id);
        }

        return view('_admin.pages.pages', compact('pages', 'page'));
    }

    public function delete(Page $page)
    {
        $page->delete();

        Session::flash('success.message', trans("admin.Deleted"));
        return redirect()->route('admin.pages');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $updateVal = $input['id'] ? ',' . $input['id'] : '';

        $v = Validator::make($input, [
            'text' => 'required',
            'slug' => 'required|unique:pages,slug' . $updateVal,
            'title' => 'required|unique:pages,title' . $updateVal,
            'description' => 'required',
        ]);

        if ($v->fails()) {
            Session::flash('error.message', $v->errors()->first());
            return redirect()->back()->withInput($input);
        }

        if (!empty($input['id'])) {
            $page = Page::findOrFail($input['id']);

            $page->title = $input['title'];
            $page->slug = $input['slug'];
            $page->description = $input['description'];
            $page->text = $input['text'];
            $page->save();

            Session::flash('success.message', trans("admin.ChangesSaved"));

            return redirect()->back()->withInput($input);
        }

        unset($input['id']);
        // @todo remove this deprecated value
        $input['footer'] = "no";
        Page::create($input);

        Session::flash('success.message', trans("admin.SuccesfulyCreateted"));
        return redirect()->route('admin.pages');
    }
}
