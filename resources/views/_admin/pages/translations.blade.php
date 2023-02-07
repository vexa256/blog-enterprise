@extends("_admin.adminapp")

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ __('Translations') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li class="active"> {{ __('Translations') }}</li>
    </ol>
</section>
<section class="content translations">
    <div class="row">
        <div class="col-md-3">

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __("Languages") }}</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="dd box-body no-padding" id="nestlangs" data-url="{{ action('Admin\TranslationController@sort') }}">
                    <ol class="dd-list nav nav-pills nav-stacked">
                        @foreach(\App\Language::active()->orderBy('order')->get() as $i => $lang)
                        <li class="dd-item {{ $locale==$lang->code ? 'active' : ""}}" data-order="{{$lang->order}}"
                            data-id="{{$lang->id}}">
                            <a href="{{ route('admin.translations', ['locale' => $lang->code]) }}">
                                {{ trans($lang->name) }}
                                @if($lang->direction == 'rtl')
                                <span class="label label-success">RTL</span>
                                @endif
                                @if($lang->code == get_default_language())
                                <span class="label label-danger">{{trans('admin.SiteLanguage')}}</span>
                                @endif
                            </a>
                            <div class="lang-actions">
                                <a href="{{ action('Admin\TranslationController@lock', ['locale' => $lang->code]) }}"
                                    class="label label-primary language_lock pull-right" data-toggle="tooltip" data-original-title="{{trans('admin.Deactivate')}}">
                                    <i class="fa fa-lock"></i>
                                </a>
                                <div class="label label-warning dd-handle pull-right mr-5" data-toggle="tooltip" data-original-title="{{__('Order')}}">
                                    <i class="fa fa-arrows-alt"></i>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ol>
                </div><!-- /.box-body -->
            </div><!-- /. box -->

            <div class="box box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __("Disabled Languages") }}</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding" id="nestlangs2">
                    <ul class="dd-list nav nav-pills nav-stacked">
                        @foreach(\App\Language::where('active', 0)->orderBy('code')->get() as $i => $lang)
                        <li class="dd-item {{ $locale==$lang->code ? 'active' : ""}}">
                            <a href="{{ route('admin.translations', ['locale' => $lang->code]) }}">
                                {{ trans($lang->name) }}
                                @if($lang->direction == 'rtl')
                                <span class="label label-success">RTL</span>
                                @endif
                            </a>
                            <div class="lang-actions">
                                <a href="{{ action('Admin\TranslationController@lock', ['locale' => $lang->code]) }}"
                                    class="label label-primary language_lock pull-right cursor-pointer" data-toggle="tooltip" data-original-title="{{__('Activate')}}">
                                    <i class="fa fa-unlock"></i>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
        </div>
        <div class="col-md-9">

            <div class="box ">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i>
                        <b>{{ trans('admin.edit') }} : {{ trans($current_language->name) }}</b>
                        @if($locale != 'en')<span class="color-gray">({{$trans_count}}/{{$total_count}})</span>@endif
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('admin.translations', ['locale' => $current_language->code]) }}/send" class="btn btn-sm btn-success send_translation" data-toggle="tooltip" data-placement="bottom" data-original-title="{{__('Help the Community! If you fixed a word or if you have a better translation for a phrase feel free to share it with the community.')}}">
                            {{__('Send Translation')}}
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @if(count($translations))
                    <form action="{{ route('admin.translations', ['locale' => $locale]) }}" method="post" class="post_form">
                        @csrf
                        <fieldset>
                            @foreach($translations as $slug => $translation)
                            <div class="form-group clearfix {{!$translation['is_translated'] ? 'has-warning' : ''}}">
                                <label class="control-label col-sm-4"
                                    for="{{$slug}}">{{ $translation['default'] }}</label>
                                <div class="controls col-sm-8">
                                    <input type="text" class="form-control" @if($current_language->direction ==
                                    'rtl')dir="rtl"@endif id="{{$slug}}" name="{{$slug}}"
                                    value="{{$translation['translation']}}">
                                </div> <!-- /controls -->
                            </div> <!-- /form-group -->
                            <hr />
                            @endforeach

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-lg translation-save">{{__('Save')}}</button>
                            </div> <!-- /form-actions -->
                        </fieldset>
                    </form>
                    @endif
                </div>
            </div>

        </div> <!-- /spa12 -->
    </div> <!-- /row -->
</section>

@endsection
@section('footer')
<script src="{{ asset('assets/plugins/adminlte/plugins/nestable/jquery.nestable.min.js') }}"></script>
@endsection
