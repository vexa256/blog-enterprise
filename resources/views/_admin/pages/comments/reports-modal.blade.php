<div class="modal modal-info in" id="modal{{$modal_id}}">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-remove"></i></button>
                <h4 class="modal-title">{!! __('Reports') !!}</h4>
            </div>

            <div class="table-responsive">
                <table class="table no-margin">
                    <thead>
                        <tr>
                            <th width="20%">{{ trans('admin.User') }}</th>
                            <th width="55%">{{ __('Report Reason') }}</th>
                            <th width="25%">{{ trans('admin.Dates') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <td>
                                <a href="{{$report->user->profile_link}}" target="_blank" class="product-img">
                                    <img src="{{ makepreview($report->user->thumb, 's', 'members/avatar') }}" width="30px">
                                    <span>{{$report->user->username}}</span>
                                </a>
                            </td>
                            <td>
                                {{ $report->body ?? '-' }}
                            </td>
                            <td>
                                {{ $report->created_at->format('Y-m-d H:i:s') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
             <div class="clearfix"></div>
        </div>
    </div>
</div>
