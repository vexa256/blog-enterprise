<?php

use Embed\Embed;
use App\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

function makepreview($img, $type = null, $folder = 'posts')
{
    if ($type !== null) {
        $type = "-$type.jpg";
    }
    if ($img == null or $img == '') {
        if ($folder === 'members/splash') {
            return asset('assets/images/user-splash' . $type);
        } elseif ($folder === 'members/avatar') {
            return asset('assets/images/user-avatar' . $type);
        }
    } elseif (substr($img, 0, 4) == "http") {
        return $img;
    }

    $path = "upload/media/" . $folder . "/" . $img . $type;

    if (env('FILESYSTEM_DRIVER') === "s3") {
        return Storage::disk('s3')->url($path);
    }

    return url($path);
}

function menu($location, $args = array())
{
    $location = Str::slug($location);

    $args = array_merge(array(
        'ul' => true,
        'ul_class' => '',
        'li_class' => '',
        'a_class' => '',
    ), $args);

    $menu = \App\Menu::with(['items' => function ($query) {
        $query->byLanguage();
        $query->whereNull('parent_id');
        $query->orderBy('order', 'asc');
    }, 'items.children'])
        ->where('location', $location)->first();

    if ($menu) {
        $menuItems =  $menu->items;

        if ($menu->custom_class) {
            $args['ul_class'] += ' ' . $menu->custom_class;
        }

        echo view('_particles.menu.generate-menu', compact('menuItems', 'args'))->render();
    }
}

function menu_settings($menu_id)
{
    $menu = \App\Menu::find($menu_id);
    $settings = config('buzzy.menus.' . $menu->location);
    $depth = Arr::get($settings, 'depth', 1);
    $apply_child_as_parent = Arr::get($settings, 'apply_child_as_parent', false);

    return compact('depth', 'apply_child_as_parent');
}

function menu_icon($icon)
{
    if (!is_string($icon)) {
        return;
    }

    if (Str::startsWith($icon, "<i")) {
        return $icon;
    }

    return '<i class="material-icons">' . $icon . '</i>';
}

function generate_menu_url($url)
{
    if (Str::startsWith('http', $url) || empty($url)) {
        return $url;
    }

    if (get_multilanguage_enabled()) {
        if ($prefix = get_multilanguage_prefix()) {
            return url($prefix . '/' . trim($url, '/'));
        }
    }

    return url($url);
}

function get_post_types($option = true)
{
    $post_types = config('buzzy.post_types');
    foreach ($post_types as $type => $value) {
        if (
            get_buzzy_config('p_buzzynews') != 'on' && $type == 'news'
            || get_buzzy_config('p_buzzylists') != 'on' && $type == 'list'
            || get_buzzy_config('p_buzzyquizzes') != 'on' && $type == 'quiz'
            || get_buzzy_config('p_buzzypolls') != 'on' && $type == 'poll'
            || get_buzzy_config('p_buzzyvideos') != 'on' && $type == 'video'
        ) {
            unset($post_types[$type]);
        } else {
            if ($option) {
                $post_types[$type] = trans($value['trans']);
            }
        }
    }

    return $post_types;
}


function get_buzzy_config($key, $default = '')
{
    $value = env('CONF_' . $key);

    if (is_null($value)) {
        return $default;
    }

    return $value;
}


function set_buzzy_config($key, $value, $prefix = true)
{
    if ($prefix) {
        $key = implode('_', ['CONF', $key]);
    }

    if (!empty($value)) {
        $file = DotenvEditor::setKey($key, $value);
    } else {
        $file = DotenvEditor::deleteKey($key);
    }

    $file->save();

    return true;
}


function get_buzzy_theme()
{
    static $_theme;

    if (!empty($_theme)) {
        return $_theme;
    }

    $theme = get_buzzy_config('CurrentTheme', 'modern');

    if (env('APP_DEMO')) {
        $theme_req = request()->get('theme');

        if ($theme_req) {
            Cookie::queue('buzzy_theme', $theme_req, 9999999, '/');
        } elseif (Cookie::has('buzzy_theme')) {
            $theme_req = Cookie::get('buzzy_theme');
        }

        if ($theme_req && array_key_exists($theme_req, config('buzzy.themes'))) {
            $theme = $theme_req;
        }
    }

    $_theme = $theme;

    return $theme;
}


