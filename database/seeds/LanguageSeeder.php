<?php

namespace Database\Seeders;

use App\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // old languages array
        $languages = config('languages.language', [
            'en' => null,
            'tr' => null,
            'ru' => null,
            'it' => null,
            'pt' => null,
            'es' => null,
            'nl' => null,
            'ar' => null,
        ]);
        // new full list
        $all_languages = get_language_list();

        if ($all_languages) {
            $order = 0;
            foreach ($all_languages as $key => $language) {
                Language::firstOrCreate([
                    'name' => $language,
                    'code' => str_replace('pt_br', 'pt', $key),
                ], [
                    'direction' => in_array($key, get_available_rtl_languages()) ? 'rtl' : 'ltr',
                    'active' => array_key_exists($key, $languages),
                    'order' => $order
                ]);
                $order++;
            }
        }
    }
}
