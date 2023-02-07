<?php

/**
 * Modified version of https://github.com/tanmuhittin/laravel-google-translate/blob/master/src/Commands/TranslateFilesCommand.php
 */

namespace App\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Google\Cloud\Translate\V2\TranslateClient;

class TranslateFilesCommand extends Command
{
    public static $request_count = 0;
    public static $request_per_sec = 5;
    public static $sleep_for_sec = 1;

    public $base_locale;
    public $locales;
    public $excluded_files;
    public $target_files;
    public $force;
    public $verbose;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:translate {locale} {from=en} {force?} {verbose?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate Translation files. translations:translate';

    /**
     * TranslateFilesCommand constructor.
     * @param string $base_locale
     * @param string $locales
     * @param bool $force
     * @param bool $json
     * @param string $target_files
     * @param string $excluded_files
     * @param bool $verbose
     */
    public function __construct($base_locale = 'en', $locales = 'tr,it', $target_files = '', $force = false, $verbose = true, $excluded_files = 'auth,pagination,validation,passwords')
    {
        parent::__construct();
        $this->base_locale = $base_locale;
        $this->locales = array_filter(explode(",", $locales));
        $this->target_files = array_filter(explode(",", $target_files));
        $this->force = $force;
        $this->verbose = $verbose;
        $this->excluded_files = array_filter(explode(",", $excluded_files));
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        //Collect input
        if ($from = $this->argument('from')) {
            $this->base_locale = $from;
        }

        if ($force = $this->argument('force')) {
            $this->force = $force;
        }

        if ($verbose = $this->argument('verbose')) {
            $this->verbose = $verbose;
        }

        $this->locales = array_filter(explode(",", $this->argument('locale')));

        //Start Translating
        $bar = $this->output->createProgressBar(count($this->locales));
        $bar->start();
        $this->line("");
        // loop target locales

        $this->line("Exploring strings...");
        $stringKeys = $this->get_base_locale_strings();
        $this->line('Exploration completed. Let\'s get started');

        foreach ($this->locales as $locale) {
            if ($locale == $this->base_locale) {
                continue;
            }
            $this->line($this->base_locale . " -> " . $locale . " translating...");
            $this->translate_json_array_file($locale, $stringKeys);

            $bar->advance();
            $this->line("");
        }
        $bar->finish();
        $this->line("");
        $this->line("Translations Completed.");
    }


    /**
     * @param $base_locale
     * @param $locale
     * @param $text
     * @return mixed
     * @throws \Exception
     */
    private static function translate_via_api_key($base_locale, $locale, $texts)
    {
        $handler = new TranslateClient([
            'key' => env('GOOGLE_TRANSLATE_API_KEY', false)
        ]);

        $results = $handler->translateBatch($texts, [
            'source' => $base_locale,
            'target' => $locale
        ]);

        return $results;
    }

    /**
     * @return array
     */
    public function get_base_locale_strings()
    {
        if (file_exists(resource_path('lang/' . $this->base_locale . '.json'))) {
            $json_translations_string = file_get_contents(resource_path('lang/' . $this->base_locale . '.json'));
            $langs = json_decode($json_translations_string, true);

            //  resulted in a `429 Too Many Requests
            return collect($langs)->toArray();
        }

        return [];
    }


    /**
     * @param $base_locale
     * @param $locale
     * @param $text
     * @return mixed|null|string
     * @throws \ErrorException
     * @throws \Exception
     */
    public function sanitize_translate($translated, $text)
    {
        preg_match_all("/(^:|([\s|\:])\:)([a-zA-z])+/", $text, $matches);
        $parameter_map = [];
        $i = 1;
        foreach ($matches[0] as $match) {
            $parameter_map["X" . $i] = $match;
            $i++;
        }

        foreach ($parameter_map as $key => $attribute) {
            $combinations = [
                $key,
                substr($key, 0, 1) . " " . substr($key, 1),
                strtoupper(substr($key, 0, 1)) . " " . substr($key, 1),
                strtoupper(substr($key, 0, 1)) . substr($key, 1)
            ];
            foreach ($combinations as $combination) {
                $translated = str_replace($combination, $attribute, $translated, $count);
                if ($count > 0)
                    break;
            }
        }
        $translated = str_replace("  :", " :", $translated);
        $translated = str_replace(": ", ":", $translated);
        return $translated;
    }

    /**
     * @param $strings
     */
    public function sanitize_texts_for_translate($strings)
    {
        foreach ($strings as $key => $text) {
            preg_match_all('/(^:|([\s|\:])\:)([a-zA-z])+/', $text, $matches);
            $i = 1;
            foreach ($matches[0] as $match) {
                $strings[$key] = str_replace($match, "X" . $i, $text);
                $i++;
            }
        }


        return $strings;
    }

    /**
     * @param $locale
     * @param $stringKeys
     * @throws \ErrorException
     * @throws \Exception
     */
    public function translate_json_array_file($locale, $basestringKeys)
    {
        $new_lang = [];
        $json_existing_translations = [];
        if (file_exists(resource_path('lang/' . $locale . '.json'))) {
            $json_translations_string = file_get_contents(resource_path('lang/' . $locale . '.json'));
            $json_existing_translations = json_decode($json_translations_string, true);
        }

        $to_be_translated = [];
        foreach ($basestringKeys as $key => $translation) {
            $existing_translate =  Arr::get($json_existing_translations, $key, null);
            $need_translation = !$existing_translate || $existing_translate === $translation;

            if ($need_translation || $this->force) {
                $to_be_translated[] = $translation;
            }
            $new_lang[$key] = $need_translation ? $translation : $existing_translate;
        }


        $all_translated = [];
        if ($to_be_translated) {
            $chucks = collect($to_be_translated)->chunk(100)->toArray();
            foreach ($chucks as $chunk) {
                $chunk =  array_values($this->sanitize_texts_for_translate($chunk));
                $all_translated = array_merge($all_translated, self::translate_via_api_key($this->base_locale, $locale, $chunk));
            }
        }

        foreach ($new_lang as $_key => $_translation) {
            $translation_key = array_search($_translation, $to_be_translated, true);
            $translated =  Arr::get($all_translated, $translation_key);
            if (!$translation_key || !$translated) {
                continue;
            }

            $translatedText =  Arr::get($translated, 'text');

            if ($translatedText) {
                $new_lang[$_key] = addslashes($this->sanitize_translate($translatedText, $_translation));
            }
        }

        $file = fopen(resource_path('lang/' . $locale . '.json'), "w+");
        $write_text = json_encode($new_lang, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        fwrite($file, $write_text);
        fclose($file);
    }
}
