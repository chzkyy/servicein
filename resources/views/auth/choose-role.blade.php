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
            <div class="col-md-7 mt-5 pt-4">
                <div class="d-block align-items-center px-5 ms-xl-3 mt-4 pt-3 mb-5">
                    <div class="row">
                        <span class="title-choose-role">{{ __('Choose Your Account Type!') }}</span>
                        <span class="desc-choose-role text-wrap col-md-8">{{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor!') }}</span>
                    </div>
                </div>

                <div class="d-flex align-items-center px-5 ms-xl-4 mt-4 pt-4 pt-xl-0 mt-xl-n5">
                    <div class="col-md-8">
                        <form method="POST" id="formRole" action="{{ route('store.role') }}">
                            @csrf
                            <a class="text-decoration-none" onclick="chooseRole('User')">
                                <div class="card card-choose-role">
                                    <div class="card-body shadow-lg">
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
                                                {{--  <div class="col-md-1 d-none icon-choose">
                                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                </div>  --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a class="text-decoration-none" onclick="chooseRole('Admin')">
                                <div class="card card-choose-role mt-4">
                                    <div class="card-body shadow-lg">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-3 align-content-center justify-content-center d-flex">
                                                    <img src="{{ url('assets/img/seller.png') }}" class="img-fluid" alt="seller">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <span class="text-role text-black text-center text-md-start">{{ __('Seller') }}</span>
                                                        <span class="desc-role txt-secondary">{{ __('Own or belong to a company, this is for you..') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <input type="hidden" name="role" id="role">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function chooseRole(role) {
        document.getElementById('role').value = role;
        document.getElementById('formRole').submit();
    }
</script>

@endsection
