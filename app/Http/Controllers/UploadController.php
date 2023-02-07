<?php

namespace App\Http\Controllers;

use App\Managers\UploadManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newUpload(Request $request)
    {
        $type = $request->query('type');
        $path_key = $request->query('path_key', 'path');

        if (empty($type)) {
            return array('status' => 'error', 'error' => "");
        }

        if ($request->hasFile('file')) {
            try {
                $upload = new UploadManager();
                if ($type === 'video') {
                    $upload->mimes(['mp4', 'webm']);
                    $upload->max(get_buzzy_config('user_max_videoupload_size', 10000));
                }
                $upload->name(Auth::user()->id . '-' . md5(time()));
                $upload->file($request, 'file');
                $upload->path($type === 'page' ? 'upload/pages' : 'upload/tmp');

                if ($type == 'video') {
                    $upload->save();
                } elseif ($type == 'entry' || $type == 'page') {
                    $upload->make();
                    $upload->mime('jpg');
                    $upload->acceptGif();
                    $upload->save([
                        'resize_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.entry-image_big_width', 780),
                    ]);
                } elseif ($type == 'preview') {
                    $upload->make();
                    $upload->mime('jpg');
                    $upload->save([
                        'fit_width' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_big_width', 780),
                        'fit_height' => config('buzzytheme_' . get_buzzy_config('CurrentTheme') . '.preview-image_big_height', 440),
                    ]);
                } elseif ($type == 'answer') {
                    $upload->make();
                    $upload->mime('jpg');
                    $upload->save([
                        'fit_width' => 250,
                        'fit_height' => 250,
                    ]);
                }

                return response()->json(array('status' => 'success', $path_key => $upload->getFullUrl()), 200);
            } catch (\Exception $e) {
                return response()->json(array('status' => 'error', 'error' => $e->getMessage()),  200);
            }
        } else {
            return response()->json(array('status' => 'error', 'error' => 'Pick a file'),  200);
        }
    }
}
