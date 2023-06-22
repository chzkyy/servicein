@extends('layouts.adminApps')

@section('title')
    {{ __('Admin - Send Bill') }}
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
                                <h4 class="card-title fw-bold text-center">{{ __('Monthly Bill') }}</h4>
                            </div>
                            <div class="card-body navbar-bg">
                                <img class="img-fluid ml-5" src="{{ url('assets/img/Logo.png') }}" alt="">
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="col-md-12">
                                        <div class="title fs-5 txt-gold fw-semibold">{{ __("Bussiness Information") }}</div>
                                        <div class="row mt-4">
                                            <div class="col-md-7">
                                                <div class="row my-2">
                                                    <div class="fs-6 fw-semibold">{{ __("Bussiness Name") }}</div>
                                                    <span>{{ $merchant['merchant_name'] }}</span>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="fs-6 fw-semibold">{{ __("Bussiness Description") }}</div>
                                                    <span>{{ $merchant['merchant_desc'] }}</span>
                                                </div>
                                            </div>

                                            <div class="col-md-4 offset-0 offset-md-1">
                                                <div class="row my-2">
                                                    <div class="fs-6 fw-semibold">{{ __("Bussiness Email") }}</div>
                                                    <span>{{ $merchant['email'] }}</span>
                                                </div>

                                                <div class="row my-2">
                                                    <div class="fs-6 fw-semibold">{{ __("Bill Month") }}</div>
                                                    <span>{{ $merchant['bill_date'] }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <div class="table-responsive min-vh-100">
                                                <table id="trans_list" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                    <thead class="table-custome">
                                                        <tr>
                                                            <th class="text-center">{{ __('No') }}</th>
                                                            <th class="text-center">{{ __('Transaction Number') }}</th>
                                                            <th class="text-center">{{ __('Transaction Date') }}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="row my-2">
                                                <div class="txt-black col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3 text-wrap fw-semibold txt-gold">{{ __("Transaction Quantity") }}</div>
                                                        <div class="col-md-9">{{ $merchant['total'] }} Transaction</div>
                                                    </div>
                                                </div>
                                                <div class="txt-black col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3 text-wrap fw-semibold txt-gold">{{ __("Commission Fee") }}</div>
                                                        <div class="col-md-9">Rp. {{ number_format('5000', 2, ',', '.') }}/Transaction</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <hr class="w-auto">
                                            </div>

                                            <div class="row my-2">
                                                <div class="txt-black col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3 fw-semibold txt-gold">{{ __('Total') }}</div>
                                                        <div class="col-md-9">Rp. {{ number_format($merchant['total']*5000, 2, ',', '.') }}</div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 my-5">
                                            <div class="d-flex justify-content-center">
                                                <button type="button" id="sendBill" class="btn btn-custome shadow col-md-2 fw-semibold btn-sm">Send Bill</button>
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

@endsection




@section('additional-script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/kt-2.9.0/r-2.4.1/sc-2.1.1/sl-1.6.2/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.4/api/sum().js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('getListTransaction-admin') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "merchant_id": "{{ $merchant['merchant_id'] }}"
                },
                dataType: "json",
                success: function(res) {
                    $('#trans_list').DataTable({
                        "select"        : false,
                        "responsive"    : true,
                        "autoWidth"     : false,
                        "searching"     : false,
                        "destroy"       : true,
                        "data"          : res,
                        "bLengthChange" : false,
                        "pagingType"    : "simple",
                        "iDisplayLength": 5,
                        "bInfo"         : false,
                        "dataType"      : "json",
                        "columns"       : [
                            {
                                "data": "id",
                                orderable: false,
                                className: 'text-center',
                                "render": function ( data, type, row, meta ) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                "data": "no_transaction",
                                orderable: false,
                                className: 'text-center',
                            },
                            {
                                "data": "created_at",
                                orderable: false,
                                className: 'text-center',
                            },
                        ],
                    });
                }
            });


            $('#sendBill').click(function(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will send bill to merchant",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3c10fe5',
                    confirmButtonText: 'Yes, send it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('#sendBill').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        $('#sendBill').addClass('disabled');

                        $.ajax({
                            url: "{{ route('createBill-merchant') }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "merchant_id": "{{ $merchant['merchant_id'] }}",
                                "jmlh_transaksi": "{{ $merchant['total'] }}",
                                "bills_date": "{{ $merchant['bills'] }}"
                            },
                            dataType: "json",
                            success: function(res) {
                                if(res.status == 'success'){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: res.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.href = "{{ route('home') }}";
                                    });
                                }else{
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
            })
        });
    </script>

@endsection