function get_buzzy_theme_config($key, $default = '', $fallback = false)
{
    $theme = get_buzzy_theme();
    $value = get_buzzy_config('T_' .  $theme . '_' . $key);

    if ($fallback && empty($value)) {
        $value = get_buzzy_config($key);
    }

    if (empty($value)) {
        return $default;
    }

    return $value;
}

function get_buzzy_config_by_theme($theme, $key, $default = '')
{
    return get_buzzy_config('T_' .  $theme . '_' . $key, $default);
}


function get_language_list($language = '')
{
    $languages =  array(
        "af" => __("Afrikaans"),
        "ga" => __("Irish"),
        "sq" => __("Albanian"),
        "it" => __("Italian"),
        "ar" => __("Arabic"),
        "ja" => __("Japanese"),
        "az" => __("Azerbaijani"),
        "kn" => __("Kannada"),
        "eu" => __("Basque"),
        "ko" => __("Korean"),
        "bn" => __("Bengali"),
        "bs" => __("Croatian"),
        "fi" => __("Filipino"),
        "he" => __("Hebrew"),
        "hy" => __("Armenian"),
        "kk" => __("Kazakh"),
        "mn" => __("Mongolian"),
        "mr" => __("Marathi"),
        "la" => __("Latin"),
        "be" => __("Belarusian"),
        "lv" => __("Latvian"),
        "bg" => __("Bulgarian"),
        "lt" => __("Lithuanian"),
        "ca" => __("Catalan"),
        "mk" => __("Macedonian"),
        "zh_CN" => __("Chinese Simplified"),
        "zh_TW" => __("Chinese Traditional"),
        "ms" => __("Malay"),
        "mt" => __("Maltese"),
        "hr" => __("Croatian"),
        "no" => __("Norwegian"),
        "cs" => __("Czech"),
        "fa" => __("Persian"),
        "da" => __("Danish"),
        "pl" => __("Polish"),
        "nl" => __("Dutch"),
        "pt" => __("Portuguese"),
        "pt_BR" => __("Portuguese (Brazil)"),
        "en" => __("English"),
        "ro" => __("Romanian"),
        "eo" => __("Esperanto"),
        "ru" => __("Russian"),
        "et" => __("Estonian"),
        "sr_Cyrl" => __("Serbian (Cyrillic)"),
        "sr_Latn" => __("Serbian (Latin)"),
        "tl" => __("Filipino"),
        "sk" => __("Slovak"),
        "fi" => __("Finnish"),
        "sl" => __("Slovenian"),
        "fr" => __("French"),
        "es" => __("Spanish"),
        "gl" => __("Galician"),
        "sw" => __("Swahili"),
        "ka" => __("Georgian"),
        "sv" => __("Swedish"),
        "de" => __("German"),
        "ta" => __("Tamil"),
        "el" => __("Greek"),
        "te" => __("Telugu"),
        "gu" => __("Gujarati"),
        "th" => __("Thai"),
        "tj" => __("Tajik"),
        "tk" => __("Turkmen"),
        "ug" => __("Uyghur"),
        "ht" => __("Haitian Creole"),
        "tr" => __("Turkish"),
        "iw" => __("Hebrew"),
        "ne" => __("Nepali"),
        "uk" => __("Ukrainian"),
        "hi" => __("Hindi"),
        "ur" => __("Urdu"),
        "uz_Cyrl" => __("Uzbek (Cyrillic)"),
        "uz_Latn" => __("Uzbek (Latin)"),
        "hu" => __("Hungarian"),
        "vi" => __("Vietnamese"),
        "is" => __("Icelandic"),
        "cy" => __("Welsh"),
        "id" => __("Indonesian"),
        "yi" => __("Yiddish"),
    );

    if (!empty($language)) {
        return Arr::get($languages, $language, $language);
    }

    return $languages;
}

