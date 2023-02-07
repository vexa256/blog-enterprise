@if(empty(request()->query('pid')))
<div class="content-comments">
    @if(get_buzzy_config('p_buzzycomment')=='on')
        @php($popularComments=app('App\Repositories\CommentRepository')->getPopular(['post_id' => $post->id]))
        @php($comments=app('App\Repositories\CommentRepository')->get(['post_id' => $post->id], $popularComments->pluck('id')))
        @include('comments.index', ['comments' => $comments, 'popularComments' => $popularComments])
    @endif

    @if(get_buzzy_config('p_easycomment')=='on')
    <!-- easyComment Content Div -->
    <div id="easyComment_Content"></div>
    <!-- easyComment -->
    <script type="text/javascript">
        // CONFIGURATION VARIABLES
        var easyComment_ContentID = 'Post_{{ $post->id }}';
        var easyComment_FooterLinks = 'Off'; // Disable footer links from the easyComment script for Buzzy Demo
        var easyComment_Language = '{{app()->getLocale()}}'; // Disable footer links from the easyComment script for Buzzy Demo

        /* * * DON'T EDIT BELOW THIS LINE * * */
        var easyComment_Theme = '{{ get_buzzy_config("easyCommentTheme", "Default") }}';
        var easyComment_Title = '{{ get_buzzy_config("easyCommentTitle", trans("index.conversations")) }}';

        var easyComment_userid = '{{ Auth::check() ? Auth::user()->id : '' }}';
        var easyComment_username = '{{ Auth::check() ? Auth::user()->username : '' }}';
        var easyComment_usericon = '{{ Auth::check() ? url(makepreview(Auth::user()->icon, "s", "members/avatar")) : url(makepreview('', "s", "members/avatar")) }}';
        var easyComment_profillink = '{{ Auth::check() ? Auth::user()->profile_link : '' }}';

        var easyComment_Domain = '{{ rtrim(get_buzzy_config("easyCommentcode", url("/comments")), "/") }}/';

        (function() {
            var EC = document.createElement('script');
            EC.type = 'text/javascript';
            EC.async = true;
            EC.src = easyComment_Domain + 'plugin/embed.js';

            (document.head || document.body).appendChild(EC);
        })();
    </script>
    @endif

    @if(get_buzzy_config('p_facebookcomments')=='on')
    <div class="colheader ">
        <h3 class="header-title">{{ trans('index.conversations') }}</h3>
    </div>
    <div class="fb-comments" ref="{{ $post->post_link }}" data-numposts="5" data-width="100%"></div>
    @endif

    @if(get_buzzy_config('p_disquscomments')=='on')
    <div class="colheader ">
        <h3 class="header-title">{{ trans('index.disqusconversations') }}</h3>
    </div>
    <div id="disqus_thread"></div>
    <script>
            var disqus_config = function () {
                this.page.url = "{{ $post->post_link }}";  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = "{{ $post->id }}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            (function() {
                var d = document, s = d.createElement('script');
                s.src = '//{!! get_buzzy_config("DisqussCommentcode") !!}.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
    </script>
    @endif
</div>
@endif
