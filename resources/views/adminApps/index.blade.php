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
                                    <table id="merchant_list" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead class="table-custome">
                                            <tr>
                                                <th class="text-center">{{ __('No') }}</th>
                                                <th class="text-center">{{ __('Store') }}</th>
                                                <th class="text-center">{{ __('Email') }}</th>
                                                <th class="text-center">{{ __('Phone') }}</th>
                                                <th class="text-center">{{ __('Rating') }}</th>
                                                <th class="text-center">{{ __('Status Account') }}</th>
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
                url: "{{ route('get-data-merchant') }}",
                type: "GET",
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
                                render : function(data, type, row, meta) {
                                    // first upper case
                                    var name = data.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                        return letter.toUpperCase();
                                    });

                                    return name;
                                }
                            },
                            {
                                "data": "email",
                                orderable: false,
                                width : "10%",
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
                                data: "status_account",
                                width : "10%",
                                orderable: false,
                                className: "text-center",
                                render: function ( data, type, row, meta ) {
                                    var html = '';
                                    //get row status
                                    var status = row.status_account;
                                    if ( status == 'active' )
                                    {
                                        html += '<span class="badge badge-success">'+status+'</span>';
                                    }
                                    else
                                    {
                                        html += '<span class="badge badge-danger">'+status+'</span>';
                                    }
                                    return html;
                                }
                            },
                            {
                                data: "merchant_id",
                                width : "10%",
                                className: "text-center",
                                render: function ( data, type, row, meta ) {
                                    return '<a href="'+url+'/super-admin/viewdetail/'+data+'" class="btn btn-custome btn-sm text-white border-0 mx-1 mb-0">View Detail</a>';
                                }
                            },
                        ],
                        "buttons"         : [
                            {
                                text: 'Unsuspend',
                                className: 'btn btn-info text-white border-0 btn-sm mx-1 mb-0',
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
                                            text: 'Do you want to unsuspend '+data[0].name+'?',
                                            showCancelButton: true,
                                            confirmButtonColor: '#e3c10fe5',
                                            confirmButtonText: 'Yes, unsuspend it!',
                                            cancelButtonText: 'No, cancel!',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $.ajax({
                                                    url: "{{ route('active-merchant') }}",
                                                    type: "POST",
                                                    data: {
                                                        _token: "{{ csrf_token() }}",
                                                        id: id,
                                                    },
                                                    success: function (response) {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Success!',
                                                            text: 'Merchant has been unsuspended.',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                location.reload();
                                                            }
                                                        });
                                                    },
                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: 'Something went wrong!',
                                                        })
                                                    }
                                                });
                                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Cancelled',
                                                    text: 'Unsuspend merchant cancelled!',
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
                            {
                                text: 'Remove',
                                className: 'btn btn-danger border-0 btn-sm mx-1 mb-0',
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