function get_active_languages()
{
    $languages = Cache::get('active_languages');
    if (!empty($languages)) {
        return $languages;
    }

    $_languages = [];
    $languages = \App\Language::active()->orderBy('order')->get();
    foreach ($languages as $language) {
        $_languages[$language->code] = $language->name;
    }

    Cache::forever('active_languages', $_languages);

    return $_languages;
}


function get_available_languages()
{
    $languages = Cache::get('available_languages');
    if (!empty($languages)) {
        return $languages;
    }

    $_languages = [];
    $filesInFolder = File::files(resource_path('/lang/'));
    foreach ($filesInFolder as $path) {
        $file = File::name($path);
        $_languages = Arr::add($_languages, $file, $file);
    }

    Cache::forever('available_languages', $_languages);

    return $_languages;
}


function get_buzzy_language_list_options()
{
    $languages = [];
    foreach (get_active_languages() as $key => $language) {
        $languages[$key] =  get_language_list($language) . ' (' . $key . ')';
    }

    return $languages;
}


function get_available_rtl_languages()
{
    $rtl_languages = array(
        "ar",
        "fa",
        "ur",
        "yi"
    );

    return $rtl_languages;
}

function get_social_links_trans($item)
{
    switch ($item['trans']) {
        case 'subscribe_us_on':
            return __('Subscribe Us on :name', ['name' => $item['name']]);
            break;
        case 'join_us_on':
            return __('Join Us on :name', ['name' => $item['name']]);
            break;
        case 'support_us_on':
            return __('Support Us on :name', ['name' => $item['name']]);
            break;
        case 'follow_us_on':
        default:
            return __('Follow Us on :name', ['name' => $item['name']]);
            break;
    }
}

function get_default_language()
{
    return get_buzzy_config('sitedefaultlanguage', 'en');
}

function get_language_is_rtl($locale)
{
    return in_array($locale, get_available_rtl_languages());
}

function get_buzzy_rtl_prefix()
{
    return get_language_is_rtl(get_buzzy_locale()) ? '-rtl' : '';
}

function get_language_route($locale)
{
    if (get_multilanguage_routing_enabled()) {
        if (get_default_language() == $locale) {
            return url('/');
        }

        return url($locale);
    }

    return route('select-language', ['locale' => $locale]);
}

function get_multilanguage_enabled()
{
    return get_buzzy_config('p_multilanguage') === 'on';
}

function get_multilanguage_routing_enabled()
{
    return get_multilanguage_enabled() && get_buzzy_config('multilanguage_type', 'route') === 'route';
}

function get_multilanguage_prefix()
{
    $default_lang = get_default_language();
    $locale = request()->routeLocale ?: request()->segment(1);

    if (empty($locale) || $default_lang == $locale) {
        return false;
    }

    if (!array_key_exists($locale, get_available_languages())) {
        return false;
    }

    return $locale;
}

function get_multilanguage_url($newPrefix = null)
{
    if (!get_multilanguage_routing_enabled()) {
        return route('select-language', ['locale' => $newPrefix ?: get_default_language()]);
    }

    $prefix = get_multilanguage_prefix();
    $isDefault = get_default_language() == $newPrefix;

    if ($newPrefix) {
        if ($isDefault && $prefix) {
            return str_replace($prefix . '/', '', url()->current());
        }

        if ($prefix) {
            return str_replace($prefix, $newPrefix, url()->current());
        }

        return str_replace(url('/'), url('/' . $newPrefix), url()->current());
    }

    if ($prefix) {
        return url($prefix);
    }

    return url('/');
}

function get_buzzy_Locale()
{
    static $_locale;

    if (!empty($_locale)) {
        return $_locale;
    }

    if (get_multilanguage_routing_enabled()) {
        $locale = get_multilanguage_prefix();
    } else {
        $locale = Cookie::get('buzzy_locale');
    }

    $languages = get_available_languages();

    if (!$locale || !is_array($languages) || !array_key_exists($locale, $languages)) {
        $locale = get_default_language();
    }

    $_locale = $locale;

    return $locale;
}

