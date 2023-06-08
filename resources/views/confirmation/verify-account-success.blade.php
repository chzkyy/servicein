@extends('layouts.auth')
@section('title', 'Verification Account')
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
                                {{ __("We understand the importance of your laptops and the impact it has on your daily life, which is why we offer fast and reliable services such as repairs, upgrades, and maintenance. Our goal is to provide you with exceptional service that exceeds your expectations.") }}
                            </div>
                            <div class="creator blockquote-footer mt-4">
                                Vincent Obi
                            </div>
                            <div class="vector"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 text-black">
                <div class="d-flex align-item-center px-5 mt-2 pt-4 mb-3 pb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <div class="create-account">
                                <span class="text-create-account txt-secondary"> {{ __('Verification Account') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center px-5 ms-xl-4 mt-5 pt-4 pt-xl-0 mt-xl-n5">
                    <div class="col-md-12 mt-5">
                        <div class="d-block text-center justify-content-center align-content-center">
                            <div class="row">
                                <span class="title-success">{{ __('Verification Success!') }}</span>
                                <span class="txt-secondary">{{ __('Your account successfully verified.') }}</span>
                            </div>

                            <div class="icon-success mt-5">
                                <img src="{{ url('assets/img/success.png') }}" alt="icon-success">
                            </div>

                            <div class="back-login mt-5">
                                <a href="{{ route('login') }}" class="btn btn-custome btn-lg btn-block col-md-6">{{ __('Back to Login') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
