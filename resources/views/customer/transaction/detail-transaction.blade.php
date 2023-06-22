@extends('layouts.dashboard')

@section('title')
    {{ __('Detail Transaction') }}
@endsection

@section('content')
<section class="mt-5 pt-md-5 min-vh-100">
    <div class="container-fluid">
        <div class="container">
            <div class="col-md-12">
                <div class="container pt-5">

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none text-black fw-bold"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                    </div>

                    <div class="transaction-detail mt-5 mb-2">
                        <div class="row">
                            <div class="card my-2 transaction mb-2 border border-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 d-flex align-items-center">
                                            @if ( $transaction->device_picture == null )
                                                <img src="{{ asset('assets/img/no-image.jpg') }}" alt="device_images" class="img-thumbnail img-fluid" style="width: 150px; height: auto;">
                                            @else
                                                <img src="{{ asset($transaction->device_picture) }}" alt="device_images" class="img-thumbnail img-fluid" style="width: 150px; height: auto;">
                                            @endif
                                        </div>
                                        <div class="col-md-8 d-flex align-items-center">
                                            <div class="row">
                                                <p class="fw-semibold"></p>
                                                <span>Device : {{ $transaction->device_name }}</span>
                                                <div>
                                                    {{ __("Status :") }}
                                                    @if ($transaction->status == 'BOOKED')
                                                        <span class="badge bg-primary">{{ $transaction->status }}</span>
                                                    @elseif ($transaction->status == 'DONE')
                                                        <span class="badge bg-success">{{ $transaction->status }}</span>
                                                    @elseif ($transaction->status == 'CANCELLED')
                                                        <span class="badge bg-danger">{{ $transaction->status }}</span>
                                                    @elseif ($transaction->status == 'ON PROGRESS')
                                                        <span class="badge bg-dark">{{ $transaction->status }}</span>
                                                    @elseif ($transaction->status == 'ON PROGRESS - Need Confirmation')
                                                        {{--  explode  --}}
                                                        @php
                                                            $status = explode(' - ', $transaction->status);
                                                        @endphp
                                                        <span class="badge bg-dark">{{ $status[0] }}</span>{{ __(" - ") }}<span class="badge bg-warning">{{ $status[1] }}</span>
                                                    @elseif ($transaction->status == 'ON COMPLAINT')
                                                        <span class="badge bg-info">{{ $transaction->status }}</span>
                                                    @endif
                                                </div>
                                                <span>Transaction ID : {{ $transaction->no_transaction }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail">
                        <div class="row">
                            <div class="card my-2 detail mb-2 border border-2">
                                <div class="card-body">
                                    <div class="row">
                                        @if ($transaction->status != 'DONE')
                                            <div class="col-md-12 txt-gold fs-5">
                                                {{ __("Store in Charge :") }}
                                            </div>
                                        @else
                                            <div class="col-md-8 txt-gold fs-5">
                                                {{ __("Store in Charge :") }}
                                            </div>
                                            <div class="col-md-4 txt-gold fs-5">
                                                {{ __("Warranty :") }}
                                            </div>
                                        @endif

                                        @if ($transaction->status != 'DONE')
                                            <div class="col-md-12 txt-gold fs-5 fw-bold mt-3">
                                                {{ ucwords($transaction->merchant_name) }}
                                            </div>
                                        @else
                                            <div class="col-md-8 txt-gold fs-5 fw-bold mt-3">
                                                {{ ucwords($transaction->merchant_name) }}
                                            </div>
                                            <div class="col-md-4 txt-gold fs-6 mt-1">
                                                @if ( $transaction->waranty == null )
                                                    {{ __('-') }}
                                                @else
                                                    {{ date('d M Y',strtotime($transaction->waranty)) }}
                                                @endif
                                            </div>
                                        @endif

                                        {{--  btn chat  --}}
                                        @if ($transaction->status == 'BOOKED' || $transaction->status == 'ON PROGRESS' || $transaction->status == 'ON PROGRESS - Need Confirmation' || $transaction->status == 'ON COMPLAINT')
                                            <div class="col-md-12 mt-3 mb-4">
                                                <a href="{{ route('chat-merchant', ['id' => $merchant_id]) }}" class="btn btn-custome text-decoration-none text-white fw-bold">{{ __('Chat Merchant') }}</a>
                                            </div>
                                        @elseif ($transaction->status == 'DONE')
                                            <div class="col-md-12 mt-3 mb-4">
                                                @if ( $transaction->waranty != null )
                                                    <a href="{{ route('view-invoice-customer', ['id' => $transaction->no_transaction]) }}" class="btn btn-custome text-decoration-none text-white fw-bold">{{ __('View Invoice') }}</a>
                                                @endif
                                            </div>
                                        @endif

                                        {{--  informasi  --}}
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3 my-4">
                                                    {{--  Device owner  --}}
                                                    <p class="fw-semibold txt-gold">{{ __('Device Detail') }}</p>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Device Brand') }}</div>
                                                        <div>{{ ucwords($transaction->brand) }}</div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Device Tyoe') }}</div>
                                                        <div>{{ ucwords($transaction->type) }}</div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Serial Number') }}</div>
                                                        <div>
                                                            {{ $transaction->serial_number }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 my-4">
                                                    <p class="fw-semibold">{{ __('Merchant Detail') }}</p>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Email') }}</div>
                                                        <div>{{ $transaction->email }}</div>
                                                    </div>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Address') }}</div>
                                                        <div>{{ $transaction->merchant_address }}</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 my-4">
                                                    <p class="fw-semibold txt-gold">{{ __('Booking Detail') }}</p>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Time') }}</div>
                                                        <div>{{ date("H:i", strtotime($transaction->booking_time)).__(' WIB') }}</div>

                                                    </div>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Date') }}</div>
                                                        <div>{{ date("l, d M Y", strtotime($transaction->booking_date)) }}</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 my-4">
                                                    <p class="fw-semibold txt-gold">{{ __("Description") }}</p>
                                                    {{--  fowm text area  --}}
                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __("Merchant Note") }}</div>
                                                        @if ($transaction->merchant_note == null)
                                                            <div>{{ __('-') }}</div>
                                                        @else
                                                            <div>{{ $transaction->merchant_note }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __("Customer Note") }}</div>
                                                        <div>{{ $transaction->user_note }}</div>
                                                    </div>
                                                </div>

                                                @if ($transaction->status == 'BOOKED')
                                                    <div class="col-md-12 d-flex justify-content-center mt-5">
                                                        {{--  create btn cancle  --}}
                                                        <form action="{{ route('cancel-booking') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="no_transaction" value="{{ $transaction->no_transaction }}">
                                                            <button type="button" id="cancleBtn" class="btn btn-custome text-decoration-none text-white fw-bold">{{ __('Cancel Booking') }}</button>
                                                        </form>
                                                    </div>
                                                @elseif ($transaction->status == 'DONE')
                                                    <div class="col-md-12 d-flex justify-content-center">
                                                        <div class="row mt-5">
                                                            @if( date("Y-m-d") > date('Y-m-d',strtotime($transaction->waranty)) )
                                                                @if ($review == null)
                                                                    <div class="review col-md-12">
                                                                        <button type="button" class="btn btn-custome text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#reviewModal">{{ __('Review') }}</button>
                                                                    </div>
                                                                @else
                                                                    <div class="review col-md-12">
                                                                        <button type="button" class="btn btn-custome text-decoration-none fw-bold" disabled>{{ __('Review') }}</button>
                                                                    </div>
                                                                @endif
                                                            @else

                                                                @if ($review == null)
                                                                    <div class="review col-md-6">
                                                                        <button type="button" class="btn btn-custome text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#reviewModal">{{ __('Review') }}</button>
                                                                    </div>
                                                                @else
                                                                    <div class="review col-md-6">
                                                                        <button type="button" class="btn btn-custome text-decoration-none fw-bold" disabled>{{ __('Review') }}</button>
                                                                    </div>
                                                                @endif

                                                                <div class="complaint col-md-6">
                                                                    <form action="{{ route('complaint') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="no_transaction" value="{{ $transaction->no_transaction }}">
                                                                        <button type="button" id="complaintBtn" class="btn btn-custome-outline text-decoration-none fw-bold">{{ __('Complaint') }}</button>
                                                                    </form>
                                                                </div>
                                                            @endif
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
        </div>
    </div>
