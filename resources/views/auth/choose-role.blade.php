@extends('layouts.auth')
@section('title', 'Choose Role')
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
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                            </div>
                            <div class="creator blockquote-footer mt-4">
                                Vincent Obi
                            </div>
                            <div class="vector"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="d-block align-items-center px-5 ms-xl-3 mt-4 pt-4 mb-5">
                    <div class="row">
                        <span class="title-choose-role">{{ __('Choose Your Account Type!') }}</span>
                        <span class="desc-choose-role text-wrap col-md-8">{{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor!') }}</span>
                    </div>
                </div>

                <div class="d-flex align-items-center px-5 ms-xl-4 mt-4 pt-4 pt-xl-0 mt-xl-n5">
                    <div class="col-md-8">
                        <form method="POST" id="formRole" action="{{ route('store.role') }}">
                            @csrf

                            {{--  choose role radio with card  --}}
                            <label>
                                <input type="radio" name="role" id="role" class="card-input-element d-none" value="User">
                                <div class="card card-body shadow-lg bg-light d-flex flex-row justify-content-between align-items-center">

                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-3 align-content-center justify-content-center d-flex">
                                                <img src="{{ url('assets/img/individual.png') }}" class="img-fluid" alt="individual">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <span class="text-role text-black text-center text-md-start">{{ __('Individual') }}</span>
                                                    <span class="desc-role txt-secondary">{{ __('Personal account to manage all you activities.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </label>

                            <label class="mt-3 mb-5">
                                <input type="radio" name="role" id="role" class="card-input-element d-none" value="Admin">
                                <div class="card card-body shadow-lg bg-light d-flex flex-row justify-content-between align-items-center">

                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-3 align-content-center justify-content-center d-flex">
                                                <img src="{{ url('assets/img/seller.png') }}" class="img-fluid" alt="Business">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <span class="text-role text-black text-center text-md-start">{{ __('Business') }}</span>
                                                    <span class="desc-role txt-secondary">{{ __('Own or belong to a company, this is for you.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </label>

                            {{--  button submit  --}}
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" class="btn btn-custome col-md-8 btn-lg btn-block">{{ __('Confirm Role') }}</button>
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
