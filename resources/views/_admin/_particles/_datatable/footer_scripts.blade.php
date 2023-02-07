<!-- iCheck -->
<script src="{{ asset('assets/plugins/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/plugins/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/adminlte/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script>
    var buzzy_datatable = {
        order: "{{$order_count ?? 1}}",
        ajax_url: "{!! $data_url !!}",
        languages: {
                "sDecimal": ",",
                "infoEmpty": "{!! trans('admin.sEmptyTable')  !!}",
                "sInfo": "{!! trans('admin.sInfo')  !!}",
                "sInfoEmpty": "{!! trans('admin.sInfoEmpty')  !!}",
                "sInfoFiltered": "{!! trans('admin.sInfoFiltered')  !!}",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "{!! trans('admin.sLengthMenu')  !!}",
                "sLoadingRecords": "{!! trans('admin.sLoadingRecords')  !!}",
                "sProcessing": "{!! trans('admin.sProcessing')  !!}",
                "sSearch": "{!! trans('admin.sSearch')  !!}",
                "sZeroRecords": "{!! trans('admin.sZeroRecords')  !!}",
                "oPaginate": {
                    "sFirst": "{!! trans('admin.sFirst')  !!}",
                    "sLast": "{!! trans('admin.sLast')  !!}",
                    "sNext": "{!! trans('admin.sNext')  !!}",
                    "sPrevious": "{!! trans('admin.sPrevious')  !!}"
                },
                "oAria": {
                    "sSortAscending": "{!! trans('admin.sSortAscending')  !!}",
                    "sSortDescending": "{!! trans('admin.sSortDescending')  !!}"
                }
            },
        columns: {!!json_encode(array_values(array_filter($columns)))!!}
    }
</script>
<script src="{{ asset('assets/admin/js/datatable.js') }}"></script>
