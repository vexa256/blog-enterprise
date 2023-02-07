<?php

namespace App\Installer\Controllers;

use Illuminate\Support\Facades\Session;
use App\Installer\Helpers\DatabaseManager;

class UpdateController extends InstallerController
{
    public function update()
    {
        set_buzzy_config('APP_ENV', 'local', false);
        return view('installer.update.home');
    }

    public function update_init(DatabaseManager $manager)
    {
        $response = $manager->updateDatabaseAndSeedTables();

        // upgrade
        if ($response['status'] == 'error') {
            Session::flash('error.message', $response['message']);
            return redirect()->back()->withErrors(['message' => $response['message']]);
        }

        set_buzzy_config('BUZZY_VERSION', config('buzzy.version'), false);
        @file_put_contents(storage_path('installed'), config('buzzy.version'));
        @unlink(storage_path('updates.json')); // try to get updates again
        Session::flash('success.message', trans('installer.upgrade.finished'));
        return redirect('/admin');
    }
}
