@extends('layouts.dashboard')

@section('title')
    {{ __('View Invoice') }}
@endsection


@section('content')
<section class="min-vh-100 mt-5">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="container pt-5">
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
                                            <div class="col-md-7">
                                                <div class="merchant_name fw-semibold fs-5">{{ $merchant['merchant_name'] }}</div>
                                                <div class="bussines-info my-2">
                                                    <div class="bussines-phone txt-gold fs-6 fw-semibold">{{ __('Bussiness Phone Number') }}</div>
                                                    {{--  format number  --}}
                                                    {{--  substr format amgka dari belakang  --}}
                                                    <div class="bussines-phone">{{ substr($merchant->phone_number, -12, -9) . " " . substr($merchant->phone_number, -9, -5) . " " . substr($merchant->phone_number, -5) }}</div>
                                                </div>
                                                <div class="device-info">
                                                    <div class="device-service txt-gold fs-6 fw-semibold">{{ __("Service Device : ") }} <span class="fw-normal txt-black">{{ $transaction->device_name }}</span> </div>
                                                    <div class="device-service txt-gold fs-6 fw-semibold">{{ __("Transaction ID : ") }} <span class="fw-normal txt-black">{{ $transaction->no_transaction }}</span> </div>
                                                    <div class="device-service txt-gold fs-6 fw-semibold">{{ __("Status : ") }} <span class="fw-normal txt-black badge bg-success">{{ $transaction->status }}</span> </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="txt-gold fw-semibold fs-6">{{ __('Warranty') }}</div>
                                                        @if ( $transaction->waranty == null)
                                                            {{ __('-') }}
                                                        @else
                                                            <div class="txt-black">{{ date("d M Y", strtotime($transaction->waranty)) }}</div>
                                                        @endif
                                                    </div>
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
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="fw-semibold txt-gold">{{ __('Description') }}</p>
                                                        <div class="row my-2">
                                                            <div class="fw-semibold txt-gold">{{ __('Merchant Note') }}</div>
                                                            <div class="txt-black">{{ $transaction->merchant_note }}</div>
                                                        </div>

                                                        <div class="row my-2">
                                                            <div class="fw-semibold txt-gold">{{ __('Detail Transaction') }}</div>
                                                            @foreach ($transaction_detail as $dtl )
                                                            <div class="txt-black col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-6 text-wrap">{{ $dtl->transaction_desc }}</div>
                                                                    <div class="col-md-6">Rp. {{ number_format($dtl->transaction_price, 2, ',', '.') }}</div>

                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>

                                                        <hr>

                                                        <div class="row my-2">
                                                            <div class="txt-black col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-6 fw-semibold txt-gold">{{ __('Total') }}</div>
                                                                    <div class="col-md-6">Rp. {{ number_format($total, 2, ',', '.') }}</div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
        </div>
    </div>
</section>
@endsection
