@extends("_contact.mailbox.mailapp")

@section("mailcontent")

<div class="box box-primary">
    <div class="overlay hide">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-{{ $caticon }}"></i> {{ $catname }}</h3>
        <div class="box-tools pull-right">
            <div class="has-feedback">
                <form method="get" action="{{ route('admin.mailbox', ['type' => 'inbox']) }}">
                    <input type="text" name="qemail" class="form-control input-sm"
                        placeholder="{{ trans("buzzycontact.Searchemailaddress") }}">
                </form>
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body no-padding">
        @if(count($lastmails) > 0)
        @include('_contact.mailbox._buttons')
        @endif
        <div class="clear"></div>

        <div class="table-responsive mailbox-messages">
            <form id="contacts" name="contacts">
                {{ csrf_field() }}
                <table class="table table-hover table-striped contactlist">
                    <tbody>
                        @if(count($lastmails) > 0)
                        @foreach($lastmails as $i => $mail)
                        <tr class=" {{ $mail->read==1 ?: 'unread' }}">
                            <td>
                                <input type="checkbox" name="contacts[]" value="{{ $mail->id }}">
                            </td>
                            <td>
                                <div class="mailbox-read-info">
                                    <a href="{{route('admin.mailbox.read', ['id' => $mail->id])}}" class="taba text-muted">
                                        <h3>
                                            {{ $mail->name > "" ? $mail->name :  trans("buzzycontact.NoName") }}</h3>
                                        <h5>{{ $mail->email }}</h5>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <a class="font-w600 taba"
                                    href="{{route('admin.mailbox.read', ['id' => $mail->id])}}">{{ $mail->subject }}</a>
                                <div class="text-muted push-5-t">{{ str_limit(strip_tags($mail->text), 120) }}..</div>
                            </td>
                            <td>
                                @if(isset($mail->label))
                                <div class="label label-info" style="background-color: {{ $mail->label->color }} !important;"> {{ $mail->label->name }}</div>
                                @endif
                            </td>
                            <td>
                                <a href="javascript:" class="mailbox-star"
                                    data-id="{{ $mail->id }}">@if($mail->stared==1) <i
                                        class="fa fa-star text-yellow"></i> @else <i class="fa fa-star"></i> @endif</a>
                                <a href="javascript:" class="mailbox-important"
                                    data-id="{{ $mail->id }}">@if($mail->important==1) <i
                                        class="fa fa-flag text-red"></i> @else <i class="fa fa-flag"></i> @endif</a>
                                <div class="clear"></div>
                                {{ $mail->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <div class="alert alert-default alert-dismissible">
                            <h4><i class="icon fa fa-{{ $caticon }}"></i> <br><b>{{ $catname }}</b> {{  trans("buzzycontact.folderisempty") }}.!</h4>
                        </div>
                        @endif
                    </tbody>
                </table><!-- /.table -->
            </form>
        </div><!-- /.mail-box-messages -->
        <div class="clear"></div>
        <div class="bottombuttons">
            @if(count($lastmails) > 0)
            @include('_contact.mailbox._buttons')
            @endif
        </div>
        <div class="clear"></div>
    </div><!-- /.box-body -->

</div><!-- /. box -->
@endsection
@section("mailfooter")
@endsection
