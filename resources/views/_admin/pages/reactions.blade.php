@extends("_admin.adminapp")
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{__('Reactions')}}
        @if(get_multilanguage_enabled())
        &nbsp;>&nbsp; {!! get_language_list(get_buzzy_locale()) !!}
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li class="active">{{__('Reactions')}}</li>
    </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ isset($reaction->id) ? __('Edit Reaction:').$reaction->name : __('Add Reaction Icon') }}</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(array('action' => array('Admin\ReactionController@addnew'), 'method' => 'POST', 'enctype'
                => 'multipart/form-data')) !!}
                <div class="box-body">
                    <input type="hidden" name="id" value="{{ isset($reaction->id) ? $reaction->id : null }}">
                    <div class="form-group">
                        {!! Form::label('ord', __('Order')) !!}
                        {!! Form::text('ord', isset($reaction->ord) ? $reaction->ord : null, ['id' => 'ord', 'class' =>
                        'form-control input-lg']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', __('Name')) !!}
                        {!! Form::text('name', isset($reaction->name) ? $reaction->name : null, ['id' => 'name', 'class'
                        => 'form-control input-lg']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('reaction_type', trans('admin.Slug').' (Unique ID)') !!}
                        {!! Form::text('reaction_type', isset($reaction->reaction_type) ? $reaction->reaction_type :
                        null, ['id' => 'slug', 'class' => 'form-control input-lg']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('icon', __('Icon')) !!}
                        {!! Form::file('icon', ['id' => 'icon', 'class' => 'form-control input-lg']) !!}
                    </div>
                    @if(get_multilanguage_enabled())
                    <div class="form-group">
                        <label for="add_menu_item_custom_class"
                            class="cs-label">{{__('Language')}}</label>
                        {!! Form::select('language', get_buzzy_language_list_options(), ! empty($category->language) ?
                        $category->language : request()->query('lang', app()->getLocale()) , [
                        "id"=>"changeLanguage",
                        'id' => 'add_menu_item_language', 'class' => 'form-control input-field mb-2']) !!}
                    </div>
                    @endif
                    <div class="form-group">
                        {!! Form::label('display',trans('admin.Display')) !!}
                        {!! Form::select('display', ['on' => trans('admin.on'),'off' => trans('admin.off')],
                        isset($reaction->display) ? $reaction->display : null , ['class' => 'form-control']) !!}
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">{{ trans('admin.Submit') }}</button>
                    <a href="{{route('admin.reactions')}}" class="btn btn-default pull-right">{{ trans('admin.Cancel') }}</a>
                </div>
                {!! Form::close() !!}
            </div>

        </div><!-- /.col -->
        <div class="col-md-7">
            <div class="row">
                @foreach($reactions as $react)
                <div class="col-md-4 col-sm-3 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"> <img alt="{{ $react->name }}" src="{{ url($react->icon) }} " width="50"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ $react->ord }}.</span>
                            <span class="info-box-number">{{ $react->name }}</span>
                            <span class="info-box-text">
                                <a href="{{ route('admin.reactions', ['edit' => $react->id]) }}" data-toggle="tooltip"
                                    data-original-title="{{ trans('admin.Edit') }}" class="btn btn-box-tool btn-info">
                                    <i class="fa fa-edit"></i></a>
                                <a href="{{ action('Admin\ReactionController@delete', ['id' => $react->id]) }}" data-toggle="tooltip"
                                    data-original-title="{{ trans('admin.delete') }}"
                                    class="btn btn-box-tool btn-danger permanently">
                                    <i class="fa fa-times"></i></a>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                @endforeach
            </div>
        </div><!-- /.col -->

    </div><!-- /.row -->

</section>
@endsection
