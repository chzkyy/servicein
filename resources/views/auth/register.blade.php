@extends('layouts.auth')

@section('title')
    {{ __('Register') }}
@endsection

@section('content')
    <section class="min-vh-100">
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
                    <div class="d-flex align-item-center px-5 mt-2 pt-4">
                        <div class="col-12">
                            <div class="d-none d-sm-flex justify-content-between">
                                <div class="back">
                                    <a href="{{ route('login') }}" class="txt-secondary fw-semibold"><i class="fa fa-chevron-left fa-xs" aria-hidden="true"></i> {{ __('Back') }}</a>
                                </div>
                                <div class="create-account">
                                    <span class="text-create-account"> {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="txt-primary fw-semibold">{{ __('Sign in') }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex d-md-none align-items-center justify-content-center py-5 mb-4 pb-4">
                        <img src="{{ url('assets/img/Logo2.png') }}" alt="logo" class="logo-img">
                    </div>

                    <div class="d-flex align-items-center px-5 ms-xl-3 mt-3 pt-3">
                        <div class="row">
                            <span class="text-login">{{ __('Register Account') }}</span>
                            <span class="desc-login">{{ __('Please fill your account information below') }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center px-5 ms-xl-4 mt-3 pt-3 pt-xl-0 mt-xl-n5">
                        <div class="col-md-12">
                            <form action="{{ route('register') }}" method="post">
                                @csrf

                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <div class="form-group my-2">
                                            <label for="username" class="form-label">{{ __('Username') }}</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror form-control-lg" id="username" name="username"
                                                value="{{ old('username') }}" placeholder="Enter username" required
                                                autocomplete="username" autofocus />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group my-2">
                                            <label for="email" class="form-label">{{ __('Email address') }}</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror form-control-lg"
                                                id="email" name="email" value="{{ old('email') }}"
                                                placeholder="Enter email address" required autocomplete="email" autofocus />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group my-2">
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror form-control-lg input-group"
                                                    id="password" name="password" required autocomplete="current-password"
                                                    placeholder="Enter your password" />

                                                <div class="input-group-append input-group-text" onclick="password()">
                                                    <i class="far fa-eye" id="eye"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group my-2">
                                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control form-control-lg" id="password_confirmation"
                                                    name="password_confirmation" required autocomplete="new-password"
                                                    placeholder="Enter your password" />

                                                <div class="input-group-append input-group-text" onclick="password_confirmation()">
                                                    <i class="far fa-eye" id="eye_confirmation"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3 term">
                                    <input class="form-check-input checkbox @error('tnc') is-invalid @enderror" type="checkbox" name="tnc" id="tnc" {{ old('tnc') ? 'checked' : '' }} onclick="return true" />
                                    <label for="tnc" class="checkbox-label txt-primary fw-semibold">{{ __('I agree to the') }}
                                        {{--  call modal terms and conditions  --}}
                                        <a data-bs-toggle="modal" data-bs-target="#terms-and-conditions" class="txt-primary fw-bold">{{ __('Terms and Conditions') }}</a>
                                    </label>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="col-12 btn btn-custome btn-lg btn-block">{{ __('Register') }}</button>
                                </div>

                                <div class="form-group mt-4">
                                    <a href="{{ route('redirect') }}"
                                        class="col-12 btn btn-with-google btn-lg btn-block btn-google">
                                        <img src="{{ url('assets/img/icons_google.png') }}" alt="google"
                                            class="google-icon">
                                        Register with Google
                                    </a>
                                </div>

                                <div class="create-account text-center my-4 d-block d-md-none text-center">
                                    <span class="text-create-account"> {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="txt-primary fw-semibold">{{ __('Sign in') }}</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('policy.terms-and-conditions')
@endsection
