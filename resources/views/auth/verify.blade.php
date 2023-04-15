@extends('layouts.auth')
@section('title', 'Verify Account')
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
                            <div class="text mt-4">
                                <p>{{ __("We understand the importance of your laptops and the impact it has on your daily life, which is why we offer fast and reliable services such as repairs, upgrades, and maintenance. Our goal is to provide you with exceptional service that exceeds your expectations.") }}</p>
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
                                <span class="text-create-account txt-secondary"> {{ __('Verify Email Address') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="col-md-12">
                        <div class="d-flex text-center justify-content-center align-content-center">
                            <div class="col-md-6 col-md-offset-3">

                                <div class="icon-verify mb-5 mt-5">
                                    <img src="{{ url('assets/img/newsletter.png') }}" class="img-fluid img-eVerify" alt="icon-newsletter">
                                </div>

                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif

                                <span class="txt-secondary text-center">{{ __('Before proceeding, please check your email for a verification link. If you didn’t receive the email.') }}</span>

                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link fw-semibold p-0 m-0 align-baseline">{{ __('Click here to request another') }}</button>.
                                </form>
                            </div>

                            {{--  <div class="back-login mt-5">
                                <a href="{{ route('login') }}" class="btn btn-custome btn-lg btn-block col-md-6">{{ __('Back to Login') }}</a>
                            </div>  --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
