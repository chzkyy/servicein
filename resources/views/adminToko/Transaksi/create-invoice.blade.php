@extends('layouts.profileMerchant')

@section('title')
    {{ __('Merchant - Create Invoice') }}
@endsection


@section('content')
<section class="min-vh-100">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none text-black fw-bold"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border border-1 rounded rounded-3" style="border-color: #655503 !important;">
                            <div class="card-header">
                                <h4 class="card-title fw-bold text-center">{{ __('Invoice') }}</h4>
                            </div>
                            <div class="card-body navbar-bg">
                                <img class="img-fluid ml-5" src="{{ url('assets/img/Logo.png') }}" alt="">
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="col-md-12">
                                        <div class="row mt-4">
                                            <div class="col-md-9">
                                                <div class="merchant_name fw-semibold fs-5">{{ $merchant['merchant_name'] }}</div>
                                                <div class="bussines-info my-2">
                                                    <div class="bussines-phone txt-gold fs-6 fw-semibold">{{ __('Bussiness Phone Number') }}</div>
                                                    {{--  format number  --}}
                                                    {{--  substr format amgka dari belakang  --}}
                                                    <div class="bussines-phone">{{ substr($merchant['phone_number'], -12, -9) . " " . substr($merchant['phone_number'], -9, -5) . " " . substr($merchant['phone_number'], -5) }}</div>
                                                </div>
                                                <div class="device-info">
                                                    <div class="device-service txt-gold fs-6 fw-semibold">{{ __("Service Device : ") }} <span class="fw-normal txt-black">{{ $transaction['device_name'] }}</span> </div>
                                                    <div class="device-service txt-gold fs-6 fw-semibold">{{ __("Transaction ID : ") }} <span class="fw-normal txt-black">{{ $transaction['no_transaction'] }}</span> </div>
                                                    <div class="device-service txt-gold fs-6 fw-semibold">{{ __("Status : ") }} <span class="fw-normal txt-black badge badge-success">{{ $transaction['status'] }}</span> </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                @if ( $transaction['device_picture'] == null )
                                                    <img class="img-fluid" src="{{ url('assets/img/no-image.jpg') }}" alt="no_image" class="img-fluid card-img object-fit-fill">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-md-6">
                                                <div class="table-responsive min-vh-100">
                                                    <table id="invoice-list" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                        <thead class="table-custome">
                                                            <tr>
                                                                <th class="text-center">{{ __('No') }}</th>
                                                                <th class="text-center">{{ __('Item') }}</th>
                                                                <th class="text-center">{{ __('Price') }}</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        {{--  Device owner  --}}
                                                        <p class="fw-semibold txt-gold">{{ __('Owner Information') }}</p>

                                                        <div class="row my-2">
                                                            <div class="fw-semibold txt-gold">{{ __('Device Owner') }}</div>
                                                            <div>{{ ucwords($transaction->fullname) }}</div>
                                                        </div>

                                                        <div class="row my-2">
                                                            <div class="fw-semibold txt-gold">{{ __('Phone Number') }}</div>
                                                            <div>{{ $transaction->phone_number }}</div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="fw-semibold txt-gold">{{ __('Email') }}</div>
                                                            <div>{{ $transaction->email }}</div>
                                                        </div>

                                                        <div class="row my-2">
                                                            <div class="fw-semibold txt-gold">{{ __('Warranty') }}</div>
                                                            <input type="text" class="form-control" style="z-index: 999;" id="waranty" name="waranty" placeholder="dd/mm/yyyy" />
                                                        </div>

                                                        <div class="row my-3">
                                                            <div class="fw-semibold txt-gold">{{ __('Description') }}</div>
                                                            <div class="container">
                                                                <textarea name="merchant_note" id="merchant_note" class="form-control" cols="30" rows="3">{{ $transaction->merchant_note }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <p class="fw-semibold txt-gold">{{ __('Booking Detail') }}</p>

                                                        <div class="row my-2">
                                                            <div class="fw-semibold txt-gold">{{ __('Time') }}</div>
                                                            <div>{{ date("H:i", strtotime($transaction->booking_time)).__(' WIB') }}</div>

                                                        </div>

                                                        <div class="row mt-2 mb-4">
                                                            <div class="fw-semibold txt-gold">{{ __('Date') }}</div>
                                                            <div>{{ date("l, d m Y", strtotime($transaction->booking_date)) }}</div>
                                                        </div>

                                                        <div class="row pt-5">
                                                            <div class="fw-semibold txt-gold">{{ __('Total Price') }}</div>
                                                            <div id="totalPrice"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12 my-5">
                                            <div class="d-flex justify-content-center">
                                                <button type="button" id="sendInvoice" class="btn btn-custome shadow col-md-2 fw-semibold btn-sm">Send Invoice</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{--  modal add  --}}
    @include('includes.adminDashboard.modal.addInvoice')
    @include('includes.adminDashboard.modal.editInvoice')
{{--  modal edit  --}}
@endsection




