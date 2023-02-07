<title>@yield('head_title', get_buzzy_config('sitetitle'))</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))" />
<meta name="keywords" content="@yield('head_keywords', get_buzzy_config('sitemetakeywords'))" />
<meta property="fb:app_id" content="{{  get_buzzy_config('facebookapp') }}" />
<meta property="og:type" content="@yield('og_type',  'website')" />
<meta property="og:site_name" content="{{  str_replace(' ', '', get_buzzy_config('sitename')) }}" />
<meta property="og:title" content="@yield('head_title',  get_buzzy_config('sitetitle'))" />
<meta property="og:description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))" />
<meta property="og:url" content="@yield('head_url', url('/'))" />
<meta property="og:locale" content="{{  get_buzzy_config('sitelanguage') }}">
<meta property="og:image" content="@yield('head_image', asset(get_buzzy_config('sitelogo')))" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ str_replace(' ', '', get_buzzy_config('sitename')) }}" />
<meta name="twitter:title" content="@yield('head_title',  get_buzzy_config('sitetitle'))" />
<meta name="twitter:url" content="@yield('head_url', url('/'))" />
<meta name="twitter:description" content="@yield('head_description', get_buzzy_config('sitemetadesc'))" />
<meta name="twitter:image" content="@yield('head_image', asset(get_buzzy_config('sitelogo')))" />
<link rel="shortcut icon" href="{{ asset(get_buzzy_config('favicon')) }}" />
