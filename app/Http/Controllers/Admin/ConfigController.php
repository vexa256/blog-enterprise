<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailCredentialsMailable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class ConfigController extends MainAdminController
{

    public $laravel_config = [
        "APP_URL",
        "APP_TIMEZONE",
        "MAIL_DRIVER",
        "MAIL_HOST",
        "MAIL_PORT",
        "MAIL_USERNAME",
        "MAIL_PASSWORD",
        "MAIL_ENCRYPTION",
        "SES_ACCESS_KEY_ID",
        "SES_SECRET_ACCESS_KEY",
        "SES_DEFAULT_REGION",
        "MAILGUN_DOMAIN",
        "MAILGUN_SECRET",
        "FILESYSTEM_DRIVER",
        "AWS_ACCESS_KEY_ID",
        "AWS_SECRET_ACCESS_KEY",
        "AWS_DEFAULT_REGION",
        "AWS_BUCKET",
    ];

    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['setconfig', 'check_mail']]);

        parent::__construct();
    }

    public function index()
    {
        return view('_admin.pages.config');
    }

    public function setconfig(Request $request)
    {
        $input = $request->all();

        $v = Validator::make(
            $input,
            [
                'sitelogo' => 'mimes:png,jpg,gif',
                'footerlogo' => 'mimes:png,jpg,gif',
                'favicon' => 'mimes:png,jpg',
                'maillogo' => 'mimes:png,jpg,gif',
            ]
        );

        if ($v->fails()) {
            Session::flash('error.message', $v->errors()->first());

            return redirect()->back()->withInput($input);
        }

        $sitelogo = $request->file('sitelogo');
        $footerlogo = $request->file('footerlogo');
        $favicon = $request->file('favicon');
        $maillogo = $request->file('maillogo');

        if ($footerlogo) {
            $footerlogo->move(public_path('upload'), 'flogo.png');
            $input['footerlogo'] = '/upload/flogo.png';
        }
        if ($sitelogo) {
            $sitelogo->move(public_path('upload'), 'logo.png');
            $input['sitelogo'] = '/upload/logo.png';
        }
        if ($favicon) {
            $favicon->move(public_path('upload'), 'favicon.png');
            $input['favicon'] = '/upload/favicon.png';
        }
        if ($maillogo) {
            $maillogo->move(public_path('upload'), 'maillogo.png');
            $input['maillogo'] = '/upload/maillogo.png';
        }

        if (isset($input['HomeColSec1Type1'])) {
            $input['HomeColSec1Type1'] = json_encode($input['HomeColSec1Type1']);
        }
        if (isset($input['HomeColSec2Type1'])) {
            $input['HomeColSec2Type1'] = json_encode($input['HomeColSec2Type1']);
        }
        if (isset($input['HomeColSec3Type1'])) {
            $input['HomeColSec3Type1'] = json_encode($input['HomeColSec3Type1']);
        }

        foreach ($input as $key => $value) {
            if (Str::endsWith($key, 'headcode') || Str::endsWith($key, 'footercode')) {
                $value = rawurlencode($value);
            }

            if (Str::startsWith($key, 'COMMENTS')) {
                if ($value == "1" || $value == "0") {
                    $value = $value == "1" ? 'true' : 'false';
                }
            }

            if (!in_array($key, $this->laravel_config)) {
                $key = implode('_', ['CONF', $key]);
            }

            if (Str::endsWith($key, 'sitename')) {
                $file = DotenvEditor::setKey("APP_NAME", $value);
            }

            if (!empty($value)) {
                $file = DotenvEditor::setKey($key, $value);
            } else {
                $file = DotenvEditor::deleteKey($key);
            }
        }

        $file->save();

        Session::flash('success.message', trans("admin.ChangesSaved"));

        return redirect()->back();
    }

    public function check_mail()
    {
        try {
            Mail::to(auth()->user()->email)->send(new MailCredentialsMailable());
            Session::flash('success.message', "No issue!");
        } catch (Exception $e) {
            Session::flash('error.message', "Could not validate mail credentials: <br> {$e->getMessage()}");
        }
        return redirect()->back();
    }
}