function get_buzzy_query_locale()
{
    if (get_buzzy_config('p_multilanguage') === 'on') {
        return app()->getLocale();
    }

    return get_default_language();
}

function get_reaction_user_vote($post, $reaction_type, $user_reactions)
{
    if (!auth()->check() && get_buzzy_config('sitevoting') == "1") {
        return 'href=' . route('login') . ' rel="get:Loginform"';
    } elseif (in_array($reaction_type, $user_reactions)) {
        return 'class="off active" rel="nofollow"  href="javascript:void(0)"';
    } elseif (count($user_reactions) < get_buzzy_config('reaction_max_voting', 3)) {
        return 'class="postable" rel="nofollow"  href="javascript:void();" data-method="Post" data-target="reactions' . $post->id . '" data-href="' . route('reaction.vote', ['reactionIcon' => $reaction_type, 'post' => $post->id]) . '"';
    } else {
        return 'class="off" rel="nofollow"  href="javascript:void(0)"';
    }
}

function get_category_ids_recursively($category_id)
{
    $categories = [];
    $ids_array = [];

    if (is_array($category_id)) {
        $categories = Category::whereIn('id', $category_id)->get();
    } else {
        $categories = Arr::wrap(Category::find($category_id));
    }

    foreach ($categories as $category) {
        $ids_array[] = $category->id;
        $ids_array[] = get_category_ids_recursively($category->children()->pluck('id')->all());
    }

    if (!empty($ids_array)) {
        $ids_array = array_unique(Arr::flatten($ids_array), SORT_NUMERIC);
    }

    return $ids_array;
}

function get_category_all_childids_recursively($categories)
{
    $ids_array = [];
    if (!is_array($categories)) {
        $categories = [$categories];
    }

    foreach ($categories as $_category) {
        $ids_array[] = $_category->id;
        $ids_array[] = get_category_all_childids_recursively($_category->allChildrens->all());
    }

    if (!empty($ids_array)) {
        $ids_array = array_unique(Arr::flatten($ids_array), SORT_NUMERIC);
    }

    return $ids_array;
}

function generate_comment_url($comment, $admin = false)
{
    if ($admin) {
        return route('admin.comments',  ['type' => 'comment', 'comment_id' => $comment->id]);
    }

    if (!$comment->post) {
        return null;
    }

    return $comment->post->post_link . '#comment' . $comment->id;
}

/**
 * Translate the given message.
 *
 * @return object
 */
function get_current_comment_user()
{
    static $userData;

    if (!empty($userData)) {
        return $userData;
    }

    $data = new \stdClass();
    $data->CUSER = false;
    $data->usertype = null;
    $data->isAdmin = false;
    $data->authenticated = false;

    if (auth()->check()) {
        $data->authenticated = true;
        $user = request()->user()->toArray();
        foreach ($user as $key => $val) {
            if ($key === 'icon') {
                $data->{$key} = makepreview($val, 's', 'members/avatar');
            } else {
                $data->{$key} = $val;
            }
        }
        $data->isAdmin = request()->user()->isAdmin();
    } else {
        $data->id = null;
        $data->username = __("Guest");
        $data->icon = makepreview(null, 's', 'members/avatar');
        $data->link = '#';
    }

    $userData = $data;

    return $data;
}

function parse_comment_text($output)
{
    $output = strip_tags($output);

    $output = preg_replace('/(http[s]?:\/\/[^\s]*)/i', '<a href="$1" target="_blank" rel="nofollow">$1</a>', $output);

    $output = trim($output);

    return nl2br($output);
}

/**
 * Get most voted reaction for post
 *
 * @param $item
 */
