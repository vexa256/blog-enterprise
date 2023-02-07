<div class="box box-widget widget-user widget-theme">
    <div class="overlay hide">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-default">
        @if($price!='soon' && !empty($current_version))<span class="pull-right badge bg-red">v.{{ $current_version }}</span>@endif
        <img src="{{ $icon }}" alt="{{ $name }}">
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-sm-8 border-right">
                <h4 class="widget-user-username">
                    {{ $name }}

                    @if($price=='soon')
                    <span class="badge bg-white">{!! trans("admin.Notavailabeyet") !!}</span>
                    @elseif($price!=='FREE')
                    <span class="badge bg-green">{{ $price }}</span>
                    @endif
                </h4>
                <div class="info">
                    {!! $weblink == null ? '' : '<a href="'.$weblink.'" target="_blank"><i class="fa fa-globe"></i> Web site</a>' !!}
                </div>
                <!-- /.description-block -->
            </div>

            @unless($price=='soon')

            <div class="col-sm-4 item-actions"
                data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-item-type="theme">
                @if($activation_requied)
                @if($buylink != null)
                <a href="{{ $buylink }}" class="btn btn-block btn-success btn-sm" target="_blank"><i
                        class="fa fa-cart-plus mr-5"></i> {{ trans("admin.BuyNow") }}</a>
                @endif
                <a href="javascript:;" class="btn btn-block btn-warning btn-sm register-item"
                    data-item-id="{{ $item_id }}" data-item-name="{{ $name }}" data-item-buy="{{ $buylink }}"
                    data-item-img="{{ $icon }}">
                    <i class="fa fa-unlock mr-5"></i> {{ trans('admin.ActivateCode') }}</a>
                @elseif(!$instaled)
                <button type="button" class="btn btn-block btn-info btn-sm download-item" data-item-code="{{ $code }}"
                    data-item-id="{{ $item_id }}" data-version="{{ $version }}">
                    <i class="fa fa-check mr-5"></i> {{ trans('admin.download') }}</button>
                @elseif($update_required)
                <button type="button" class="btn btn-block btn-success btn-sm download-item"
                    data-item-code="{{ $code }}" data-item-id="{{ $item_id }}" data-version="{{ $version }}">
                    <i class="fa fa-download mr-5"></i> {{ trans('admin.download') }} v.{{$version}}</button>
                @elseif($active)
                <button type="button" class="btn btn-block btn-default btn-sm disabled"><i class="fa fa-check"></i> {!!trans("admin.Activated") !!}</button>
                <a href="{{  route('admin.theme.settings', [$code]) }}?t={{ $key }}"
                    class="btn btn-block btn-warning  btn-sm"><i class="fa fa-cog"></i></a>
                @else
                <button type="button" class="btn btn-block btn-info btn-sm activate-item"><i class="fa fa-check"></i> {{ trans('admin.Install') }}</button>
                @endif
            </div>

            @endunless
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>
