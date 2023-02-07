@php($class= $entry->video == "1" ? 'thdefault' : ($entry->video == "2" ? 'thlarge' : 'thlist'))
@php($answers= $post->entries()->where('type', 'answer')->where('source', $entry->id)->get())
<ol class="option-selection {{ $class }}">
    @foreach($answers as $keya => $answer)
        @php($keya=$keya+1)
        <li>
            @if(!Auth::check() && get_buzzy_config('sitevoting')=="1")
            <a  href="{{ url('/login') }}" rel="get:Loginform">
            @else
            @if($answer->vote()->VoteOnPost()->first())
            <a class="active"  href="#ok">
            @else
            @if($entry->pollvotes()->currentUserHasVoteOnPost($entry->id)->get()->first())
            <a class="off" href="#ok">
            @else
            <a class="postable"  data-method="Post" data-target="answerpoll{{ $entry->id  }}" href="{{ route('poll.vote', ['entry' => $entry->id, 'answer' => $answer->id] ) }}" rel="nofollow">
            @endif
            @endif
            @endif
            <div class="answer-cover">
                @if($entry->video!='3')
                    <img class="responsive-img" alt="{{ $answer->title }}" src="{{ makepreview($answer->image, null, 'answers') }}">
                @endif
                <div class="option-sel" >
                    <div class="buzz-icon buzz-answer-circle"></div>
                    <span  class="option-text">
                    {!!  $answer->title > "" ? $answer->title : '<br>' !!}
                    </span>
                </div>
            </div>

            @if($entry->pollvotes()->currentUserHasVoteOnPost($entry->id)->get()->first())
                <div class="meta">
                    <small>  {{ trans('updates.vote', ['count' => $answer->vote()->count()]) }} - </small>
                    {{$answer->vote()->count() ?  intval(($answer->vote()->count() / $entry->pollvotes()->count()) * 100, 2) : 0 }} %
                </div>
                <div class="result_bar">
                    <div class="poll_main_color result_bar_inner"  data-percent="{{$answer->vote()->count() ?  intval(($answer->vote()->count() / $entry->pollvotes()->count()) * 100, 2) : 0 }}"></div>
                </div>
            @endif
        </a>
        <div class="clear"></div>
    </li>
    @if(($keya%3)==0 && $entry->video=='1' || ($keya%2)==0 && $entry->video=='2' )
    </ol>
    <div class="clear"></div>
    <ol class="option-selection {{ $class }}">
    @endif
@endforeach
</ol>
