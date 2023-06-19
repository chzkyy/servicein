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
                                {{--  <div class="filter col-md-2 mb-1 z-50">
                                </div>  --}}
                                <select name="filter_bulan" id="filter_bulan" class="form-control col-md-2 col-sm-3 select2">
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
                                    var html = '';
                                    //get row status
                                    var status = row.status;
                                    console.log(status);
                                    if ( status == "-" || status == 'UNPAID' || status == 'DECLINE' )
                                    {
                                        html += '<a href="{{ url("super-admin/sendbill/") }}/'+data+'" class="btn btn-custome btn-sm border-0 mr-1">Send Bill</a>';
                                        html += '<a href="{{ url("super-admin/viewbill/") }}/'+data+'" class="btn btn-custome btn-sm border-0 ml-1 disabled">View Bill</a>';
                                    }
                                    else
                                    {
                                        html += '<a href="{{ url("super-admin/sendbill/") }}/'+data+'" class="btn btn-custome btn-sm border-0 mr-1 disabled">Send Bill</a>';
                                        html += '<a href="{{ url("super-admin/viewbill/") }}/'+data+'" class="btn btn-custome btn-sm border-0 ml-1">View Bill</a>';
                                    }

                                    return html;
                                }
                            },
                        ],
                        "buttons"         : [
                            {
                                text: 'Remove',
                                className: 'btn btn-custome border-0 btn-sm mx-1 mb-0',
                                action: function(e, dt, node, config) {
                                    var selected = $("#merchant_list").DataTable().rows('.selected').indexes();

                                    if ( selected.length == 0 ) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Please select a row!',
                                        })
                                    } else {
                                        var data = dt.rows({selected: true}).data();
                                        var data = dt.rows({selected: true}).data();
                                        var id   = data[0].merchant_id;

                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Are you sure?',
                                            text: 'Do you want to remove '+data[0].name+'?',
                                            showCancelButton: true,
                                            confirmButtonColor: '#e3c10fe5',
                                            confirmButtonText: 'Yes, remove it!',
                                            cancelButtonText: 'No, cancel!',
                                        }).then((result) => {
                                            if (result.value) {
                                                $.ajax({
                                                    url: "{{ route('delete-merchant') }}",
                                                    type: "post",
                                                    data: {
                                                        _token: "{{ csrf_token() }}",
                                                        id: id,
                                                    },
                                                    dataType: "JSON",
                                                    success: function (data) {
                                                        if (data.status == 'success') {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Success!',
                                                                text: data.message,
                                                            }).then((result) => {
                                                                if (result.value) {
                                                                    location.reload();
                                                                }
                                                            });
                                                        } else {
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Oops...',
                                                                text: data.message,
                                                            })
                                                        }
                                                    },
                                                    error: function (jqXHR, textStatus, errorThrown) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: errorThrown,
                                                        })
                                                    }
                                                });
                                            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Cancelled',
                                                    text: 'Remove cancelled!',
                                                })
                                            }
                                        })
                                    }


                                }
                            },
                            {
                                text: 'Suspend',
                                className: 'btn btn-custome border-0 btn-sm mx-1 mb-0',
                                action: function(e, dt, node, config) {
                                    var selected = $("#merchant_list").DataTable().rows('.selected').indexes();

                                    if ( selected.length == 0 ) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Please select a row!',
                                        })
                                    } else {
                                        var data = dt.rows({selected: true}).data();
                                        var data = dt.rows({selected: true}).data();
                                        var id   = data[0].merchant_id;

                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Are you sure?',
                                            text: 'Do you want to suspend '+data[0].name+'?',
                                            showCancelButton: true,
                                            confirmButtonColor: '#e3c10fe5',
                                            confirmButtonText: `Suspend`,
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $.ajax({
                                                    url: "{{ route('suspend-merchant') }}",
                                                    type: "POST",
                                                    data: {
                                                        _token: "{{ csrf_token() }}",
                                                        id: id,
                                                    },
                                                    success: function (data) {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Success',
                                                            text: data.message,
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                location.reload();
                                                            }
                                                        })
                                                    },
                                                    error: function (data) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: data.message,
                                                        })
                                                    }
                                                })
                                            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Cancelled',
                                                    text: 'Remove cancelled!',
                                                })
                                            }
                                        })
                                    }
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

