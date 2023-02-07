<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class V45Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(V45CategorySeeder::class);
        $this->call(V45PostSeeder::class);
        $this->call(LanguageSeeder::class);

        if (file_exists(public_path('assets/images/logo.png'))) {
            File::copy(public_path('assets/images/logo.png'), public_path('upload/logo.png'));
            set_buzzy_config('sitelogo', '/upload/logo.png');
        }
        if (file_exists(public_path('assets/images/flogo.png'))) {
            File::copy(public_path('assets/images/flogo.png'), public_path('upload/flogo.png'));
            set_buzzy_config('footerlogo', '/upload/flogo.png');
        }
        if (file_exists(public_path('assets/images/favicon.png'))) {
            File::copy(public_path('assets/images/favicon.png'), public_path('upload/favicon.png'));
            set_buzzy_config('favicon', '/upload/favicon.png');
        }

        set_buzzy_config('p_multilanguage', get_buzzy_config('SiteMultilanguage'));
    }
}
