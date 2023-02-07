<?php

namespace App\Http\Controllers\Admin;

use App\ReactionIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReactionController extends MainAdminController
{

    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['delete', 'addnew']]);

        parent::__construct();
    }

    public function index(Request $request)
    {
        $reaction = null;

        if ($request->query('edit')) {
            $reaction = ReactionIcon::findOrFail($request->query('edit'));
        }

        $reactions = ReactionIcon::byLanguage()->orderBy('ord', 'asc')->get();

        return view('_admin.pages.reactions', compact('reactions', 'reaction'));
    }


    public function delete($id)
    {
        $pages = ReactionIcon::findOrFail($id);
        $pages->delete();

        Session::flash('success.message', trans("admin.Deleted"));
        return redirect()->route('admin.reactions');
    }

    public function addnew(Request $request)
    {

        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'ord' => 'required',
            'name' => 'required',
            'reaction_type' => 'required',
            'display' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput($inputs);
        }

        if (!empty($inputs['id'])) {
            $react = ReactionIcon::findOrFail($inputs['id']);
        } else {
            $retype = ReactionIcon::where('reaction_type', $inputs['reaction_type'])->first();
            if ($retype) {
                Session::flash('error.message', 'Slug must be Unique');
                return redirect()->route('admin.reactions');
            }

            $react = new ReactionIcon;
        }

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');

            $icon_name = uniqid() . '-' . $file->getClientOriginalName();

            $icon_url =  '/upload/media/' . $icon_name;

            if ($file) {
                $file->move(public_path() . '/upload/media/', $icon_name);
            }
        } else {
            $icon_url = $react->icon;
        }

        $react->ord = $inputs['ord'];
        $react->name = $inputs['name'];
        $react->reaction_type = $inputs['reaction_type'];
        $react->icon = $icon_url;
        $react->display = $inputs['display'];
        $react->language = $inputs['language'] ?? get_default_language();
        $react->save();

        if (!empty($inputs['id'])) {
            Session::flash('success.message', trans("admin.ChangesSaved"));
        } else {
            Session::flash('success.message', trans("admin.SuccesfulyCreateted"));
        }
        return redirect()->route('admin.reactions');
    }
}
