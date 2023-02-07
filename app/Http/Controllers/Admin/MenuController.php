<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use App\MenuItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MenuController extends MainAdminController
{
    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['store', 'sort', 'update', 'destroy']]);

        parent::__construct();
    }

    public function index()
    {
        $menu = Menu::first();

        return redirect()->route('admin.menu.show', ['menu' => $menu->id]);
    }

    /**
     * Return single menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Menu $menu)
    {
        $menu_item = MenuItem::find($request->get('edit'));

        return view('_admin.pages.menus.show', compact('menu', 'menu_item'));
    }

    /**
     * Create new menu.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (($errors = $this->validation($request->all())) !== true) {
            return $errors;
        }

        $order = Menu::max('order');
        $menu = new Menu();
        $menu->name = $request->input('name');
        $menu->location = $request->input('location');
        $menu->order = $order + 1;
        $menu->custom_class = $request->input('custom_class');
        $menu->save();


        return redirect()->back();
    }

    /**
     * Sort menu list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (isset($request->menus)) {
            $menus = $request->get('menus');
            $order = 1;

            foreach ($menus as $item) {
                $menu = Menu::find($item['id']);
                $menu->order = $order;

                if ($menu->update()) {
                    $order++;
                }
            }
        }

        return redirect()->back();
    }

    /**
     * Update the specified menu.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (($errors = $this->validation($request->all())) !== true) {
            return $errors;
        }

        if ($request->id && $menu = Menu::find($request->id)) {
            $menu->name = $request->name;
            $menu->location = $request->location;
            $menu->custom_class = $request->custom_class;

            if ($menu->update()) {
                return redirect()->back();
            }
        }

        return redirect()->back();
    }

    /**
     * Delete the specified menu.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->id) {
            $menu = Menu::find($request->id);
            $menu->items()->delete();
            $menu->delete();
        }

        return redirect()->back();
    }

    /**
     * Validation.
     *
     * @param array $data
     *
     * @return \Illuminate\Http\Response|true
     */
    public function validation($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            Session::flash('error.message', $validator->errors()->first());
            return redirect()->back()->withInput($data);
        }

        return true;
    }
}