function get_reaction_icon($item, $icon_count = 1)
{
    $most_reaction = \App\Reaction::with('reaction_icon')->select('reaction_type')
        ->where('post_id', $item->id)
        ->selectRaw('COUNT(*) AS count')
        ->groupBy('reaction_type')
        ->orderByDesc('count')
        ->limit($icon_count)
        ->get();

    if (!empty($most_reaction)) {
        foreach ($most_reaction as $vote) {
            if ($vote->count >  get_buzzy_config('showreactioniconon', 100) && $vote->reaction_icon) {
                $vote_route = route('reaction.show', ['reactionIcon' => $vote->reaction_type]);
                echo '<a href="' . $vote_route . '" class="badge"><div class="badge-img"><img src="' . $vote->reaction_icon->icon . '" width="32" height="32"></div></a>';
                return;
            }
        }
    }
}


/**
 * Show badges on posts
 *
 * @param $item
 */
function show_headline_posts($lastFeaturestop, $cat_style = false)
{
    if ($cat_style) {
        $op_name = 'CatHeadlineStyle';
    } else {
        $op_name = 'SiteHeadlineStyle';
    }
    $op_value = get_buzzy_theme_config($op_name, 1);

    if ($op_value && $op_value != 'off') {
        echo view('_particles.grid.style-' . $op_value, ['lastFeaturestop' => $lastFeaturestop])->render();
    }
}

/**
 * Get heali posts count
 *
 * @param $item
 */
function get_headline_posts_count($cat_style = false)
{

    if ($cat_style) {
        $op_name = 'CatHeadlineStyle';
    } else {
        $op_name = 'SiteHeadlineStyle';
    }
    $op_value = get_buzzy_theme_config($op_name);

    if ($op_value == 5) {
        return 2;
    } elseif ($op_value == 4) {
        return 4;
    } elseif ($op_value == 3) {
        return 3;
    } elseif ($op_value == 2) {
        return 10;
    } else {
        return 4;
    }

    return 0;
}

/**
 * Show badges on posts
 *
 * @param $item
 */
function parse_post_embed($url, $type = null)
{
    if (!$url) {
        return '';
    }

    // old versions
    if (strpos($url, 'iframe')) {
        return $url;
    }

    if ($type === 'facebookpost') {
        return '<div class="fb-post" data-href="' . $url . '" data-width="100%"></div>';
    } elseif ($type === 'instagram') {
        static $number;
        $c_number = $number++;
        return '<div class="embed-containera">
                <iframe id="instagram-embed-' . $c_number . '" src="' . $url . 'embed/captioned/?v=5" allowtransparency="true" frameborder="0" data-instgrm-payload-id="instagram-media-payload-' . $c_number . '" scrolling="no"></iframe>
                <script async defer src="//platform.instagram.com/' . get_buzzy_config("sitelanguage", "en_US") . '/embeds.js"></script>
            </div>';
    } elseif ($type === 'video' && in_array(substr($url, -3),  ['mp4', 'webm'])) {
        $c_number = uniqid();
        return '<div class="embed-containera">
                <video id="video-embed-' . $c_number . '" controls class="video-js" width="100%"><source src="' . $url . '" type="video/' . substr($url, -3) . '"></video>
            </div>';
    }

    try {
        $slug = Str::slug(htmlentities(urlencode($url)));
        $cached = Cache::get('embed_' . $slug);

        if ($cached) {
            return $cached;
        }
        $oembed = new Embed();
        $embed = $oembed->get($url);

        if ($embed && !empty($embed->code->html)) {
            Cache::put('embed_' . $slug, $embed->code->html, now()->addDays(1));
            return $embed->code->html;
        }
    } catch (\Exception $e) {
        //
    }

    return $url;
}

/**
 * Credit Wordpress
 *
 * https://github.com/WordPress/WordPress/blob/master/wp-includes/formatting.php
 *
 * @param string slug
 * @return string
 */
