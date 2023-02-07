<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AkApi;
use App\Http\Controllers\Api\AkUpdater;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class PluginsController extends MainAdminController
{
    /**
     * Akbilisim Product API.
     *
     * @var AkApi
     */
    private $api;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('DemoAdmin', ['only' => ['handleActivation']]);
    }

    public function show()
    {
        $plugins = $this->product_api->getPlugins();

        if (!$plugins) {
            Session::flash('error.message', trans("admin.pluginsnotavailable"));
            return redirect()->route('admin.dashboard');
        }

        return view('_admin.pages.plugins', compact('plugins'));
    }

    public function handleActivation(Request $request)
    {
        $item_code = $request->input('item_code');
        $item_id = $request->input('item_id');

        if (!$item_code) {
            return ['status' => 'error', 'message' => 'Not valid Plugin'];
        }

        if ($item_id) {
            $response = $this->product_api->checkItemPurchase($item_id);
            if ($response['status'] == 'error') {
                set_buzzy_config('p_' . $item_code, 'off');
                return array_merge($response, ['reload' => true]);
            }
        }

        $status = get_buzzy_config('p_' . $item_code) === 'on' ? 'off' : 'on';

        set_buzzy_config('p_' . $item_code, $status);

        return ['status' => 'success', 'message' => ''];
    }
}
