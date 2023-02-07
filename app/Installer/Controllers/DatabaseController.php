<?php

namespace App\Installer\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Installer\Helpers\DatabaseManager;
use App\Installer\Requests\DatabaseRequest;

class DatabaseController extends InstallerController
{
	public function index()
	{
		return view('installer.install.database');
	}

	public function post(DatabaseRequest $request, DatabaseManager $manager)
	{
		$configs = [
			'connection' => $request->get('connection', 'mysql'),
			'host' => $request->get('host', '127.0.0.1'),
			'port' => $request->get('port', '3306'),
			'database' => $request->get('database'),
			'username' => $request->get('username'),
			'password' => $request->get('password'),
			'prefix' => $request->get('prefix')
		];

		$this->setConfigDynamically($configs);

		// test
		try {
			DB::connection()->reconnect();
		} catch (\PDOException $e) {
			return redirect(url('installer/database'))
				->withErrors(['exception' => $e->getMessage()])
				->withInput();
		}

		// save configs
		foreach ($configs as $key => $value) {
			set_buzzy_config('DB_' . strtoupper($key), $value, false);
		}

		// migrat & seed
		$response = $manager->migrateAndSeed();

		if ($response['status'] == 'error') {
			return redirect(url('installer/database'))
				->withErrors(['message' => $response['message']])
				->withInput();
		}

		return redirect(url('installer/finish'));
	}

	private function setConfigDynamically($configs)
	{
		$connection = $configs['connection'];
		config(['database.default' => $connection]);
		unset($configs['connection']);

		foreach ($configs as $key => $value) {
			config(['database.connections.' . $connection . '.' . $key => $value]);
		}
	}

	public function finish()
	{
		try {
			set_buzzy_config('BUZZY_VERSION', config('buzzy.version'), false);
			@file_put_contents(storage_path('installed'), config('buzzy.version'));
		} catch (\Exception $e) {
			return redirect(url('installer/database'))
				->withErrors(['exception' => $e->getMessage()]);
		}

		Session::flash('success.message', trans('installer.final.finished'));
		return redirect()->route('home');
	}
}
