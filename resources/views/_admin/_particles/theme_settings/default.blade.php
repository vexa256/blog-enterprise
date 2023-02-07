<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">{{ trans('admin.MainConfiguration') }}</div>
            <div class="panel-body">
               <div class="form-group">
                    <label class="control-label">{{ trans('admin.GoogleFontConfig') }}</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="{{$config_prefix}}googlefont" value="{{  get_buzzy_config_by_theme($theme, 'googlefont',  get_buzzy_config('googlefont')) }}">
                    </div>
                    <span class="help-block">{!!   trans('admin.GoogleFontConfighelp') !!} </span>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.SiteFont') }} </label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="{{$config_prefix}}sitefontfamily" value="{{  get_buzzy_config_by_theme($theme, 'sitefontfamily',  get_buzzy_config('sitefontfamily')) }}">
                    </div>
                    <span class="help-block">{{ trans('admin.SiteFonthelp') }} </span>
                </div>
                <hr>
                <div class="form-group">
                    <label>{{ trans('admin.SiteLayoutType') }}</label>
                    {!! Form::select($config_prefix.'LayoutType', ['mode-wide' => trans('admin.Wide'),'mode-boxed' => trans('admin.Boxed')],  get_buzzy_config_by_theme($theme,'LayoutType'), ['class' => 'form-control'])  !!}

                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarType') }}</label>
                    {!! Form::select($config_prefix.'NavbarType', ['navbar-fixed' => trans('admin.Fixed'),'mode-relative' => trans('admin.Relative')],  get_buzzy_config_by_theme($theme,'NavbarType'), ['class' => 'form-control'])  !!}

                </div>
                <div class="form-group">
                    <label class="control-label">{{ trans('v3half.showpreviewimage') }}</label>
                    <div class="controls">
                        {!! Form::select($config_prefix.'PostPreviewShow', ['no' => trans('admin.no'), 'yes' => trans('admin.yes')], get_buzzy_config_by_theme($theme, 'PostPreviewShow'), ['class' => 'form-control'])  !!}
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label>{{ trans('admin.SiteBackgroundColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}BodyBC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'BodyBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'BodyBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.SiteBackgroundColorOnBoxedMode') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}BodyBCBM" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'BodyBCBM') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'BodyBCBM') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <hr>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarBackgroundColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarBC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'NavbarBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'NavbarBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarTop3PixelBorderLineColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarTBLC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'NavbarTBLC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'NavbarTBLC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarLinkColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarLC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'NavbarLC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'NavbarLC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarLinkHoverColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarLHC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'NavbarLHC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'NavbarLHC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonBackgroundColor') !!}<</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarCBBC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'NavbarCBBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'NavbarCBBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonFontColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarCBFC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'NavbarCBFC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'NavbarCBFC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonHoverBackgroundColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarCBHBC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'NavbarCBHBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'NavbarCBHBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonHoverFontColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarCBHFC" class="form-control" value="{{   get_buzzy_config_by_theme($theme,'NavbarCBHFC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{   get_buzzy_config_by_theme($theme,'NavbarCBHFC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>

            </div>
        </div>

    </div><!-- /.col -->

</div><!-- /.row -->

<div class="row">
    <div class="col-sm-12  col-md-8 col-lg-6">
        <div class="panel panel-danger">
            <div class="panel-heading">{{ trans('admin.AdvancedConfiguration') }}
                <div class="badge" data-toggle="tooltip" data-original-title="{{ trans('v3half.onlyforthemetitle') }}">
                    {{ trans('v3half.onlyfortheme') }}
                </div>
            </div>
            <div class="panel-body form-horizontal">
                <legend>{{ trans('admin.HeadCode') }}</legend>
                <textarea name="{{$config_prefix}}headcode" rows="8" class="form-control">{!! rawurldecode(get_buzzy_config_by_theme($theme, 'headcode')) !!}</textarea>
                <span class="help-block">{{ trans('admin.HeadCodehelp') }}</span>
                <br>
                <legend>{{ trans('admin.Footercode') }}</legend>
                <textarea name="{{$config_prefix}}footercode" rows="8" class="form-control">{!! rawurldecode(get_buzzy_config_by_theme($theme, 'footercode')) !!}</textarea>
                <span class="help-block">{{ trans('admin.Footercodehelp') }}</span>
            </div>
        </div>
    </div><!-- /.col -->
</div><!-- /.row -->
