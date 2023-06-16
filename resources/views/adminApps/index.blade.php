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
                                <div class="filter col-md-2 mb-1 z-50">
                                    {{--  create dropdown  --}}
                                    <select name="filter_bulan" id="filter_bulan" class="form-control select2">
                                        <option value=""></option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="table-responsive min-vh-100">
                                    <table id="merchant_list" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead class="table-custome">
                                            <tr>
                                                <th class="text-center">{{ __('No') }}</th>
                                                <th class="text-center">{{ __('Store Name') }}</th>
                                                <th class="text-center">{{ __('Transaction') }}</th>
                                                <th class="text-center">{{ __('Month') }}</th>
                                                <th class="text-center">{{ __('Status') }}</th>
                                                <th class="text-center">{{ __('Phone') }}</th>
                                                <th class="text-center">{{ __('Rating') }}</th>
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
        $('#filter_bulan').select2({
            placeholder: "ALL",
            allowClear: true
        });

        $(document).ready(function() {
            var month = 'ALL';
            // get value from dropdown
            $('#filter_bulan').on('change', function() {
                var month = $(this).val();
                if (month == '') {
                    month = 'ALL';
                }
                getData(month);
            });

            getData(month);
        });


        function getData(month) {
            $.ajax({
                url: "{{ route('get-data-merchant') }}",
                type: "GET",
                data: {
                    month: month
                },
                dataType: "json",
                success: function(res) {
                    $("#merchant_list").DataTable({
                        "select": {
                            style: 'single',
                        },
                        "responsive"    : true,
                        "autoWidth"     : false,
                        "searching"     : false,
                        "destroy"       : true,
                        "data"          : res,
                        "bLengthChange" : false,
                        "dom"           : '<"pull-left"f>' + 'B' + 'lrtip',
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
                                "data": "name",
                                width : "10%",
                                className: "text-center",
                                orderable: false,
                            },
                            {
                                "data": "transaction",
                                orderable: false,
                                width : "10%",
                                className: "text-center",
                                "render": function ( data, type, row, meta ) {
                                    return data + " Transaction";
                                }
                            },
                            {
                                "data": "month_bill",
                                orderable: false,
                                width : "10%",
                                className: "text-center",
                                render: function ( data, type, row, meta ) {
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
                                "data": "status",
                                width : "5%",
                                className: "text-center",
                            },
                            {
                                "data": "phone_number",
                                width : "10%",
                                orderable: false,
                                className: "text-center",
                            },
                            {
                                "data": "rating",
                                width : "10%",
                                className: "text-center",
                                render: function ( data, type, row, meta ) {
                                    var rate = '';
                                    switch (data) {
                                        case 0:
                                            rate += '<i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i>';
                                            break;
                                        case 1:
                                            rate += '<i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i>';
                                            break;
                                        case 2:
                                            rate += '<i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i>';
                                            break;
                                        case 3:
                                            rate += '<i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i>';
                                            break;
                                        case 4:
                                            rate += '<i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-regular fa-star" style="color: #d1d1d1;"></i>';
                                            break;
                                        case 5:
                                            rate += '<i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i><i class="fa-solid fa-star" style="color: #ffa800;"></i>';
                                            break;

                                        default:
                                            return rate;
                                    };
                                    return rate;
                                }
                            },
                            {
                                "data": "merchant_id",
                                width : "10%",
                                className: "text-center",
                                render: function ( data, type, row, meta ) {
                                    return '<a href="{{ url("admin/merchant/detail") }}/'+data+'" class="btn btn-custome btn-sm border-0 mr-1">Send Bill</a>'+
                                            '<a href="{{ url("admin/merchant/detail") }}/'+data+'" class="btn btn-custome btn-sm border-0 ml-1">View Bill</a>';
                                }
                            },
                        ],
                        "buttons"         : [
                            {
                                text: 'Remove',
                                    className: 'btn btn-custome border-0 btn-sm mx-1',
                                    action: function(e, dt, node, config) {

                                }
                            },
                            {
                                text: 'Suspend',
                                className: 'btn btn-custome border-0 btn-sm mx-1',
                                action: function(e, dt, node, config) {

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

