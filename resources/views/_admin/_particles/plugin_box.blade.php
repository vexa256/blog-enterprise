<div class="box box-widget widget-user widget-plugin">
    <div class="overlay hide">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-default">
        <h3 class="widget-user-username">{{ $name }}</h3>
        <h5 class="widget-user-desc"">{!! $desc !!} </h5>
        <div class="info">
            {!! $weblink == null ? '' : '<a href="'.$weblink.'" target="_blank"><i class="fa fa-globe"></i> Web site</a>' !!}
            {!! $docslink == null ? '' : '<a href="'.$docslink.'" target="_blank"><i class="fa fa-book"></i> '.trans("admin.Docs").'</a>' !!}
            @if($price!='soon' && !empty($current_version))<span class="text-gray">v.{{ $current_version }}</span>@endif
        </div>
    </div>
    <div class="widget-user-image">
        <img class="img-circle" src="{{ $icon }}" alt="{{ $name }}">
    </div>

    <div class="box-footer">
        <div class="row">
            <div class="col-sm-9 item-actions" data-item-code="{{ $code }}" data-item-id="{{ $item_id }}"
                data-item-type="plugin">
                @unless($price=='soon')
                @if($activation_requied)
                <a href="javascript:;" data-item-id="{{ $item_id }}" data-item-name="{{ $name }}" data-item-buy="{{ $buylink }}" data-item-img="{{ $icon }}" class="btn btn-warning btn-sm pull-left register-item">
                    <i class="fa fa-unlock mr-5"></i> {{ trans('admin.ActivateCode') }}
                </a>
                @if($buylink != null)
                <a href="{{ $buylink }}" class="btn btn-success pull-left btn-sm" target="_blank">
                    <i class="fa fa-cart-plus mr-5"></i> {{ trans("admin.BuyNow") }}
                </a>
                @endif
                @elseif(!$instaled)
                <button type="button" class="btn btn-info btn-sm pull-left download-item" data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-version="{{ $version }}">
                    <i class="fa fa-check mr-5"></i> {{ trans('admin.download') }}
                </button>
                @elseif($update_required)
                <button type="button" class="btn btn-success btn-sm pull-left download-item" data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-version="{{ $version }}">
                    <i class="fa fa-download mr-5"></i>  {{ trans('admin.download') }}
                    v.{{$version}}
                </button>
                @elseif($active)
                <button type="button" class="btn btn-default btn-sm pull-left activate-item acthover">
                    <span class="current show"><i class="fa fa-check mr-5"></i> {{ trans('admin.Activated') }}</span>
                    <span class="hover hide"><i class="fa fa-remove mr-5"></i> {{ trans('admin.Deactivate') }}</span>
                </button>
                @if($settingon)
                <button type="button" class="btn btn-warning btn-sm pull-left" data-toggle="modal" data-target="#modal{{$code}}">
                    <i class="fa fa-cog"></i>
                </button>
                @endif
                @else
                <button type="button" class="btn btn-info btn-sm pull-left activate-item">
                    <i class="fa fa-download mr-5"></i> {{ trans('admin.Install') }}
                </button>
                @endif
                @endunless
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <div class="col-sm-3" >
                @if($price=='soon')
                <span class="badge bg-white pull-right mr-10">{!! trans("admin.Notavailabeyet") !!}</span>
                @elseif($price=='FREE')
                <span class="badge bg-white pull-right mr-10">{!! trans("admin.FREE") !!}</span>
                @else
                <span class="badge bg-green pull-right mr-10">{{ $price }}</span>
                @endif
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    @if($settingon)
    <div class="modal modal-info" id="modal{{$code}}">
        <div class="modal-dialog {{$code=="homepagebuilder" ? 'full' : ''}}">
            <div class="modal-content">
                {!! Form::open(array('action' => 'Admin\ConfigController@setconfig', 'method' => 'POST','style' =>
                'height:100%;', 'enctype' => 'multipart/form-data')) !!}
                @include('_admin._particles.plugin_settings.'. $code)
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{!!
                        trans("admin.close") !!}</button>
                    <input type="submit" value="{{trans("admin.SaveSettings") }}" class="btn btn-info btn-outline">
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endif
</div>
