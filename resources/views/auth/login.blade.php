@extends('layouts.auth')

@section('title')
    {{ __('Login') }}
@endsection

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
                    <div class="d-flex align-item-center px-5 mt-2 pt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <div class="create-account">
                                    <span class="text-create-account txt-secondary"> {{ __('New to Service.in?') }}</span>
                                    <a href="{{ route('register') }}" class="text-create-account-link txt-primary fw-semibold">Sign Up</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center px-5 ms-xl-3 mt-4 pt-3">
                        <div class="row">
                            <span class="text-login">{{ __('Login') }}</span>
                            <span class="desc-login">{{ __('Input your account credential here!') }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <div class="col-md-8">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="username" class="form-label">{{ __('Email or Username') }}</label>
                                    <input type="text"
                                        class="form-control @error('username') is-invalid @enderror @error('email') is-invalid @enderror form-control-lg"
                                        id="username" name="username" value="{{ old('username') }}"
                                        placeholder="Enter Email or Username" required autocomplete="username" autofocus />
                                </div>

                                <div class="form-group mt-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input type="password"
                                        class="form-control @error('password') is-invalid @enderror form-control-lg"
                                        id="password" name="password" required autocomplete="current-password"
                                        placeholder="Enter your password" />
                                </div>

                                <div class="form-group mt-4 remember-me">
                                    <input class="form-check-input checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="checkbox-label txt-primary">{{ __('Remember me on this computer') }}</label>
                                </div>

                                <div class="form-group mt-5">
                                    <button type="submit"
                                        class="col-12 btn btn-custome btn-lg btn-block">{{ __('Login') }}</button>
                                </div>

                                <div class="form-group mt-4">
                                    <a href="{{ route('redirect') }}"
                                        class="col-12 btn btn-with-google btn-lg btn-block btn-google">
                                        <img src="{{ url('assets/img/icons_google.png') }}" alt="google"
                                            class="google-icon">
                                        Login with Google
                                    </a>

                                    {{--  forgot password  --}}
                                    <div class="forgot-password mt-3">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link text-center d-block forgot-password-link"
                                                href="{{ route('password.request') }}">
                                                {{ __('Forgot Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
