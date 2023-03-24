@extends('layouts.auth')

@section('content')
    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-5 px-0 d-none d-sm-block">
                    {{--  logo  --}}
                    <div class="d-flex align-item-center">
                        <div class="col-12">
                            <div class="d-flex justify-content-start">
                                <div class="logo">
                                    <img src="{{ url('Assets/img/Logo.png') }}" alt="logo" class="logo-img mx-5 mt-4" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <img src="{{ url('Assets/img/img-login.png') }}" alt="Login image" class="w-100 vh-100 c-img-login" />
                </div>

                <div class="col-sm-7 text-black">
                    <div class="d-flex align-item-center px-5 mt-2 pt-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div class="back">
                                    <a href="{{ route('login') }}" class="text-back"><i class="fa fa-chevron-left fa-xs" aria-hidden="true"></i> {{ __('Back') }}</a>
                                </div>

                                <div class="email-verification">
                                    <span class="text-verification">{{ __('Email Verification') }}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">

                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center px-5 ms-xl-4 mt-4 pt-4">
                        <div class="row">
                            <span class="text-login">{{ __('Forgot Password') }}</span>
                            <span class="desc-login">{{ __('Enter your email for the verification') }}!</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <div class="col-md-8 align-items-center">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{ __('Email address') }}</label>
                                    <input type="email"
                                        class="form-control @error('email') is-invalid @enderror form-control-lg"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Enter email address" required autocomplete="email" autofocus />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    @if (session('status'))
                                        <div class="alert alert-success mt-3" role="alert">
                                            {{--  {{ session('status') }}  --}}
                                            <div class="d-block text-center text-secondary">
                                                {{ __('Password Reset Requested!') }}
                                                <br>
                                                {{ __('If you didn’t receive an email!') }},
                                                <a class="text-danger" href="{{ route('password.request') }}">{{ __('Resend') }}</a>.
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group mt-5">
                                        <button type="submit" class="col-12 btn btn-custome btn-lg btn-block">{{ __('Confirm') }}</button>
                                    </div>

                                    <span class="text-center text-secondary d-block mt-5"><i class="fa-solid fa-lock"></i>
                                        {{ __('Your Info is safely secured') }}</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
