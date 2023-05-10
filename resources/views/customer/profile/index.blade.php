@extends('layouts.dashboard')

@section('title')
    {{ __('Profile') }}
@endsection

@section('content')
    <section class="vh-100">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12">
                    <div class="row mt-4">
                        <div class="d-flex justify-content-around pt-5 mt-5">
                            <div class="col-md-2">
                                <div class="card d-flex justify-content-center align-items-center">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/img/profile_picture.png') }}"
                                            class="img-fluid img-thumbnail" alt="profile_picture">

                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('edit.profile') }}" class="btn btn-primary btn-sm mt-3"><i
                                                    class="fa-solid fa-pen-to-square"></i> Edit Profile</a>
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('change-password') }}" class="btn btn-primary btn-sm mt-3"><i
                                                    class="fa-solid fa-lock-open"></i> Change Password</a>
                                        </div>
                                    </div>
                                </div>
                                {{--  my device list  --}}

                                <div class="mt-3 d-flex justify-content-center align-items-center">
                                    <a href="#" class="btn btn-custome btn-sm mt-2">My Device List</a>
                                </div>

                                <div class="b-profile txt-gold">
                                    <div class="container">
                                        <div class="row">
                                            <div class="p-item center-block">
                                                <div class="chart-container">
                                                    <div class="chart " data-percent="{{ $percentage }}" data-bar-color="#E3C10F">
                                                        <span class="percent" data-after="%">{{ $percentage }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center align-items-center txt-gold mb-5">
                                                <span class="fw-semibold text-bar">Profile Completion</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body txt-third m-4">
                                        {{--  full name  --}}
                                        <div class="fullname mb-4">
                                            <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                                            <span class="mx-2 fw-semibold">{{ $customer->fullname }}</span>
                                        </div>

                                        {{--  General Information  --}}
                                        <div class="h5 txt-gold my-4">General Information</div>

                                        <div class="detail-profile">
                                            <div class="fullname mb-2">
                                                <span class="fw-semibold">Fullname</span>
                                                <div class="data">
                                                    <span>{{ $customer->fullname }}</span>
                                                </div>
                                            </div>

                                            <div class="gender mb-2">
                                                <span class="fw-semibold">Gender</span>
                                                <div class="data">
                                                    <span>{{ $customer->gender }}</span>
                                                </div>
                                            </div>

                                            <div class="dob mb-2">
                                                <span class="fw-semibold">Birth Date</span>
                                                <div class="data">
                                                    <span>{{ $customer->dob }}</span>
                                                </div>
                                            </div>

                                        </div>

                                        <hr class="border border-gold border-1 opacity-50 mx-4">

                                        {{--  Contact Information  --}}
                                        <div class="h5 txt-gold my-4">Contact Detail</div>

                                        <div class="detail-profile">
                                            <div class="phone-number mb-2">
                                                <span class="fw-semibold">Phone Number</span>
                                                <div class="data">
                                                    <span>{{ $customer->phone_number }}</span>
                                                </div>
                                            </div>

                                            <div class="email mb-2">
                                                <span class="fw-semibold">Email</span>
                                                <div class="data">
                                                    <span>{{ Auth::user()->email }}</span>
                                                </div>
                                            </div>

                                            <div class="cust_addrs mb-2">
                                                <span class="fw-semibold">Address</span>
                                                <div class="data">
                                                    <span>{{ $customer->cust_address }}</span>
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
