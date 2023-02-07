<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title>
            <![CDATA[  {!! get_buzzy_config('sitetitle') !!}   ]]>
        </title>
        <link>{{ url('/') }}</link>
        <description>
            <![CDATA[  {!! get_buzzy_config('sitemetadesc') !!}   ]]>
        </description>
        <language>{!! strtolower(str_replace('_', '-', get_buzzy_config('sitelanguage', 'en_US'))) !!}</language>
        <lastBuildDate>
            {{ $posts->first() ? $posts->first()->published_at->toRfc2822String() : now()->toRfc2822String() }}
        </lastBuildDate>

        @foreach($posts as $post)
        <item>
            <title>
                <![CDATA[  {!!  $post->title !!}   ]]>
            </title>
            <link>{{ url($post->post_link) }}</link>
            <description>
                <![CDATA[ {!! $post->body !!}  ]]>
            </description>
            <author>
                <![CDATA[  {!!  $post->user->email !!} ({!!  $post->user->username !!}) ]]>
            </author>
            <guid isPermaLink="false">{{ url($post->post_link) }}</guid>
            <pubDate>{{ $post->published_at->toRfc2822String() }}</pubDate>
            <content:encoded>
                <![CDATA[
                    <html lang="en" prefix="op: http://media.facebook.com/op#">
                    <head>
                        <meta charset="utf-8">
                        <link rel="canonical" href="{{ url($post->post_link) }}">
                        <meta property="op:markup_version" content="v1.0">
                    </head>
                    <body>
                    <article>
                        <header>
                            <figure>
                                <img src="{{ url(makepreview($post->thumb, 'b', 'posts')) }}" />
                            </figure>
                            <h1> {!!  $post->title !!} </h1>

                            <h3 class="op-kicker">
                               {!! $post->body !!}
                            </h3>

                            <time class="op-published" dateTime="{{ $post->published_at->toW3cString() }}">{{ $post->published_at->diffForHumans() }}</time>
                            <time class="op-modified" dateTime="{{ $post->updated_at->toW3cString() }}">{{ $post->updated_at->diffForHumans() }}</time>
                        </header>

                        @foreach($post->entries()->get() as $entry)
                            @if($entry->title)
                                <h2>@if($post->ordertype != '') {{ $entry->order+1 }}. @endif {{ $entry->title }}</h2>
                            @endif
                            @if(!empty($entry->image))
                                <figure data-feedback="fb:likes,fb:comments">
                                    <img src="{{ url(makepreview($entry->image, null, 'entries')) }}"/>
                                    @if( $entry->type=='text')
                                    <figcaption class="op-vertical-center">
                                            {!! $entry->source !!}
                                    </figcaption>
                                    @endif
                                </figure>
                            @endif
                            @if($entry->type=='video' or $entry->type=='facebookpost' or $entry->type=='embed' or $entry->type=='soundcloud')
                                 <figure class="op-interactive">
                                    {!! $entry->video !!}
                                </figure>
                            @endif
                            @if($entry->type=='tweet')
                                    {!! $entry->video !!}
                            @endif
                            @if( $entry->type=='instagram')
                               <figure class="op-interactive">
                                <iframe id="instagram-embed-{{ $entry->order }}" width="100%" height="100%" src="{!! $entry->video !!}embed/captioned/?v=5" allowtransparency="true" frameborder="0" data-instgrm-payload-id="instagram-media-payload-{{ $entry->order }}" scrolling="no"></iframe>
                               </figure>
                            @endif

                           @if(!empty($entry->body))
                            <p>{!! $entry->body !!}</p>
                           @endif

                            @if( $entry->type=='text')
                                <small>{!! $entry->source !!}</small>
                            @endif
                       @endforeach

                        <footer>
                            <aside>
                                <small>{!! trans("updates.copyright", ['year' => now()->format('Y'), 'sitename'=>
                get_buzzy_config('sitename')]) !!}</small>
                            </aside>
                        </footer>
                    </article>
                    </body>
                    </html>
                    ]]>
            </content:encoded>
        </item>
        @endforeach
    </channel>
</rss>
