 @php($class= $entry->video == "1" ? 'thdefault' : ($entry->video == "2" ? 'thlarge' : 'thlist'))
 @php($answers = $post->entries()->where('type', 'answer')->where('source', $entry->id)->get())
<ol class="option-selection {{$class}}">
    @foreach($answers as $keya => $answer)
    <?php $keya=$keya+1;?>
    <li>
        <a class="" href="javascript:" data-answer="{{ $answer->id }}" data-result="{{ $answer->video }}">
            <div class="answer-cover">
                @if($entry->video!='3')
                <img class=" lazyload responsive-img" alt="{{ $answer->title }}"
                    data-src="{{ url(makepreview($answer->image, null, 'answers')) }}">
                @endif
                <div class="option-sel">
                    <div class="buzz-icon buzz-answer-circle"></div>
                    <span class="option-text">
                        {!! $answer->title > "" ? $answer->title : '<br>' !!}
                    </span>
                </div>
            </div>
        </a>
        <div class="clear"></div>
    </li>
    @if(($keya%3)==0 and $entry->video=='1' or ($keya%2)==0 and $entry->video=='2' )
</ol>
<div class="clear"></div>
<ol class="option-selection {{$class}}">
    @endif
    @endforeach
</ol>