@section('additional-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/kt-2.9.0/r-2.4.1/sc-2.1.1/sl-1.6.2/datatables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.4/api/sum().js"></script>
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        $('#waranty').datepicker({
            format: 'dd-mm-yyyy',
            minDate: new Date(),
            uiLibrary: 'bootstrap5',
            iconsLibrary: 'fontawesome',
            showRightIcon: true,
            autoclose: true,
            todayHighlight: true,
        });

        $('#waranty').change(function() {
            var date = $(this).val();
            var newDate = new Date(date);
            var format = newDate.toLocaleDateString('en-CA', {
                day: 'numeric',
                month: 'numeric',
                year: 'numeric'
            });
        })

        $('#sendInvoice').click(function() {
            var waranty         = $('#waranty').val();
            var merchant_note   = $('#merchant_note').val();
            var no_transaction  = "{{ $transaction['no_transaction'] }}";

            Swal.fire({
                title: 'Are you sure?',
                text: "You will create invoice for this transaction!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, create it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#sendInvoice').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    $('#sendInvoice').addClass('disabled');

                    $.ajax({
                        url: "{{ route('send-invoice') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "waranty": waranty,
                            "merchant_note": merchant_note,
                            "no_transaction": no_transaction
                        },
                        dataType: "JSON",
                        success: function(res) {
                            if (res.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: res.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    window.location.href = "{{ route('home') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: res.message,
                                })
                            }
                        }
                    });
                }
            })
        });
    </script>


    <script>
        $(document).ready(function() {
            var table = $('#invoice-list');
            $.ajax({
                url: "{{ route('get-invoice') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "no_transaction": "{{ $transaction['no_transaction'] }}"
                },
                dataType: "JSON",
                success: function(res) {
                    table.DataTable({
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
                        "columns"       : [
                            {
                                data: "id",
                                width : "5%",
                                className: "text-center",
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                },
                            },
                            {
                                data: "transaction_desc",
                                width : "5%",
                                className: "text-center",

                            },
                            {
                                data: "transaction_price",
                                width : "5%",
                                className: "text-center",
                                //membuat fuunction untuk menampilkan data di html
                                render: function(data, type, row, meta) {
                                    // jumlahkan semua data di colomn price
                                    var sum = table.DataTable().column(2).data().sum();

                                    $('#totalPrice').html(formatNum(sum));
                                    return formatNum(data);
                                },
                            },
                        ],
                        "buttons": [{
                            text: 'Add',
                            className: 'btn btn-custome border border-0 rounded text-white btn-sm mx-1',
                            action: function(e, dt, node, config) {

                                $('#addInvoice').modal('show');
                            }
                        },
                        {
                            text: 'Edit',
                            className: 'btn rounded btn-custome border border border-0 text-white btn-sm mx-1',
                            action: function(e, dt, node, config) {
                                // get selected row
                                var selected = table.DataTable().rows('.selected').indexes();

                                if ( selected.length == 0 ) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Please select a row!',
                                    })
                                } else {
                                    $('#editInvoice').modal('show');
                                    // get data by row
                                    var data  = dt.row(selected).data();
                                    var desc  = $('#edit_item_desc').val(data.transaction_desc);
                                    var id    = $('#id').val(data.id);
                                    var price = $('#edit_item_price').val(data.transaction_price);
                                    if ( desc == '' || price == '' ) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Please fill all the fields!',
                                        })
                                    } else {
                                        $('#editItems').click(function() {
                                            var id    = $('#id').val();
                                            var desc  = $('#edit_item_desc').val();
                                            var price = $('#edit_item_price').val();

                                            $.ajax({
                                                url: "{{ route('update-invoice') }}",
                                                type: "POST",
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    "id": id,
                                                    "transaction_desc": desc,
                                                    "transaction_price": price
                                                },
                                                dataType: "JSON",
                                                success: function(res) {
                                                    if (res.status == 200) {
                                                        RefreshTable('#invoice-list', "{{ route('get-invoice') }}");
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Success',
                                                            text: 'Item has been updated!',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $('#editInvoice').modal('hide');
                                                                // reload table
                                                            }
                                                        })
                                                    }
                                                }
                                            });
                                        });

                                    }
                                }

                            }
                        }
                        ,
                        {
                            text: 'Delete',
                            className: 'btn rounded btn-custome border border-0 text-white btn-sm mx-1',
                            action: function(e, dt, node, config) {
                                // get selected row
                                var selected = table.DataTable().rows('.selected').indexes();

                                // cek selected row
                                if ( selected.length == 0 ) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Please select a row!',
                                    })
                                } else {
                                    var data = dt.row(selected).data();
                                    var id    = data.id;

                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Are you sure?',
                                        text: 'Are you sure you want to delete data ' + data.transaction_desc + '?',
                                        showCancelButton: true,
                                        confirmButtonColor: '#e3c10fe5',
                                        confirmButtonText: `Delete`,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: "{{ route('delete-invoice') }}",
                                                type: "POST",
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    "id": id
                                                },
                                                dataType: "JSON",
                                                success: function(res) {
                                                    if (res.status == 200) {
                                                        RefreshTable('#invoice-list', "{{ route('get-invoice') }}");
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Success',
                                                            text: 'Item has been deleted!',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $('#editInvoice').modal('hide');
                                                            }
                                                        });
                                                    }
                                                }
                                            });
                                        }
                                    })
                                }
                            }
                        }]
                    });
                },
                error: function(err) {
                    //console.log(err);
                }
            });
        });


        function formatNum(rawNum) {
            // format idr currency
            var num = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(rawNum);
            return num;
        }

        function RefreshTable(tableId, urlData) {
            // create function to refresh table with ajax
            var res = $.ajax({
                url: urlData,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "no_transaction": "{{ $transaction['no_transaction'] }}"
                },
                dataType: "JSON",
                success: function(res) {
                    $(tableId).DataTable().clear().draw();
                    $(tableId).DataTable().rows.add(res).draw();
                },
                error: function(err) {
                    //console.log(err);
                }
            });

        }

        $('#addItems').click(function() {
            var desc  = $('#item_desc').val();
            var price = $('#item_price').val();

            if (desc == "" || price == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill all the fields!',
                })
            } else{
                $.ajax({
                    url: "{{ route('add-invoice') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "no_transaction": "{{ $transaction['no_transaction'] }}",
                        "transaction_desc": desc,
                        "transaction_price": price
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status == 200) {
                            RefreshTable('#invoice-list', "{{ route('get-invoice') }}");
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Item has been added!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#addInvoice').modal('hide');
                                    // reset values
                                    $('#item_desc').val('');
                                    $('#item_price').val('');
                                    // console.log(desc +' '+ price);
                                }
                            })
                        }
                    }
                });
            }
        });
    </script>
@endsection

