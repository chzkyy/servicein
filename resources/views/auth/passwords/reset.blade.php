@extends('layouts.auth')

@section('title')
    {{ __('Reset Password') }}
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
                            <div class="d-flex justify-content-end">
                                <div class="title-reset-password">
                                    <span class="text-titlr"> {{ __('Reset Password') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center px-5 ms-xl-3 mt-4 pt-3">
                        <div class="row">
                            <span class="title-success">{{ __('Reset Password') }}</span>
                            <span class="desc-success">{{ __('Set new password for your account') }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <div class="col-md-8">
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">
                                <input id="email" type="hidden" name="email" value="{{ $email ?? old('email') }}">

                                <div class="form-group mt-2">
                                    <label for="password" class="form-label">{{ __('New Password') }}</label>

                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror form-control-lg"
                                            id="password" name="password" required autocomplete="current-password"
                                            placeholder="Enter your password" />
                                        <div class="input-group-append input-group-text" onclick="password()">
                                            <i class="far fa-eye" id="eye"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="password-confirm" class="form-label">{{ __('Confirm New Password') }}</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="password_confirmation"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Enter your password" />

                                        <div class="input-group-append input-group-text" onclick="password_confirmation()">
                                            <i class="far fa-eye" id="eye_confirmation"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="col-12 btn btn-custome btn-lg btn-block">{{ __('Confirm') }}</button>
                                </div>

                                <span class="text-center text-secondary d-block mt-5"><i class="fa-solid fa-lock"></i>
                                    {{ __('Your Info is safely secured') }}
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
