<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Buzzy Theme Configuration
    |--------------------------------------------------------------------------
    */
    'version' => '4.9.0',
    'item_id' => 13300279,
    'item_code' => 'buzzy',

    /*
    |--------------------------------------------------------------------------
    | Buzzy Themes
    |--------------------------------------------------------------------------
    */
    "themes"  => [
        "modern" => [
            'version' => '4.9.0',
        ],
        "buzzyfeed" => [
            'version' => '4.9.0',
        ],
        "viralmag" => [
            'version' => '4.9.0',
        ],
        "boxed" => [
            'version' => '4.9.0',
        ],
        "default" => [
            'version' => '4.9.0',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Buzzy Plugins
    |--------------------------------------------------------------------------
    */
    "plugins"  => [
        "buzzynews" => [
            'version' => '4.9.0',
        ],
        "buzzylists" => [
            'version' => '4.9.0',
        ],
        "buzzyvideos" => [
            'version' => '4.9.0',
        ],
        "buzzypolls" => [
            'version' => '4.9.0',
        ],
        "buzzycomment" => [
            'version' => '1.0.0',
        ],
        "facebookcomments" => [
            'version' => '1.0.0',
        ],
        "disquscomments" => [
            'version' => '1.0.0',
        ],
        "amp" => [
            'version' => '1.0.0',
        ],
        "homepagebuilder" => [
            'version' => '1.0.0',
        ],
        "reactionform" => [
            'version' => '1.0.0',
        ],
        "multilanguage" => [
            'version' => '1.0.0',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Buzzy Post Types
    |--------------------------------------------------------------------------
    */
    "post_types" => [
        'news' => ['name' => 'news', 'icon' => 'file-text', 'trans' => 'v3.story'],
        'list' => ['name' => 'List', 'icon' => 'sort-numeric-asc', 'trans' => 'index.list'],
        'quiz' => ['name' => 'Quiz', 'icon' => 'check-square-o', 'trans' => 'index.quiz'],
        'poll' => ['name' => 'Poll', 'icon' => 'check-circle-o', 'trans' => 'index.poll'],
        'video' => ['name' => 'Quiz', 'icon' => 'video-camera', 'trans' => 'index.video'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Buzzy Menu Locations
    |--------------------------------------------------------------------------
    */
    "menus" => [
        'main-menu' => ['depth' => 2],
        'mobile-menu' => ['depth' => 1],
        'mega-menu' => ['depth' => 1],
        'footer-menu' => ['depth' => 1],
    ],

    /*
    |--------------------------------------------------------------------------
    | Buzzy Socail Links
    |--------------------------------------------------------------------------
    */
    "social_links" => [
        'facebook' => ['name' => 'Facebook', 'icon' => '/assets/images/social_icons/facebook.svg', 'trans' => 'follow_us_on', 'color' => '#1877f2'],
        'twitter' => ['name' => 'Twitter', 'icon' => '/assets/images/social_icons/twitter.svg', 'trans' => 'follow_us_on', 'color' => '#1da1f2'],
        'youtube' => ['name' => 'Youtube', 'icon' => '/assets/images/social_icons/youtube.svg', 'trans' => 'subscribe_us_on', 'color' => '#d30005'],
        'instagram' => ['name' => 'Instagram', 'icon' => '/assets/images/social_icons/instagram.svg', 'trans' => 'follow_us_on', 'color' => '#7251c3'],
        'pinterest' => ['name' => 'Pinterest', 'icon' => '/assets/images/social_icons/pinterest.svg', 'trans' => 'join_us_on', 'color' => '#d30005'],
        'steam' => ['name' => 'Steam', 'icon' => '/assets/images/social_icons/steam.svg', 'trans' => 'join_us_on', 'color' => '#333'],
        'reddit' => ['name' => 'Reddit', 'icon' => '/assets/images/social_icons/reddit.svg', 'trans' => 'follow_us_on', 'color' => '#f40'],
        'tumblr' => ['name' => 'Tumblr', 'icon' => '/assets/images/social_icons/tumblr.svg', 'trans' => 'follow_us_on', 'color' => '#35465c'],
        'flickr' => ['name' => 'Flickr', 'icon' => '/assets/images/social_icons/flickr.svg', 'trans' => 'follow_us_on', 'color' => '#0063dc'],
        'discord' => ['name' => 'Discord', 'icon' => '/assets/images/social_icons/discord.svg', 'trans' => 'join_us_on', 'color' => '#7289da'],
        'twitch' => ['name' => 'Twitch', 'icon' => '/assets/images/social_icons/twitch.svg', 'trans' => 'follow_us_on', 'color' => '#6441a4'],
        'snapchat' => ['name' => 'Snapchat', 'icon' => '/assets/images/social_icons/snapchat.svg', 'trans' => 'follow_us_on', 'color' => '#fffc00'],
        'stumbleupon' => ['name' => 'Stumbleupon', 'icon' => '/assets/images/social_icons/stumbleupon.svg', 'trans' => 'follow_us_on', 'color' => '#ea4b24'],
        'soundcloud' => ['name' => 'Soundcloud', 'icon' => '/assets/images/social_icons/soundcloud.svg', 'trans' => 'follow_us_on', 'color' => '#f50'],
        'spotify' => ['name' => 'Spotify', 'icon' => '/assets/images/social_icons/spotify.svg', 'trans' => 'follow_us_on', 'color' => '#3bd75f'],
        'behance' => ['name' => 'Behance', 'icon' => '/assets/images/social_icons/behance.svg', 'trans' => 'follow_us_on', 'color' => '#4175fa'],
        'blogger' => ['name' => 'Blogger', 'icon' => '/assets/images/social_icons/blogger.svg', 'trans' => 'follow_us_on', 'color' => '#FF5722'],
        'patreon' => ['name' => 'Patreon', 'icon' => '/assets/images/social_icons/patreon.svg', 'trans' => 'support_us_on', 'color' => '#052d49'],
        'paypal' => ['name' => 'Paypal', 'icon' => '/assets/images/social_icons/paypal.svg', 'trans' => 'support_us_on', 'color' => '#002c8a'],
        'linkedin' => ['name' => 'Linkedin', 'icon' => '/assets/images/social_icons/linkedin.svg', 'trans' => 'follow_us_on', 'color' => '#0077b5'],
        'telegram' => ['name' => 'Telegram', 'icon' => '/assets/images/social_icons/telegram.svg', 'trans' => 'follow_us_on', 'color' => '#37aee2'],
        'tiktok' => ['name' => 'Tiktok', 'icon' => '/assets/images/social_icons/tiktok.svg', 'trans' => 'follow_us_on', 'color' => '#ff004f'],
        'vimeo' => ['name' => 'Vimeo', 'icon' => '/assets/images/social_icons/vimeo.svg', 'trans' => 'subscribe_us_on', 'color' => '#1eb8eb'],
        'line' => ['name' => 'Line', 'icon' => '/assets/images/social_icons/line.svg', 'trans' => 'follow_us_on', 'color' => '#00B900'],
        'whatsapp' => ['name' => 'Whatsapp', 'icon' => '/assets/images/social_icons/whatsapp.svg', 'trans' => 'follow_us_on', 'color' => '#25d366'],
        'ok' => ['name' => 'OK', 'icon' => '/assets/images/social_icons/ok.svg', 'trans' => 'follow_us_on', 'color' => '#EE8208'],
        'vk' => ['name' => 'VK', 'icon' => '/assets/images/social_icons/vk.svg', 'trans' => 'follow_us_on', 'color' => '#5281b8'],
        'rss' => ['name' => 'RSS', 'icon' => '/assets/images/social_icons/rss.svg', 'trans' => 'follow_us_on', 'color' => '#f80'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Last published version
    |--------------------------------------------------------------------------
    |
    | This is where you can specify the last version of your application
    | This is used to determine if the application requires an update
    | The current running version is stored in framework/installed
    |
    */
    'upgrade' => [
        'migrations' => true,
        'seeds' => [
            'Database\Seeders\V49PostStatsSeeder',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'requirements' => [
        'openssl',
        'pdo',
        'gd',
        'zip',
        'mbstring',
        'fileinfo',
        'tokenizer'
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'public/upload/',
        'storage/app/',
        'storage/framework/',
        'storage/logs/',
        'bootstrap/cache/',
        '.env'
    ]
];