</section>

@include('includes.customer.modal.createReview')

@endsection



@section('additional-script')
    {{--  <!-- important mandatory libraries -->  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/star-rating.min.js" type="text/javascript"></script>

    {{--  <!-- with v4.1.0 Krajee SVG theme is used as default (and must be loaded as below) - include any of the other theme JS files as mentioned below (and change the theme property of the plugin) -->  --}}
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.js"></script>

    {{--  <!-- optionally if you need translation for your language then include locale file as mentioned below (replace LANG.js with your own locale file) -->  --}}
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/locales/LANG.js"></script>
    <script src="{{ asset('assets/js/image-uploader.min.js') }}"></script>

    <script>
        $('#cancleBtn').click(function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to cancel this booking?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#cancleBtn').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    $('#cancleBtn').addClass('disabled');

                    Swal.fire(
                        'Canceled!',
                        'Your booking has been canceled.',
                        'success'
                    ).then(() => {
                        $(this).parent().submit();
                    })
                }
            })
        })

        $('#complaintBtn').click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to complaint?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, complaint it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#complaintBtn').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    $('#complaintBtn').addClass('disabled');

                    Swal.fire({
                        title : 'Your complaint has been made!',
                        text: 'Please come to the store before the warranty periods end.',
                        icon : 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#e3c10fe5',
                        confirmButtonText: 'Back to homepage'
                    }).then(() => {
                        $(this).parent().submit();
                    })
                }
            })
        })


        $('.input-images').imageUploader({
            imagesInputName: 'photos',
            maxSize: 2 * 1024 * 1024,
            maxFiles: 1,
            label: 'Upload your photo',
            extensions: ['.jpg', '.jpeg', '.png'],
            mimes: ['image/jpeg', 'image/png'],
            maxFileSize: 2 * 1024 * 1024,
            allowedExtensions: ['jpg', 'jpeg', 'png']
        });

        $("input[type='file']").on("change", function () {
            if(this.files[0].size > 2000000) {
                file = $(this)[0].files[0];
                //console.log(file);

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: file.name + ' size must be less than 2 MB!',
                }).then((result) => {
                    // reload the page
                    location.reload();
                });

            }

            return false;
        });

        $("#rating").rating({
            min : 0,
            max : 5,
            step : 1,
            size : 'sm',
            showClear : false,
            showCaption : false,
        });



        $('#submit_review').click(function(e) {
            e.preventDefault();

            let form     = $('#photos')[0];
            let formData = new FormData(form);
            let file     = $("input[type='file']")[0].files[0];

            // get value from rating
            var rating   = $('#rating').val();
            var review   = $('#review').val();
            var reviewId = '';

            // console.log(file);
            // if file tidak ditemukan
            if ( reting == '' || review == '' ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill all the fields!',
                })

                return false;
            }
            else {

                if(file != undefined) {
                    if(file.size > 2000000) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'File size must be less than 2 MB!',
                        })

                        return false;
                    }

                    $.ajax({
                        url : "{{ route('add-review') }}",
                        type : "POST",
                        data : formData,
                        contentType: false,
                        processData: false,
                        success : function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Your review has been added!',
                            }).then((result) => {
                                // reload the page
                                location.reload();
                            });
                        },
                        error : function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            })
                        }
                    })
                }
                else {
                    $.ajax({
                        url : "{{ route('add-review') }}",
                        type : "POST",
                        data : formData,
                        contentType: false,
                        processData: false,
                        success : function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Your review has been added!',
                            }).then((result) => {
                                // reload the page
                                location.reload();
                            });
                        },
                        error : function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            })
                        }
                    })
                }
            }
        });
    </script>
@endsection
