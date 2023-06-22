@extends('layouts.profileMerchant')

@section('title')
    {{ __('Merchant - Detail Transaction') }}
@endsection

@section('content')
<section class="min-vh-100">
    <div class="container-fluid">
        <div class="container">
            <div class="col-md-12">
                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none text-black fw-bold"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                    </div>

                    <div class="transaction-detail mb-2">
                        <div class="row">
                            <div class="card my-2 transaction mb-2 border border-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2 d-flex align-items-center">
                                            @if ($transaction->device_picture == null)
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
                                                        <span class="badge badge-primary">{{ $transaction->status }}</span>
                                                    @elseif ($transaction->status == 'DONE')
                                                        <span class="badge badge-success">{{ $transaction->status }}</span>
                                                    @elseif ($transaction->status == 'CANCELLED')
                                                        <span class="badge badge-danger">{{ $transaction->status }}</span>
                                                    @elseif ($transaction->status == 'ON PROGRESS')
                                                        <span class="badge badge-dark">{{ $transaction->status }}</span>
                                                    @elseif ($transaction->status == 'ON PROGRESS - Need Confirmation')
                                                        {{--  explode  --}}
                                                        @php
                                                            $status = explode(' - ', $transaction->status);
                                                        @endphp
                                                        <span class="badge badge-dark">{{ $status[0] }}</span>{{ __(" - ") }}<span class="badge badge-warning">{{ $status[1] }}</span>
                                                    @elseif ($transaction->status == 'ON COMPLAINT')
                                                        <span class="badge badge-info">{{ $transaction->status }}</span>
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
                                        <div class="col-md-12 txt-gold fs-5">
                                            {{ __("Customer Name :") }}
                                        </div>

                                        <div class="col-md-12 txt-gold fs-5 fw-bold">
                                            {{ ucwords($transaction->fullname) }}
                                        </div>

                                        <div class="col-md-12 my-4">
                                            {{--  btn open modal create confirmation  --}}
                                            @if ($transaction->status == 'ON PROGRESS')
                                                <button type="button" class="btn btn-custome btn-sm" data-bs-toggle="modal" data-bs-target="#createConfirmation">
                                                    {{ __('Create Confirmation') }}
                                                </button>
                                            @endif
                                        </div>

                                        {{--  informasi  --}}
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3 my-4">
                                                    {{--  Device owner  --}}
                                                    <div class="fw-semibold txt-gold">{{ __('Device Owner') }}</div>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Full name') }}</div>
                                                        <div>{{ ucwords($transaction->fullname) }}</div>
                                                    </div>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Gender') }}</div>
                                                        <div>{{ ucwords($transaction->gender) }}</div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Birth Date') }}</div>
                                                        {{--  check bod == null atau tidak --}}
                                                        <div>
                                                            @if ($transaction->dob == null)
                                                                {{ __('-') }}
                                                            @else
                                                                {{ date("d M Y", strtotime($transaction->dob)) }}
                                                            @endif
                                                        </div>
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
                                                        <div>{{ date("l, d/m/Y", strtotime($transaction->booking_date)) }}</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 my-4">
                                                    <p class="fw-semibold txt-gold">{{ __("Description") }}</p>
                                                        {{--  form text area  --}}
                                                    @if ($transaction->status == 'BOOKED')
                                                        <div class="form-group">
                                                            <textarea name="merchant_note" class="form-control  " id="merchant_note" cols="25" rows="3"></textarea>
                                                        </div>
                                                    @elseif ($transaction->status == 'DONE')

                                                        <div class="row my-2">
                                                            <div class="fw-semibold">{{ __("Merchant Note") }}</div>
                                                            @if ($transaction->merchant_note == null)
                                                                <div>{{ __('-') }}</div>
                                                            @else
                                                                <div>{{ $transaction->merchant_note }}</div>
                                                            @endif
                                                        </div>
                                                    @elseif ($transaction->status == 'CANCELLED')
                                                        <div class="row my-2">
                                                            <div class="fw-semibold">{{ __("Merchant Note") }}</div>
                                                            @if ($transaction->merchant_note == null)
                                                                <div>{{ __('-') }}</div>
                                                            @else
                                                                <div>{{ $transaction->merchant_note }}</div>
                                                            @endif
                                                        </div>
                                                    @elseif ($transaction->status == 'ON PROGRESS')
                                                        <div class="row my-2">
                                                            <div class="fw-semibold">{{ __("Merchant Note") }}</div>
                                                            @if ($transaction->merchant_note == null)
                                                                <div>{{ __('-') }}</div>
                                                            @else
                                                                <div>{{ $transaction->merchant_note }}</div>
                                                            @endif
                                                        </div>
                                                    @elseif ($transaction->status == 'ON PROGRESS - Need Confirmation')
                                                        <div class="row my-2">
                                                            <div class="fw-semibold">{{ __("Merchant Note") }}</div>
                                                            @if ($transaction->merchant_note == null)
                                                                <div>{{ __('-') }}</div>
                                                            @else
                                                                <div>{{ $transaction->merchant_note }}</div>
                                                            @endif
                                                        </div>
                                                    @elseif ($transaction->status == 'ON COMPLAINT')
                                                    <div class="row my-2">
                                                            <div class="fw-semibold">{{ __("Merchant Note") }}</div>
                                                            @if ($transaction->merchant_note == null)
                                                                <div>{{ __('-') }}</div>
                                                            @else
                                                                <div>{{ $transaction->merchant_note }}</div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __("Customer Note") }}</div>
                                                        @if ($transaction->user_note == null)
                                                            <div>{{ __('-') }}</div>
                                                        @else
                                                            <div>{{ $transaction->user_note }}</div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-3 my-4">
                                                    <p class="fw-semibold txt-gold">{{ __('Detail Transaction') }}</p>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Status Confirmation') }}</div>
                                                        <div>{{ $status_confirmation }}</div>
                                                    </div>

                                                    <div class="row my-2">
                                                        <div class="fw-semibold">{{ __('Warranty') }}</div>
                                                        @if ($transaction->warranty == null)
                                                            <div>{{ __('-') }}</div>
                                                        @else
                                                            <div>{{ $transaction->warranty }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($transaction->status == 'BOOKED')
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="fw-semibold">Status</div>
                                                    <div class="col-md-2 my-2">
                                                        <select name="status" id="status_select" class="form-control select2">
                                                            <option value=""></option>
                                                            <option value="DONE">{{ __('Done') }}</option>
                                                            <option value="ON PROGRESS">{{ __('On Progress') }}</option>
                                                            <option value="CANCELLED">{{ __('Cancel') }}</option>
                                                        </select>

                                                        <div class="btn-sv my-4">
                                                            <input type="hidden" name="no_transaction" id="no_transaction" value="{{ $transaction->no_transaction }}">
                                                            <a id="prosess_transaksi" class="btn btn-md rounded rounded-3 col-md-12 btn-custome">{{ __('Proceed') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($transaction->status == 'ON PROGRESS')
                                            <div class="col-md-12">
                                                <div class="btn-sv d-flex justify-content-center align-content-center my-4">
                                                    <input type="hidden" name="no_transaction" id="no_transaction" value="{{ $transaction->no_transaction }}">
                                                    <input type="hidden" name="status" id="status" value="DONE">

                                                    <a id="transaksi_done" class="btn btn-md rounded rounded-3 col-md-2 btn-custome">{{ __('Done') }}</a>
                                                </div>
                                            </div>
                                        @elseif ($transaction->status == 'ON COMPLAINT')
                                            <div class="col-md-12">
                                                <div class="btn-sv d-flex justify-content-center align-content-center my-4">
                                                    <input type="hidden" name="no_transaction" id="no_transaction" value="{{ $transaction->no_transaction }}">
                                                    <input type="hidden" name="status" id="status" value="DONE">

                                                    <a id="done_complaint" class="btn btn-md rounded rounded-3 col-md-2 btn-custome">{{ __('Done') }}</a>
                                                </div>
                                            </div>
                                        @elseif ($transaction->status == 'DONE')
                                            @if ($transaction->waranty == null)
                                                {{--  create btn for create invoice  --}}
                                                <div class="col-md-12">
                                                    <div class="btn-sv d-flex justify-content-center align-content-center my-4">
                                                        <input type="hidden" name="no_transaction" id="no_transaction" value="{{ $transaction->no_transaction }}">
                                                        <a id="create_invoice" href="{{ route('create-invoice', ['id' => $transaction->no_transaction]) }}" class="btn btn-md rounded rounded-3 col-md-2 btn-custome">{{ __('Create Invoice') }}</a>
                                                    </div>
                                                </div>
                                            @else
                                                {{--  create btn for create invoice  --}}
                                                <div class="col-md-12">
                                                    <div class="btn-sv d-flex justify-content-center align-content-center my-4">
                                                        <input type="hidden" name="no_transaction" id="no_transaction" value="{{ $transaction->no_transaction }}">
                                                        <a id="view_invoice" href="{{ route('view-invoice', ['id' => $transaction->no_transaction]) }}" class="btn btn-md rounded rounded-3 col-md-2 btn-custome">{{ __('View Invoice') }}</a>
                                                    </div>
                                                </div>

                                            @endif
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
</section>

@include('includes.adminDashboard.modal.service-confirmation')

@endsection


@section('additional-script')
    <script>
        $('#status_select').select2({
            placeholder: "Select Status",
            thema: "bootstrap-5",
        });

        $('#prosess_transaksi').click(function() {
            var status          = $('#status_select').val();
            var merchant_note   = $('#merchant_note').val();
            var no_transaction  = $('#no_transaction').val();

            if ( status == '' )
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select status!',
                });
            } else {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to update status for this transaaction?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3c10fe5',
                    confirmButtonText: 'Yes, send it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#prosess_transaksi').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        $('#prosess_transaksi').addClass('disabled');

                        if ( status == 'DONE' )
                        {
                            $.ajax({
                                url: "{{ route('update-status-transaction') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    status: status,
                                    merchant_note: merchant_note,
                                    no_transaction: no_transaction,
                                },
                                success: function(response) {
                                    if (response.message == "Success") {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(function() {
                                            window.location.href = "{{ route('create-invoice', ['id' => $transaction->no_transaction]) }}";
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.message,
                                        });
                                    }
                                },
                                error: function(response) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: response.message,
                                    });
                                }
                            });
                        } else {
                            $.ajax({
                                url: "{{ route('update-status-transaction') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    status: status,
                                    merchant_note: merchant_note,
                                    no_transaction: no_transaction,
                                },
                                success: function(response) {
                                    if (response.message == "Success") {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(function() {
                                            // reload page
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.message,
                                        });
                                    }
                                },
                                error: function(response) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: response.message,
                                    });
                                }
                            });
                        }
                    }
                });
            }

        });

        $('#transaksi_done').click(function() {
            var status          = $('#status').val();
            var no_transaction  = $('#no_transaction').val();
            var customer_id     = $('#customer_id').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want done this transaaction?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#transaksi_done').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    $('#transaksi_done').addClass('disabled');

                    $.ajax({
                        url: "{{ route('update-status-transaction') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            status: status,
                            no_transaction: no_transaction,
                        },
                        success: function(response) {
                            if (response.message == "Success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    window.location.href = "{{ route('create-invoice', ['id' => $transaction->no_transaction]) }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    });
                }
            });
        });

        $('#done_complaint').click(function() {
            var status          = $('#status').val();
            var no_transaction  = $('#no_transaction').val();
            var customer_id     = $('#customer_id').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want done this transaaction?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#done_complaint').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    $('#done_complaint').addClass('disabled');

                    $.ajax({
                        url: "{{ route('update-status-transaction') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            status: status,
                            no_transaction: no_transaction,
                        },
                        success: function(response) {
                            if (response.message == "Success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    // reload page
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    });
                }
            });

        });

        $('#submitConfirmation').click(function() {
            var no_transaction          = $('#no_transaction').val();
            var customer_id             = $('#customer_id').val();
            var service_confirmation    = $('#service_confirmation').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to send confirmation to customer?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#submitConfirmation').html('<i class="fa fa-spinner fa-spin"></i> Sending...');
                    $('#submitConfirmation').addClass('disabled');
                    $('#close').addClass('disabled');

                    $.ajax({
                        url: "{{ route('send-confirmation') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            no_transaction: no_transaction,
                            customer_id: customer_id,
                            service_confirmation: service_confirmation,
                        },
                        success: function(response) {
                            if (response.message == "Success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    // reload page
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    });
                }
            })
        });

    </script>

@endsection
