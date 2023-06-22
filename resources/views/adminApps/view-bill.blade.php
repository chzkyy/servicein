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
                                <img class="img-fluid ml-5" src="{{ url('assets/img/logo.png') }}" alt="">
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

                                        <div class="view-bukti d-flex justify-content-center align-content-center align-items-center my-5">
                                            <img src="{{ url($merchant['proof_of_payment']) }}" class="img-fluid img-thumbnail" alt="">
                                        </div>

                                        @if ( $merchant['status'] ==  'PAID' )
                                            <div class="col-md-12">
                                                <div class="fs-6 fw-semibold">{{ __("Notes for owner") }}</div>
                                                <textarea name="reason" id="reason" class="form-control" cols="30" rows="4"></textarea>
                                            </div>

                                            <div class="col-md-12 my-5">
                                                <div class="d-flex justify-content-center">
                                                    <div class="col-md-6 d-flex justify-content-end">
                                                        <button type="button" id="accept" class="btn btn-custome shadow col-md-2 fw-semibold btn-sm">Accept</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" id="decline" class="btn btn-custome-outline shadow col-md-2 fw-semibold btn-sm">Decline</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

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

        $('#accept').click(function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to accept this bill?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, accept it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#decline').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    $('#decline').addClass('disabled');

                    $.ajax({
                        url: "{{ route('approve-merchant') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            merchant_id: "{{ $merchant['merchant_id'] }}",
                            approved_by: "{{ Auth::user()->username }}",
                            no_bill: "{{ $merchant['no_bill'] }}",
                            reason: $('#reason').val(),
                        },
                        success: function(data){
                            Swal.fire(
                                'Accepted!',
                                'Bill has been accepted.',
                                'success'
                            ).then((result) => {
                                // href ro dashboard
                                window.location.href = "{{ route('home') }}";
                            });
                        }
                    })
                }
            })
        });

        $('#decline').click(function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to decline this bill?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, decline it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#decline').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    $('#decline').addClass('disabled');

                    $.ajax({
                        url: "{{ route('decline-merchant') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            merchant_id: "{{ $merchant['merchant_id'] }}",
                            approved_by: "{{ Auth::user()->username }}",
                            reason: $('#reason').val(),
                            no_bill: "{{ $merchant['no_bill'] }}",
                        },
                        success: function(data){
                            Swal.fire(
                                'Declined!',
                                'Bill has been declined.',
                                'success'
                            ).then((result) => {
                                // href ro dashboard
                                window.location.href = "{{ route('home') }}";
                            });
                        }
                    })
                }
            })
        });

    </script>

@endsection

