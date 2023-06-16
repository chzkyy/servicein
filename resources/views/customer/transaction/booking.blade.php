@extends('layouts.dashboard')

@section('title')
    {{ __('Booking Merchant') }}
@endsection

@section('content')
    <section>
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12 mx-2 my-5 pt-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 my-4">
                                <div class="title d-flex align-items-center">
                                    <div class="back">
                                        <small class="fw-semibold">
                                            <a href="{{ url()->previous() }}" class="btn btn-light"> <i
                                                    class="fa fa-chevron-left" aria-hidden="true"></i>
                                                {{ __('Back') }}</a>
                                        </small>
                                    </div>

                                </div>
                            </div>

                            @if (session('success'))
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ __('Success') }}!</strong> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            <div class="container">
                                <div class="col md-12">
                                    <div class="card border border-2">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-center align-content-center mb-4">
                                                <div class="text-center fw-semibold">
                                                    {{ __('Booking Confirmation Page') }}
                                                </div>
                                            </div>

                                            <form id="form_booking">
                                                @csrf
                                                <div class="container pt-4">
                                                    <div class="store-name">
                                                        <div class="col-md-12 mb-2">
                                                            <div class="label-store">
                                                                <label for="store_name"
                                                                    class="txt-gold form-label fw-semibold">{{ __('Store Name :') }}</label>
                                                            </div>

                                                            <div class="store_name">
                                                                <span>{{ ucwords($merchant->merchant_name) }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="label-booking-date">
                                                                <label for="booking-date"
                                                                    class="txt-gold form-label fw-semibold">{{ __('Booking Date') }}<span class="text-danger">{{ __('* :') }}</span></label>
                                                            </div>

                                                            <div class="booking-date">
                                                                <input class="form-control" id="booking_date" autocomplete="off"
                                                                    name="booking_date" placeholder="dd/mm/yyyy" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-7 mb-2">
                                                            <div class="label-booking-time">
                                                                <label for="booking-time"
                                                                    class="txt-gold form-label fw-semibold">{{ __('Pick time to book') }}<span class="text-danger">{{ __('* :') }}</span></label>
                                                            </div>

                                                            <div class="booking-time">
                                                                <div class="col-md-12" id="d-time-label">
                                                                    {{-- @foreach ($time as $item)
                                                                        <label>
                                                                            <input type="radio" name="booking_time" id="booking_time" class="card-input-element" value="{{ $item }}" required/>
                                                                            <div class="card card-default card-input shadow shadow-md">
                                                                                <div class="card-header">{{ $item }}</div>
                                                                            </div>
                                                                        </label>
                                                                    @endforeach --}}

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="label-list-device">
                                                                <label for="list-device"
                                                                    class="txt-gold form-label fw-semibold">{{ __('My Device List') }}<span class="text-danger">{{ __('* :') }}</span></label>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <select name="device_id" id="device_id" class="form-control form-control-md select2" required></select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <a data-bs-toggle="modal" data-bs-target="#addDevice" class="btn btn-custome btn-sm fw-normal">{{ __('+ Add New Device') }}</a>
                                                                </div>

                                                            </div>
                                                        </div>



                                                        <div class="col-md-6 my-3">
                                                            <div class="label-note">
                                                                <label for="note"
                                                                    class="txt-gold form-label fw-semibold">{{ __('Note') }}<span class="text-danger">{{ __('* :') }}</span></label>
                                                            </div>
                                                            <div class="my-2">
                                                                <textarea name="user_note" id="user_note" class="form-control" cols="20" rows="3"></textarea>
                                                            </div>

                                                        </div>


                                                    </div>

                                                    <div class="col-md-12 my-4">
                                                        <input type="hidden" name="merchant_id" id="merchant_id" value="{{ $merchant->id }}">
                                                        <div class="btn-booking d-flex justify-content-center align-content-center">
                                                            <button id="btn_confirmBooking" class="btn btn-custome btn-sm fw-normal">{{ __('Confirm Booking') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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

    @include('includes.customer.modal.addDevice')
@endsection


@section('additional-script')
    <script>
        function preview_AddDevice() {
            const avatar = document.querySelector('#device_image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const OFReader = new FileReader();
            OFReader.readAsDataURL(avatar.files[0]);

            OFReader.onload = function(OFREvent) {
                imgPreview.src = OFREvent.target.result;
            }
        }

        $('#booking_date').datepicker({
            uiLibrary: 'bootstrap5',
            iconsLibrary: 'fontawesome',
            showRightIcon: true,
            size: 'small',
            format: 'dddd, dd mmmm yyyy',
            autoclose: true,
            minDate: function() {
                var date = new Date();
                date.setDate(date.getDate()); //set min date to today
                return new Date(date.getFullYear(), date.getMonth(), date.getDate());
            },
            maxDate: function() {
                var date = new Date();
                date.setDate(date.getDate() + 30);
                return new Date(date.getFullYear(), date.getMonth(), date.getDate());
            }
        });

        // get value from datepicker
        $('#booking_date').change(function() {
            var date = $(this).val();
            var newDate = new Date(date);
            var format = newDate.toLocaleDateString('en-CA', {
                day: 'numeric',
                month: 'numeric',
                year: 'numeric'
            });


            // call ajax to get time list
            $.ajax({
                url: "{{ route('get-time-booking') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    booking_date: format,
                    merchant_id: $('#merchant_id').val()
                },
                success: function(response) {
                    var html = '';
                    var string1 = JSON.stringify(response);
                    const arr = JSON.parse(string1);
                    for (let i = 0; i < arr.length; i++) {
                        html += '<label>';
                        html += '<input type="radio" name="booking_time" id="booking_time" class="card-input-element" value="' + arr[i] + '" required/>';
                        html += '<div class="card card-default card-input shadow shadow-md">';
                        html += '<div class="card-header">' + arr[i] + '</div>';
                        html += '</div>';
                        html += '</label>';
                    }


                    $('#d-time-label').html(html);
                }
            });
        });

        $(document).ready(function() {
            // call ajax to get device list
            $('#device_id').select2({
                placeholder: "Select Device",
                ajax: {
                    url: "{{ route('get-list-device') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    //search device by name
                    data: function (params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results:  $.map(response, function (item) {
                                // console.log(item);
                                return {
                                    text: item.device_name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });

        // click button confirm booking
        $('#btn_confirmBooking').click(function(e) {
            e.preventDefault();
            var form = $('#form_booking');
            var url = form.attr('action');
            var data = form.serialize();
            // console.log(data);

            //get data form date
            var date = $('#booking_date').val();
            var time = $('input[type=radio][name=booking_time]:checked').val();
            var device = $('#device_id option:selected').text();

            // jika data bekum lengkap maka akan muncul alert
            if ( device == null || time == null || date == null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please complete the form',
                });
            } else {
                // jika data sudah lengkap maka akan muncul alert
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will book an apointment with {{ ucwords($merchant->merchant_name) }} to repair "+device+" on "+date+", "+time+" WIB",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3c10fe5',
                    confirmButtonText: '{{ __("Yes, Confirm Booking") }}'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('#btn_confirmBooking').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        $('#btn_confirmBooking').addClass('disabled');

                        $.ajax({
                            type: "POST",
                            url: "{{ route('store-booking') }}",
                            data: data,
                            success: function(response) {
                                if (response['status'] == 'success')
                                {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response['message'],
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    setTimeout(function() {
                                        window.location.href = "{{ route('success-booking') }}";
                                    }, 1500);
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!!'
                                });
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
