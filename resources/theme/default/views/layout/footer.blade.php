<div class="clear"></div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-1">
                @include('_particles.header.language_picker')
                @include('_particles.footer.logo')
            </div>
            <div class="col-3">
             <ul class="foot-menu">
                @foreach(\App\Page::where('footer', '1')->get() as $page)
                <li>
                    <a href="{{ route('page.show', ['page' => $page->slug]) }}" title="{{ $page->title }}">
                        {{ $page->title }}
                    </a>
                </li>
                @endforeach
                @if(get_buzzy_config('p_buzzycontact') == 'on')
                <li><a href="{{ action('ContactController@index') }}">{{ trans('buzzycontact.contact') }}</a></li>
                @endif
            </ul>
              <div class="clear"></div>
                 @include('_particles.footer.copyright')
            </div>
        </div>
        <div class="clear"></div>
    </div>
</footer>
