@extends("app")

@section('head_title', trans('buzzycontact.contact').' | '.get_buzzy_config('sitename') )
@section('body_class', "contact-page")
@section("content")

<div class="buzz-container">

    <div class="global-container container">
        <div class="content">
            <br>
            <h1>{{ trans('buzzycontact.contact') }}</h1>

            {!! Form::open(array('action' => 'ContactController@create', 'method' => 'POST','class' => 'form','name' =>
            'contactform', 'enctype' => 'multipart/form-data')) !!}

            <div class="form-field string  inpt">
                <label for="subject">{{ trans('buzzycontact.subject') }}</label>
                {!! Form::text('subject', null, ['id' => 'subject']) !!}
            </div>
            <div class="form-field text  inpt">
                <label for="description">{{ trans('buzzycontact.description') }}</label>
                {!! Form::textarea('text', null, ['id' => 'text', 'style' => 'height:125px']) !!}
                <p>{{ trans('buzzycontact.descriptioninfo') }}</p>
            </div>
            <div class="form-field string  inpt">
                <label for="name">{{ trans('buzzycontact.name') }}</label>
                {!! Form::text('name', isset(Auth::user()->username) ? Auth::user()->username : null, ['id' => 'name'])
                !!}
                <p>{{ trans('buzzycontact.nameinfo') }}</p>
            </div>
            <div class="form-field inpt">
                <label for="email">{{ trans('buzzycontact.email') }}</label>
                {!! Form::text('email', isset(Auth::user()->email) ? Auth::user()->email : null, ['id' => 'email']) !!}
            </div>

            <div class="form-field string  inpt">
                <label for="label">{{ trans('buzzycontact.label') }}</label>
                {!! Form::select('label', $labels, ['id' => 'label']) !!}
                <p>{{ trans('buzzycontact.labelinfo') }}</p>
            </div>
            @if(get_buzzy_config('BuzzyContactCaptcha')=="on")
            <div class="form-field inpt">
                <label>{{ trans('buzzycontact.areyouhuman') }}</label>
                <script src='https://www.google.com/recaptcha/api.js' async defer></script>
                <div class="g-recaptcha" data-sitekey="{{  get_buzzy_config('reCaptchaKey') }}"></div>
            </div>
            @endif

            {!! Form::submit(isset($post->id) ? trans('addpost.savec') : trans('buzzycontact.send'), ['class' => 'button
            button-orange button-full submit-button']) !!}

            {!! Form::close() !!}
        </div>
        <div class="sidebar">

            <div class="ads">
                @include('_particles.widget.ads', ['position' => 'CatSide', 'width' => '300', 'height' => '250'])

            </div>

            @include('_particles.widget.follow')
        </div>
    </div>
</div>


@endsection
