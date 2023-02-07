<?php

namespace App\Http\Controllers;

use Embed\Embed;
use Illuminate\Http\Request;
use App\Handlers\Editor\QuizFetcher;
use App\Http\Controllers\Controller;
use App\Handlers\Editor\ContentFetcher;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function addnewform(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->route('home');
        }

        if ($request->query('addnew') == 'text') {
            return view('editor._forms.text');
        } elseif ($request->query('addnew') == 'image') {
            return view('editor._forms.image');
        } elseif ($request->query('addnew') == 'poll') {
            return view('editor._forms.poll.question');
        } elseif ($request->query('addnew') == 'embed') {
            return view('editor._forms.embed');
        } elseif ($request->query('addnew') == 'video') {
            return view('editor._forms.video');
        } elseif ($request->query('addnew') == 'tweet') {
            return view('editor._forms.special', [
                'typeofwidget' => 'tweet',
                'titleofwidget' => trans('updates.tweet'),
                'iconofwidget' => 'fa-twitter',
                'urlto' => trans('updates.urltotweet'),

            ]);
        } elseif ($request->query('addnew') == 'facebookpost') {
            return view('editor._forms.special', [
                'typeofwidget' => 'facebookpost',
                'titleofwidget' => trans('updates.facebookpost'),
                'iconofwidget' => 'fa-facebook',
                'urlto' => trans('updates.urltofacebookpost'),

            ]);
        } elseif ($request->query('addnew') == 'instagram') {
            return view('editor._forms.special', [
                'typeofwidget' => 'instagram',
                'titleofwidget' => trans('updates.instagram'),
                'iconofwidget' => 'fa-instagram',
                'urlto' => trans('updates.urltoinstagram'),

            ]);
        } elseif ($request->query('addnew') == 'soundcloud') {
            return view('editor._forms.special', [
                'typeofwidget' => 'soundcloud',
                'titleofwidget' => trans('updates.soundcloud'),
                'iconofwidget' => 'fa-soundcloud',
                'urlto' => trans('updates.urltosoundcloud'),

            ]);
        } elseif ($request->query('addnew') == 'question') {
            return view('editor._forms.quiz.question');
        } elseif ($request->query('addnew') == 'result') {
            return view('editor._forms.quiz.result');
        } elseif ($request->query('addnew') == 'answer') {
            return view('editor._forms.quiz.answer');
        } elseif ($request->query('addnew') == 'pollanswer') {
            return view('editor._forms.poll.answer');
        }
    }


    public function fetchVideoEmbed(Request $request)
    {

        if (!$request->ajax()) {
            return redirect()->route('home');
        }

        $url = $request->input('url');

        // incase if $thumb then tuse save button. we need to save image for that
        try {
            if (!$url) {
                throw new \Exception(trans('updates.BuzzyEditor.lang.lang_11'));
            }

            if (strpos($url, 'instagram') !== false) {
                static $number;
                $c_number = $number++;
                $inst_url = explode('?', $url);
                $url = $inst_url[0];
                return [
                    'status' => 'success',
                    'url' =>  $url,
                    //  'title' => $embed->title,
                    //    'image' => $embed->image,
                    // 'authorName' => $embed->authorName,
                    'title' => '',
                    'html' => '<div class="embed-containera">
                        <iframe id="instagram-embed-' . $c_number . '" src="' . $url . 'embed/captioned/?v=5" allowtransparency="true" frameborder="0" data-instgrm-payload-id="instagram-media-payload-' . $c_number . '" scrolling="no"></iframe>
                        <script async defer src="//platform.instagram.com/' . get_buzzy_config("sitelanguage", "en_US") . '/embeds.js"></script>
                    </div>'
                ];
            } elseif (strpos($url, 'facebook') !== false || strpos($url, 'fb.watch') !== false) {
                return [
                    'status' => 'success',
                    'title' => '',
                    'url' =>  $url,
                    'html' => '<div class="fb-post" data-href="' . $url . '" data-width="100%"></div>'
                ];
            }

            $oembed = new Embed();
            $oembed->getCrawler()->addDefaultHeaders([
                'Accept-Language' => 'en-US,en;q=0.2',
                'Cache-Control' => 'max-age=0,no-cache',
            ]);
            $oembed->setSettings(
                [
                    'twitch:parent' => $_SERVER['SERVER_NAME'] === 'localhost' ? null : $_SERVER['SERVER_NAME'],
                ]
            );

            $embed = $oembed->get($url);

            if (!$embed || empty($embed->code->html)) {
                throw new \Exception(trans('updates.BuzzyEditor.lang.lang_11'));
            }

            return [
                'status' => 'success',
                'url' => $url,
                'title' => $embed->title,
                'image' => is_object($embed->image) && method_exists($embed->image, '__toString') ? $embed->image->__toString() : null,
                'authorName' => $embed->authorName,
                'html' => $embed->code->html
            ];
        } catch (\Exception $e) {
            return ['status' => 'error', 'title' => trans('updates.error'), 'message' => $e->getMessage()];
        }
    }


    public function get_content_data(Request $request)
    {
        $url = $request->input('dataurl');
        $type = $request->input('type');
        try {
            if (!$url) {
                throw new \Exception(trans('updates.BuzzyEditor.lang.lang_11'));
            }

            if ($type > '') {
                return app(QuizFetcher::class)->run($url, $type);
            }

            $data = app(ContentFetcher::class)->run($url);

            return $data;
        } catch (\Exception $e) {
            return ['status' => 'error', 'title' => trans('updates.error'), 'error' => $e->getMessage()];
        }
    }
}
