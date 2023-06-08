@extends('layouts.auth')
@section('title', 'Booking Transaction Succes')
@section('content')
<section class="vh-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 px-0 d-none d-sm-block">
                {{--  logo  --}}
                <div class="d-flex align-item-center">
                    <div class="col-12">
                        <div class="d-flex justify-content-start">
                            <div class="logo">
                                <img src="{{ url('assets/img/Logo.png') }}" alt="logo" class="logo-img mx-5 mt-4">
                            </div>
                        </div>
                    </div>
                </div>
                {{--  image  --}}
                <div class="w-100 vh-100 c-img-login"></div>
                {{--  text  --}}
                <div class="d-flex align-item-center">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            <div class="qoute"></div>
                            <div class="text">
                                {{ __('We understand the importance of your laptops and the impact it has on your daily life, which is why we offer fast and reliable services such as repairs, upgrades, and maintenance. Our goal is to provide you with exceptional service that exceeds your expectations.') }}
                            </div>
                            <div class="vector"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 text-black">
                <div class="d-flex justify-content-center align-items-center px-5 mt-5 ms-xl-4 pt-xl-0 mt-xl-n5">
                    <div class="col-md-12 mt-5">
                        <div class="d-block text-center justify-content-center align-content-center">
                            <div class="row">
                                <span class="title-success">{{ __('Your order has been made!') }}</span>
                                <span class="txt-secondary">{{ __('Your transaction has been successfully made.') }}</span>
                            </div>

                            <div class="icon-success mt-5">
                                <img src="{{ url('assets/img/success.png') }}" alt="icon-success">
                            </div>

                            <div class="back-transaction mt-5">
                                <a href="{{ route('show-transaction') }}" class="btn btn-custome btn-md btn-block col-md-6">{{ __('Transcation List') }}</a>
                            </div>

                            <div class="back-home mt-3">
                                <a href="{{ route('home') }}" class="btn btn-custome-outline btn-md btn-block col-md-6">{{ __('Back to homepage') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
