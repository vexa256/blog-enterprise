<meta itemprop="mainEntityOfPage" content="{{ $post->post_link }}">
<meta itemprop="datePublished" content="{{ $post->published_at->toW3cString() }}" />
<meta itemprop="dateModified" content="{{ $post->created_at->toW3cString() }}" />
<meta itemprop="inLanguage" content="{{ get_buzzy_config('sitelanguage') }}" />
<meta itemprop="genre" content="news" name="medium" />
<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
    <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
        <meta itemprop="url" content="{{ asset(get_buzzy_config('sitelogo')) }}">
        <meta itemprop="width" content="400">
        <meta itemprop="height" content="60">
    </div>
    <meta itemprop="name" content={{ get_buzzy_config('sitename') }}>
</div>
