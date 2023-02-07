<div class="row">
    <div class="col-sm-12  col-md-8 col-lg-6">

        <div class="panel panel-danger">
            <div class="panel-heading">{{ trans('admin.AdvancedConfiguration') }}</div>
            <div class="panel-body form-horizontal">
                <legend>{{ trans('admin.HeadCode') }}</legend>
                <textarea name="headcode" rows="10" class="form-control">{!!   rawurldecode(get_buzzy_config('headcode')) !!}</textarea>
                <span class="help-block">{{ trans('admin.HeadCodehelp') }}</span>
                <br>
                <legend>{{ trans('admin.Footercode') }}</legend>
                <textarea name="footercode" rows="10" class="form-control">{!!    rawurldecode(get_buzzy_config('footercode')) !!}</textarea>
                <span class="help-block">{{ trans('admin.Footercodehelp') }}</span>

            </div>
        </div>

    </div><!-- /.col -->
</div><!-- /.row -->
