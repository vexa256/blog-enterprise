@extends("_admin.adminapp")
@section('header')
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet"
    href="{{ asset('assets/plugins/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ trans('admin.Pages') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li class="active">{{ trans('admin.Pages') }}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
          <div class="col-md-6">
            {!! Form::open(array('action' => 'Admin\PagesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
            <input type="hidden" name="id" value="{{ isset($page->id) ? $page->id : null }}">
            <div class="panel panel-info">
                <div class="panel-heading">{{ trans('admin.CreatePage') }}</div>
                <div class="panel-body">

                    <div class="form-group">
                        <label>{{ trans('admin.Title') }}</label>
                        <input type="text" name="title" class="form-control input-lg"
                            placeholder="{{ trans('admin.Title') }}"
                            value="{{ isset($page->title) ? $page->title : null }}">
                    </div>

                    <div class="form-group">
                        <label>{{ trans('admin.TitleSlug') }}</label>
                        <input type="text" name="slug" class="form-control input-lg"
                            placeholder="{{ trans('admin.TitleSlug') }}"
                            value="{{ isset($page->slug) ? $page->slug : null }}">
                    </div>

                    <div class="form-group">
                        <label>{{ trans('admin.Descriptiontag') }}</label>
                        <input type="text" name="description" class="form-control input-lg" placeholder=""
                            value="{{ isset($page->description) ? $page->description : null }}">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>{{ trans('admin.text') }}</label>
                        <textarea name="text" class="textarea" id="textarea"
                            placeholder="{{ trans('admin.Placesometexthere') }}">{{ isset($page->text) ? $page->text : null }}</textarea>
                    </div>

                </div>
            </div>

            <input type="submit"
                value="{{ isset($page->title) ? trans('admin.SaveChanges') : trans('admin.CreatePage') }}"
                class="btn btn-block btn-info btn-lg">
            {!! Form::close() !!}

        </div><!-- /.col -->
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin.AllPages') }} ({{ count($pages) }})</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.PageTitle') }}</th>
                                <th>{{ trans('admin.actions') }}</th>
                            </tr>
                            @foreach($pages as $key => $page)
                            <tr>
                                <td>{{ $key+1 }}.</td>
                                <td>{{ $page->title }} <a href="{{ route('page.show', ['page' => $page->slug]) }}" target="_blank"><i class="fa fa-external-link"></i></a></td>
                                <td>
                                    <a href="{{ route('admin.pages', ['edit' => $page->id]) }}" class="btn btn-sm btn-success" role="button"
                                        data-toggle="tooltip" data-original-title="{{ trans('admin.edit') }}"><i
                                            class="fa fa-edit"></i></a>
                                    <a class="btn btn-sm btn-danger permanently"
                                        href="{{ route('admin.pages.delete', ['page' => $page->id]) }}" role="button"
                                        data-toggle="tooltip" data-original-title="{{ trans('admin.delete') }}"><i
                                            class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

            </div>

        </div><!-- /.col -->
    </div><!-- /.row -->

</section>
@endsection
@section("footer")
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script>
(function ($) {
        "use strict";

          tinymce.init({
                selector: 'textarea',
                language: "{{ config('app.locale') }}",
                directionality: "{{ get_language_is_rtl(get_buzzy_locale()) ? 'rtl' : 'ltr' }}",
                images_upload_url:
                    "{!! route('upload_image_request', ['type' => 'page', 'path_key' => 'location', '_token' => csrf_token() ]) !!}",
                menubar: false,
                statusbar: false,
                min_height: 300,
                default_link_target: '_blank',
                plugins:
                    'save print preview importcss searchreplace autoresize autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons codeeditor',
                toolbar:
                    'formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist checklist | image media link |  undo redo | fontselect fontsizeselect | outdent indent | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak codesample | charmap emoticons | paste copy fullscreen preview print codeeditor',
                setup: function (editor) {
                    editor.on('change blur', function (e) {
                        editor.save();
                        tinymce.triggerSave();
                    });
                }
            });

  })(jQuery);
</script>
@endsection
