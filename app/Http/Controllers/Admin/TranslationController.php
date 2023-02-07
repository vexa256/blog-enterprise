<?php

namespace App\Http\Controllers\Admin;

use App\Language;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Managers\TranslationManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\MailTranslationSuggestion;
use Illuminate\Support\Facades\Session;

class TranslationController extends MainAdminController
{

    /**
     * @var \App\Managers\TranslationManager
     */
    private $manager;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TranslationManager $manager)
    {
        parent::__construct();

        $this->middleware('DemoAdmin', ['only' => [
            'update',
            'sort',
            'lock',
            'send',
        ]]);

        $this->manager = $manager;
    }

    /**
     * Show Comments lists
     *
     * @return void
     */
    public function index($locale = null)
    {
        if (!$locale) {
            return redirect()->route('admin.translations', ['locale' => get_default_language()]);
        }

        if (!$current_language = Language::where('code', $locale)->first()) {
            return redirect()->route('admin.dashboard');
        }

        $translations = [];
        $default_translations = $this->manager->getTranslationsFromFile('en');
        $locale_translations = $this->manager->getTranslationsFromFile($locale);

        $total_count = 0;
        $trans_count = 0;
        foreach ($default_translations as $key => $translation) {
            $is_translated =  $locale === 'en' || trans($key, [], $locale) !== $translation;
            $slug = Str::slug($key);
            $translations[$slug] = [
                'default' => $translation,
                'translation' => $is_translated ? trans($key, [], $locale) : $translation,
                'is_translated' => $is_translated,
            ];
            if ($is_translated) {
                $trans_count++;
            }
            $total_count++;
        }

        return view('_admin.pages.translations', compact('translations', 'locale', 'current_language', 'total_count', 'trans_count'));
    }

    /**
     * Show a User
     *
     * @return void
     */
    public function update(Request $request, $locale = 'en')
    {
        $data = $request->all();

        try {
            $newTranslations = [];
            $translations = $this->manager->getTranslationsFromFile('en');

            foreach ($translations as $key => $translation) {
                $newTranslations[$key] = Arr::get($data, Str::slug($key), $translation);
            }

            $this->manager->exportTranslations($newTranslations, $locale);

            File::put(storage_path('/languages/' . $locale . '.json'), json_encode($newTranslations, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE));
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        if ($request->expectsJson()) {
            return ['status' => 'success', 'message' => __('Translations successfully saved')];
        }

        return redirect()->route('admin.translations', ['locale' => $locale]);
    }

    /**
     * Sort language items.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if ($request->ajax()) {
            $items = $request->get('langs');
            $order = 0;
            foreach ($items as $item) {
                $langItem = Language::find($item['id']);
                $langItem->order = $order;
                $langItem->update();
                $order++;
            }
            Cache::forget('active_languages');
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }


    /**
     * Activate/Disable language items.
     *
     * @param string $locale
     */
    public function lock($locale)
    {
        if (get_buzzy_config('sitedefaultlanguage') === $locale) {
            Session::flash('error.message', __("You can't disable site default language."));

            return redirect()->back();
        }

        $langItem = Language::where('code', $locale)->first();
        if ($langItem) {
            $langItem->active = !$langItem->active;
            $langItem->order = $langItem->active ? Language::active()->max('order') + 1 : 0;
            $langItem->update();
            Cache::forget('active_languages');
        }

        return redirect()->back();
    }

    /**
     * Disable language items.
     *
     * @param string $locale
     */
    public function send($locale)
    {
        try {
            if (env('MAIL_DRIVER') == 'log') {
                throw new \Exception("Wrong Mailler", 1);
            }
            $langItem = Language::where('code', $locale)->first();
            if ($langItem) {
                $translations = $this->manager->getTranslationsFromFile($locale);

                $path = '/upload/tmp/' . $locale . '-' . uniqid() . '.json';
                File::put(public_path($path), json_encode($translations, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE));

                Mail::to('akbilisim.buzzy@gmail.com')->send(new MailTranslationSuggestion(url($path)));
            }

            Session::flash('success.message', __('Successfully Sent. Thanks for participating!'));
        } catch (\Exception $th) {
            Session::flash('error.message', $th->getMessage());
        }

        return redirect()->back();
    }
}
