@foreach($post->entries()->byType('quizquestion')->oldest("order")->get() as $key => $entry)
<section class="entry quizquestion selectableQuest" id="section_{{ $entry->order }}" data-entry="{{ $entry->id }}">
    @if($entry->title)
    <h2 class="sub-title">
    {{ $entry->title }}
    </h2>
    @endif

   @include('_particles.post._entries._entry_image')

   {!! $entry->body !!}

    <div class="clear"></div>
    <div class="answer">
      @include('_particles.post._entries._quiz_answers')
    </div>
    <div class="clear"></div>
</section>
@endforeach

<section class="entry results" id="quiz_result" data-popup="{{ get_buzzy_config('BuzzyQuizzesPopup') }}"
    data-qtype="{{ $post->ordertype }}">
    <div class="quiz_result_area">
        <h3 class="post-title">{{ $post->title }}</h3>
        @if($post->ordertype=='trivia' )
        <div id="triviaresult" class="quiz_result active hidden" data-link="{{ Request::url() }}" data-name="" data-iname=""
            data-itname="" data-description="{{ strip_tags($entry->body) }}"
            data-picture="{{ url(makepreview($post->thumb, 'b', 'posts')) }}">
            <h2 class="quiz_headline">{!! trans('buzzyquiz.triviaresult') !!}</h2>
        </div>
        @endif
        @include('_particles.post._entries._quiz_results', ['results' => $post->entries()->byType("quizresult")->oldest("order")->get()])
    </div>
    <div class="clear"></div>
    <div class="quiz_result_share">
        <h3 class="bold share_title">{{trans('buzzyquiz.shareresult') }}</h3>
        <div class="social_links">
            <a href="javascript:" class="social-facebook do-signup postToResultFeed">
                <img width="26px" src="{{asset('assets/images/social_icons/facebook.svg')}}"> {{trans('index.sharefacebook') }}
            </a>
            <a href="javascript:" class="social-twitter do-signup postToResultFeed">
                <img width="26px" src="{{asset('assets/images/social_icons/twitter.svg')}}"> {{trans('index.sharetweet') }}
            </a>
            <a href="javascript:" class="social-pinterest do-signup postToResultFeed">
               <img width="26px" src="{{asset('assets/images/social_icons/pinterest.svg')}}"> {{trans('index.sharepinterest') }}
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
</section>
