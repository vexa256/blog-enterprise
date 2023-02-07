<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">{{ trans('admin.MainConfiguration') }}</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.GoogleFontConfig') }}</label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="{{$config_prefix}}googlefont" value="{{  get_buzzy_config_by_theme($theme, 'googlefont', get_buzzy_config('googlefont')) }}">
                    </div>
                    <span class="help-block">{!!   trans('admin.GoogleFontConfighelp') !!} </span>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{ trans('admin.SiteFont') }} </label>
                    <div class="controls">
                        <input type="text" class="form-control input-lg" name="{{$config_prefix}}sitefontfamily" value="{{  get_buzzy_config_by_theme($theme, 'sitefontfamily', get_buzzy_config('sitefontfamily')) }}">
                    </div>
                    <span class="help-block">{{ trans('admin.SiteFonthelp') }} </span>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{ trans('v3half.homepageheadlinestyle') }}</label>
                    <div class="controls">
                        {!! Form::select($config_prefix.'SiteHeadlineStyle', ['1' => 'Style 1 - Boxes', '3' => 'Style 2 - Boxes', '4' => 'Style 3 - Tall Boxes', '5' => 'Style 4 - Two Big Boxes', '2' => 'Style 5 - Slider Type', 'off' => 'No Headline Post'], get_buzzy_config_by_theme($theme, 'SiteHeadlineStyle'), ['class' => 'form-control'])  !!}

                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label">{{ trans('v3half.categoryheadlinestyle') }}</label>
                    <div class="controls">
                        {!! Form::select($config_prefix.'CatHeadlineStyle', ['1' => 'Style 1 - Boxes', '3' => 'Style 2 - Boxes', '4' => 'Style 3 - Tall Boxes', '5' => 'Style 4 - Two Big Boxes', '2' => 'Style 5 - Slider Type', 'off' => 'No Headline Post'], get_buzzy_config_by_theme($theme, 'CatHeadlineStyle'), ['class' => 'form-control'])  !!}

                    </div>
                </div>
                <hr>
                 <div class="form-group">
                    <label class="control-label">{{ trans('v3half.postpageautoloadstyle') }}</label>
                    <div class="controls">
                        {!! Form::select($config_prefix.'PostPageAutoload', ['autoload' => 'Autoload Next Post', 'related' => 'Show only "You may also like" section', 'disabled' => trans('admin.Disabled')], get_buzzy_config_by_theme($theme, 'PostPageAutoload'), ['data-dependecy' => 'related_input', 'class' => 'form-control'])  !!}
                    </div>
                </div>
                <div class="form-group"  data-target="related_input" data-value="related">
                    <label class="control-label">{{ __('Related Content Filter') }}</label>
                    <div class="controls">
                        {!! Form::select($config_prefix.'PostRelatedType', ['tag' => 'by Tags', 'category' => 'by Categories'], get_buzzy_config_by_theme($theme, 'PostRelatedType'), ['class' => 'form-control'])  !!}
                    </div>
                </div>
                <hr>
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
                        <input type="text" name="{{$config_prefix}}BodyBC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'BodyBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config_by_theme($theme, 'BodyBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <hr>

                <div class="form-group">
                    <label>{{ trans('admin.NavbarBackgroundColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarBC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'NavbarBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <hr>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarTop3PixelBorderLineColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarTBLC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'NavbarTBLC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarTBLC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarLinkColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarLC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'NavbarLC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarLC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{{ trans('admin.NavbarLinkHoverColor') }}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarLHC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'NavbarLHC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarLHC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonBackgroundColor') !!}<</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarCBBC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'NavbarCBBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonFontColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarCBFC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'NavbarCBFC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBFC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonHoverBackgroundColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarCBHBC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'NavbarCBHBC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBHBC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label>{!! trans('admin.NavbarCreateButtonHoverFontColor') !!}</label>
                    <div class="input-group my-colorpicker2 colorpicker-element">
                        <input type="text" name="{{$config_prefix}}NavbarCBHFC" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'NavbarCBHFC') }}">
                        <div class="input-group-addon">
                            <i style="background-color: {{  get_buzzy_config('NavbarCBHFC') }};"></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <hr>
                <div class="form-group">
                    <label>{!! __('Logo Width') !!}</label>
                    <input type="number" name="{{$config_prefix}}LogoWidth" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'LogoWidth') }}">
                </div>
                <div class="form-group">
                    <label>{!! __('Footer Logo Width') !!}</label>
                    <input type="number" name="{{$config_prefix}}FooterLogoWidth" class="form-control" value="{{  get_buzzy_config_by_theme($theme, 'FooterLogoWidth') }}">
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
