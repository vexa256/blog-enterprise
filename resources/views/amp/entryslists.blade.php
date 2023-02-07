@foreach ($entries as $key => $entry)
@unless($entry->type == 'poll')
@if ($entry->title)
<h3>
    <strong>
        @if ($post->ordertype != '')
        {{ $entry->order + 1 }}.
        @endif

        {{ $entry->title }}
    </strong>
</h3>
@endif

@if ($entry->type == 'image')
<p class="post-thumbnail">
    <amp-img alt src="{{ url(makepreview($entry->image, null, 'entries')) }}" width="1.1" height="1"
        layout="responsive"></amp-img>
</p>
@endif

@if ($entry->type == 'video')
@php($my_ar = explode('watch?v=', $entry->video))
@if(isset($my_ar[1]))
<p>
    <amp-youtube data-videoid="{{ $my_ar[1] }}" layout="responsive" width="480" height="270"></amp-youtube>
</p>
@endif
@php($my_ar = explode('dailymotion.com/video/', $entry->video))
@if(isset($my_ar[1]))
<p>
    <amp-dailymotion data-videoid="{{ $my_ar[1] }}" layout="responsive" width="480" height="270"></amp-dailymotion>
</p>
@endif
@php($my_ar = explode('vimeo.com/', $entry->video))
@if(isset($my_ar[1]))
<p>
    <amp-vimeo data-videoid="{{ $my_ar[1] }}" layout="responsive" width="480" height="270"></amp-vimeo>
</p>
@endif
@endif
@if ($entry->type == 'instagram')
@php($my_array_of_vars = explode('/', parse_url($entry->video, PHP_URL_PATH)))
@if(isset($my_array_of_vars['2']))
<p>
    <amp-instagram data-shortcode="{{ $my_array_of_vars['2'] }}" width="400" height="400" layout="responsive">
    </amp-instagram>
</p>
@endif
@endif

@if ($entry->type == 'tweet')
@php($my_ar = explode('status/', $entry->video))
@if(isset($my_ar[1]))
@php($my_ar = explode('">', $my_ar[1]))
@if(isset($my_ar[0]))
<p>
    <amp-twitter width=390 height=50 layout="responsive" data-tweetid="{{ $my_ar[0] }}"></amp-twitter>
</p>
@endif
@endif
@endif

@if (!empty($entry->body))
@php($content = preg_replace('/style=[^>]*/', '', $entry->body))
@php($content = preg_replace('/width=[^>]*/', '', $content))
@php($content = preg_replace('/color=[^>]*/', '', $content))
@php($content = preg_replace('/allowfullscreen=[^>]*/', '', $content))
@php($content = str_replace(array('<font', '/font>' , 'iframe' ,), array('<span', '/span>' , 'amp-iframe' ), $content))
@php($content = preg_replace('/<img .*? src="([^"]*)" .*?>/' , '<amp-img src="$1" width="1.1" height="1" layout="responsive" alt="AMP"></amp-img>' , $content))
@php($content = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 width="1.1" height="1" layout="responsive" alt="AMP"></amp-img>', $content))
<p>{!!$content!!}</p>
@endif

<p><small>{!! $entry->source !!}</small> </p>
@endunless
@endforeach