function remove_accents($string)
{
    if (!preg_match('/[\x80-\xff]/', $string)) {
        return $string;
    }

    $chars = array(
        // Decompositions for Latin-1 Supplement
        'ª' => 'a',
        'º' => 'o',
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Ä' => 'A',
        'Å' => 'A',
        'Æ' => 'AE',
        'Ç' => 'C',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ð' => 'D',
        'Ñ' => 'N',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ö' => 'O',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ü' => 'U',
        'Ý' => 'Y',
        'Þ' => 'TH',
        'ß' => 's',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'å' => 'a',
        'æ' => 'ae',
        'ç' => 'c',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ð' => 'd',
        'ñ' => 'n',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ø' => 'o',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ü' => 'u',
        'ý' => 'y',
        'þ' => 'th',
        'ÿ' => 'y',
        'Ø' => 'O',
        // Decompositions for Latin Extended-A
        'Ā' => 'A',
        'ā' => 'a',
        'Ă' => 'A',
        'ă' => 'a',
        'Ą' => 'A',
        'ą' => 'a',
        'Ć' => 'C',
        'ć' => 'c',
        'Ĉ' => 'C',
        'ĉ' => 'c',
        'Ċ' => 'C',
        'ċ' => 'c',
        'Č' => 'C',
        'č' => 'c',
        'Ď' => 'D',
        'ď' => 'd',
        'Đ' => 'D',
        'đ' => 'd',
        'Ē' => 'E',
        'ē' => 'e',
        'Ĕ' => 'E',
        'ĕ' => 'e',
        'Ė' => 'E',
        'ė' => 'e',
        'Ę' => 'E',
        'ę' => 'e',
        'Ě' => 'E',
        'ě' => 'e',
        'Ĝ' => 'G',
        'ĝ' => 'g',
        'Ğ' => 'G',
        'ğ' => 'g',
        'Ġ' => 'G',
        'ġ' => 'g',
        'Ģ' => 'G',
        'ģ' => 'g',
        'Ĥ' => 'H',
        'ĥ' => 'h',
        'Ħ' => 'H',
        'ħ' => 'h',
        'Ĩ' => 'I',
        'ĩ' => 'i',
        'Ī' => 'I',
        'ī' => 'i',
        'Ĭ' => 'I',
        'ĭ' => 'i',
        'Į' => 'I',
        'į' => 'i',
        'İ' => 'I',
        'ı' => 'i',
        'Ĳ' => 'IJ',
        'ĳ' => 'ij',
        'Ĵ' => 'J',
        'ĵ' => 'j',
        'Ķ' => 'K',
        'ķ' => 'k',
        'ĸ' => 'k',
        'Ĺ' => 'L',
        'ĺ' => 'l',
        'Ļ' => 'L',
        'ļ' => 'l',
        'Ľ' => 'L',
        'ľ' => 'l',
        'Ŀ' => 'L',
        'ŀ' => 'l',
        'Ł' => 'L',
        'ł' => 'l',
        'Ń' => 'N',
        'ń' => 'n',
        'Ņ' => 'N',
        'ņ' => 'n',
        'Ň' => 'N',
        'ň' => 'n',
        'ŉ' => 'n',
        'Ŋ' => 'N',
        'ŋ' => 'n',
        'Ō' => 'O',
        'ō' => 'o',
        'Ŏ' => 'O',
        'ŏ' => 'o',
        'Ő' => 'O',
        'ő' => 'o',
        'Œ' => 'OE',
        'œ' => 'oe',
        'Ŕ' => 'R',
        'ŕ' => 'r',
        'Ŗ' => 'R',
        'ŗ' => 'r',
        'Ř' => 'R',
        'ř' => 'r',
        'Ś' => 'S',
        'ś' => 's',
        'Ŝ' => 'S',
        'ŝ' => 's',
        'Ş' => 'S',
        'ş' => 's',
        'Š' => 'S',
        'š' => 's',
        'Ţ' => 'T',
        'ţ' => 't',
        'Ť' => 'T',
        'ť' => 't',
        'Ŧ' => 'T',
        'ŧ' => 't',
        'Ũ' => 'U',
        'ũ' => 'u',
        'Ū' => 'U',
        'ū' => 'u',
        'Ŭ' => 'U',
        'ŭ' => 'u',
        'Ů' => 'U',
        'ů' => 'u',
        'Ű' => 'U',
        'ű' => 'u',
        'Ų' => 'U',
        'ų' => 'u',
        'Ŵ' => 'W',
        'ŵ' => 'w',
        'Ŷ' => 'Y',
        'ŷ' => 'y',
        'Ÿ' => 'Y',
        'Ź' => 'Z',
        'ź' => 'z',
        'Ż' => 'Z',
        'ż' => 'z',
        'Ž' => 'Z',
        'ž' => 'z',
        'ſ' => 's',
        // Decompositions for Latin Extended-B
        'Ș' => 'S',
        'ș' => 's',
        'Ț' => 'T',
        'ț' => 't',
        // Euro Sign
        '€' => 'E',
        // GBP (Pound) Sign
        '£' => '',
        // Vowels with diacritic (Vietnamese)
        // unmarked
        'Ơ' => 'O',
        'ơ' => 'o',
        'Ư' => 'U',
        'ư' => 'u',
        // grave accent
        'Ầ' => 'A',
        'ầ' => 'a',
        'Ằ' => 'A',
        'ằ' => 'a',
        'Ề' => 'E',
        'ề' => 'e',
        'Ồ' => 'O',
        'ồ' => 'o',
        'Ờ' => 'O',
        'ờ' => 'o',
        'Ừ' => 'U',
        'ừ' => 'u',
        'Ỳ' => 'Y',
        'ỳ' => 'y',
        // hook
        'Ả' => 'A',
        'ả' => 'a',
        'Ẩ' => 'A',
        'ẩ' => 'a',
        'Ẳ' => 'A',
        'ẳ' => 'a',
        'Ẻ' => 'E',
        'ẻ' => 'e',
        'Ể' => 'E',
        'ể' => 'e',
        'Ỉ' => 'I',
        'ỉ' => 'i',
        'Ỏ' => 'O',
        'ỏ' => 'o',
        'Ổ' => 'O',
        'ổ' => 'o',
        'Ở' => 'O',
        'ở' => 'o',
        'Ủ' => 'U',
        'ủ' => 'u',
        'Ử' => 'U',
        'ử' => 'u',
        'Ỷ' => 'Y',
        'ỷ' => 'y',
        // tilde
        'Ẫ' => 'A',
        'ẫ' => 'a',
        'Ẵ' => 'A',
        'ẵ' => 'a',
        'Ẽ' => 'E',
        'ẽ' => 'e',
        'Ễ' => 'E',
        'ễ' => 'e',
        'Ỗ' => 'O',
        'ỗ' => 'o',
        'Ỡ' => 'O',
        'ỡ' => 'o',
        'Ữ' => 'U',
        'ữ' => 'u',
        'Ỹ' => 'Y',
        'ỹ' => 'y',
        // acute accent
        'Ấ' => 'A',
        'ấ' => 'a',
        'Ắ' => 'A',
        'ắ' => 'a',
        'Ế' => 'E',
        'ế' => 'e',
        'Ố' => 'O',
        'ố' => 'o',
        'Ớ' => 'O',
        'ớ' => 'o',
        'Ứ' => 'U',
        'ứ' => 'u',
        // dot below
        'Ạ' => 'A',
        'ạ' => 'a',
        'Ậ' => 'A',
        'ậ' => 'a',
        'Ặ' => 'A',
        'ặ' => 'a',
        'Ẹ' => 'E',
        'ẹ' => 'e',
        'Ệ' => 'E',
        'ệ' => 'e',
        'Ị' => 'I',
        'ị' => 'i',
        'Ọ' => 'O',
        'ọ' => 'o',
        'Ộ' => 'O',
        'ộ' => 'o',
        'Ợ' => 'O',
        'ợ' => 'o',
        'Ụ' => 'U',
        'ụ' => 'u',
        'Ự' => 'U',
        'ự' => 'u',
        'Ỵ' => 'Y',
        'ỵ' => 'y',
        // Vowels with diacritic (Chinese, Hanyu Pinyin)
        'ɑ' => 'a',
        // macron
        'Ǖ' => 'U',
        'ǖ' => 'u',
        // acute accent
        'Ǘ' => 'U',
        'ǘ' => 'u',
        // caron
        'Ǎ' => 'A',
        'ǎ' => 'a',
        'Ǐ' => 'I',
        'ǐ' => 'i',
        'Ǒ' => 'O',
        'ǒ' => 'o',
        'Ǔ' => 'U',
        'ǔ' => 'u',
        'Ǚ' => 'U',
        'ǚ' => 'u',
        // grave accent
        'Ǜ' => 'U',
        'ǜ' => 'u',
    );

    $chars['Ä'] = 'Ae';
    $chars['ä'] = 'ae';
    $chars['Ö'] = 'Oe';
    $chars['ö'] = 'oe';
    $chars['Ü'] = 'Ue';
    $chars['ü'] = 'ue';
    $chars['ß'] = 'ss';
    $chars['Æ'] = 'Ae';
    $chars['æ'] = 'ae';
    $chars['Ø'] = 'Oe';
    $chars['ø'] = 'oe';
    $chars['Å'] = 'Aa';
    $chars['å'] = 'aa';
    $chars['l·l'] = 'll';
    $chars['Đ'] = 'DJ';
    $chars['đ'] = 'dj';
    $string = strtr($string, $chars);

    return $string;
}

