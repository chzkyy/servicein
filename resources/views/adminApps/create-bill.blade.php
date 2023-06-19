@extends('layouts.adminApps')

@section('title')
    {{ __('Admin - Dashboard') }}
@endsection

@section('content')
<section class="min-vh-100">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border border-1 rounded rounded-3 min-vh-100" style="border-color: #655503 !important;">
                            <div class="container my-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="title fw-semibold">
                                                {{ __("Store List in Service.in") }}
                                            </div>
                                            <div class="sub">
                                                {{ __('Commision deadline is on first Saturday on the next month') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row d-flex justify-content-end align-content-center text-end">
                                            <div class="txt-primary fw-bold fs-4">{{ __('Welcome, ') }}
                                                <span class="txt-gold fw-bold">{{ Auth::user()->username }}</span>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="col-md-12">

                                <div class="table-responsive min-vh-100">
                                    <table id="bill_list" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead class="table-custome">
                                            <tr>
                                                <th class="text-center">{{ __('No') }}</th>
                                                <th class="text-center">{{ __('Bill No') }}</th>
                                                <th class="text-center">{{ __('Month') }}</th>
                                                <th class="text-center">{{ __('Transaction Qty') }}</th>
                                                <th class="text-center">{{ __('Status') }}</th>
                                                <th class="text-center">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('additional-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/kt-2.9.0/r-2.4.1/sc-2.1.1/sl-1.6.2/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.4/api/sum().js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function() {
            getData();
        });


        function getData() {
            $.ajax({
                url: "{{ route('listbilltrs-merchant') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id" : "{{ $id }}"
                },
                dataType: "json",
                success: function(res) {
                    $("#bill_list").DataTable({
                        "select"        : false,
                        "responsive"    : true,
                        "autoWidth"     : false,
                        "searching"     : true,
                        "destroy"       : true,
                        "data"          : res,
                        "bLengthChange" : false,
                        "dom"           : '<"row"<"col-md-6 d-flex align-items-end mt-3 mt-md-0 align-content-center "lB><"col-md-6 d-block align-items-end"f>>' +
                                            '<"row"<"col-md-12"tr>>' +
                                            '<"row"<"col-md-5"i><"col-md-7"p>>',
                        "pagingType"    : "simple",
                        "iDisplayLength": 5,
                        "bInfo"         : false,
                        "dataType"      : "json",
                        "order"         : [[ 0, "desc" ]],
                        "columns"       : [
                            {
                                "data": "id",
                                width : "2%",
                                className: "text-center",
                                "render": function ( data, type, row, meta ) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                "data": "no_bill",
                                width : "10%",
                                className: "text-center",
                                orderable: false,
                                render : function(data, type, row, meta) {
                                    // first upper case
                                    var name = data.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                        return letter.toUpperCase();
                                    });

                                    return name;
                                }
                            },
                            {
                                "data": "bill_date",
                                orderable: false,
                                width : "10%",
                                className: "text-center",
                            },
                            {
                                "data": "quantity",
                                width : "10%",
                                orderable: false,
                                className: "text-center",
                                render: function ( data, type, row, meta ) {
                                    return data + ' Transaction';
                                }
                            },
                            {
                                data: "status",
                                width : "10%",
                                orderable: false,
                                className: "text-center",
                                render: function ( data, type, row, meta ) {
                                    var html = '';
                                    //get row status
                                    var status = row.status;
                                    if ( status == 'PAID' || status == 'APPROVE')
                                    {
                                        html += '<span class="badge badge-success">'+status+'</span>';
                                    }
                                    else if ( status == 'DECLINE' )
                                    {
                                        html += '<span class="badge badge-danger">'+status+'</span>';
                                    }
                                    else
                                    {
                                        html += '<span class="badge badge-warning">'+status+'</span>';
                                    }
                                    
                                    return html;
                                }
                            },
                            {
                                data: "no_bill",
                                width : "10%",
                                className: "text-center",
                                render: function ( data, type, row, meta ) {
                                    return '<a href="'+url+'/super-admin/viewbill/'+data+'" class="btn btn-custome btn-sm text-white border-0 mx-1 mb-0">View Detail</a>';
                                }
                            },
                        ],
                        "buttons"         : [
                            {
                                text: 'Send Bill',
                                className: 'btn btn-custome text-white border-0 btn-sm mx-1 mb-0',
                                action: function(e, dt, node, config) {
                                    // redirect to send bill page
                                    var id = '{{ $id }}';
                                    window.location.href = "{{ url('super-admin/sendbill') }}/"+id;
                                }
                            },
                        ]
                    });
                }
            })
        }

        function formatNum(rawNum) {
            // format idr currency
            var num = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(rawNum);
            return num;
        }
    </script>
@endsection

