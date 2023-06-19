@extends('layouts.adminDashboard')

@section('title')
    {{ __('Merchant - Dashboard') }}
@endsection

@section('content')
<div class="col-md-12">
    <div class="card rounded shadow shadow-md">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="font-weight-bold h6">{{ __('Bill List') }}</div>
                        <div class="font-weight-normal mb-1">{{ __('Commision deadline is on first Saturday on the next month') }}</div>

                        <div class="table-responsive">
                            <table id="bill-list" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead class="table-custome">
                                    <tr>
                                        <th class="text-center">{{ __('No') }}</th>
                                        <th class="text-center">{{ __('No Bills') }}</th>
                                        <th class="text-center">{{ __('Transaction Qty') }}</th>
                                        <th class="text-center">{{ __('Month') }}</th>
                                        <th class="text-center">{{ __('Comission') }}</th>
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
@endsection



@section('additional-script')
    <script>

        $(document).ready(function() {
            $.ajax({
                url: "{{ route('admin-list-bills') }}",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $("#bill-list").DataTable({
                        "select": {
                            style: 'single',
                        },
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
                            },
                            {
                                "data": "total_transaction",
                                orderable: false,
                                width : "10%",
                                className: "text-center",
                                "render": function ( data, type, row, meta ) {
                                    return data + " Transaction";
                                }
                            },
                            {
                                "data": "bills_date",
                                orderable: false,
                                width : "10%",
                                className: "text-center",
                                render : function(data, type, row, meta) {
                                    if( data == '01' )
                                    {
                                        return "January";
                                    }
                                    else if( data == '02' )
                                    {
                                        return "February";
                                    }
                                    else if( data == '03' )
                                    {
                                        return "March";
                                    }
                                    else if( data == '04' )
                                    {
                                        return "April";
                                    }
                                    else if( data == '05' )
                                    {
                                        return "May";
                                    }
                                    else if( data == '06' )
                                    {
                                        return "June";
                                    }
                                    else if( data == '07' )
                                    {
                                        return "July";
                                    }
                                    else if( data == '08' )
                                    {
                                        return "August";
                                    }
                                    else if( data == '09' )
                                    {
                                        return "September";
                                    }
                                    else if( data == '10' )
                                    {
                                        return "October";
                                    }
                                    else if( data == '11' )
                                    {
                                        return "November";
                                    }
                                    else if( data == '12' )
                                    {
                                        return "December";
                                    }
                                    else if( data == '-' )
                                    {
                                        return "-";
                                    }
                                }
                            },
                            {
                                "data": "amount",
                                width : "5%",
                                className: "text-center",
                                render : function(data, type, row, meta) {
                                    return formatNum(data);
                                }
                            },
                            {
                                "data": "status",
                                width : "10%",
                                orderable: false,
                                className: "text-center",
                                render : function(data, type, row, meta) {
                                    if( data == 'UNPAID' )
                                    {
                                        return '<span class="badge badge-warning">'+data+'</span>';
                                    }
                                    else if( data == 'PAID' || data == 'APPROVED')
                                    {
                                        return '<span class="badge badge-success">'+data+'</span>';
                                    }
                                    else if( data == 'DECLINE' )
                                    {
                                        return '<span class="badge badge-danger">'+data+'</span>';
                                    }
                                }
                            },
                            {
                                "data": "no_bill",
                                width : "10%",
                                className: "text-center",
                                render : function(data, type, row, meta) {
                                    var url_bill = "{{ url('admin/bills') }}/"+data;
                                    return '<a href="'+url_bill+'" class="btn btn-sm btn-custome">Detail</a>';
                                }
                            },
                        ],

                    });
                }
            });

            function formatNum(rawNum) {
                // format idr currency
                var num = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(rawNum);
                return num;
            }

        });


    </script>
@endsection