/**
 * Credit Wordpress
 *
 * https://github.com/WordPress/WordPress/blob/master/wp-includes/formatting.php
 *
 * @param string $title     The title to be sanitized.
 * @param string $context   Optional. The operation for which the string is sanitized.
 * @return string The sanitized title.
 */
function sanitize_title_with_dashes($title, $context = 'save')
{
    $title = remove_accents($title);
    $title = strip_tags($title);
    // Preserve escaped octets.
    $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
    // Remove percent signs that are not part of an octet.
    $title = str_replace('%', '', $title);
    // Restore octets.
    $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

    if (function_exists('mb_strtolower')) {
        $title = mb_strtolower($title, 'UTF-8');
    }

    $title = strtolower($title);

    if ('save' == $context) {
        // Convert nbsp, ndash and mdash to hyphens
        $title = str_replace(array('%c2%a0', '%e2%80%93', '%e2%80%94'), '-', $title);
        // Convert nbsp, ndash and mdash HTML entities to hyphens
        $title = str_replace(array('&nbsp;', '&#160;', '&ndash;', '&#8211;', '&mdash;', '&#8212;'), '-', $title);
        // Convert forward slash to hyphen
        $title = str_replace('/', '-', $title);

        // Strip these characters entirely
        $title = str_replace(
            array(
                // soft hyphens
                '%c2%ad',
                // iexcl and iquest
                '%c2%a1',
                '%c2%bf',
                // angle quotes
                '%c2%ab',
                '%c2%bb',
                '%e2%80%b9',
                '%e2%80%ba',
                // curly quotes
                '%e2%80%98',
                '%e2%80%99',
                '%e2%80%9c',
                '%e2%80%9d',
                '%e2%80%9a',
                '%e2%80%9b',
                '%e2%80%9e',
                '%e2%80%9f',
                // copy, reg, deg, hellip and trade
                '%c2%a9',
                '%c2%ae',
                '%c2%b0',
                '%e2%80%a6',
                '%e2%84%a2',
                // acute accents
                '%c2%b4',
                '%cb%8a',
                '%cc%81',
                '%cd%81',
                // grave accent, macron, caron
                '%cc%80',
                '%cc%84',
                '%cc%8c',
            ),
            '',
            $title
        );

        // Convert times to x
        $title = str_replace('%c3%97', 'x', $title);
    }

    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = str_replace('.', '-', $title);

    $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim($title, '-');

    $slug = Str::slug($title);

    if (!empty($slug)) {
        $title = $slug;
    }

    return $title;
}
