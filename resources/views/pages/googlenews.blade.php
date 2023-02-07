<?php echo '<'.'?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    @foreach($posts as $post)
    <url>
        <loc>{{ $post->post_link }}</loc>
        <news:news>
            <news:publication>
                <news:name>{!! get_buzzy_config('sitename') !!}</news:name>
                <news:language>{{ $post->language }}</news:language>
            </news:publication>
            <news:genres>PressRelease</news:genres>
            <news:publication_date>{{ $post->published_at->toW3cString() }}</news:publication_date>
            <news:title>
                <![CDATA[ {!! $post->title !!} ]]>
            </news:title>
            <news:keywords>
                <![CDATA[ {!! $post->tags()->get()->implode('name', ',') !!} ]]>
            </news:keywords>
        </news:news>
    </url>
    @endforeach
</urlset>
