@extends('layouts.dashboard')

@section('title')
    {{ __('Profile') }}
@endsection

@section('content')
    <section class="vh-100">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ __('Success') }}!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-sm-12 col-md-2 offset-md-1 pt-5 mt-5">
                            <div class="card d-flex justify-content-center align-items-center">

                                <div class="card-body">

                                    @if ($avatar == null)
                                        <img src="{{ asset('assets/img/profile_picture.png') }}"
                                            class="img-fluid img-thumbnail" alt="profile_picture">
                                    @elseif ($avatar != null)
                                        <img src="{{ $avatar }}" class="img-fluid img-thumbnail d-block mx-auto"
                                            alt="profile_picture" style="width: 150px; height: 150px;">
                                    @endif

                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('edit.profile') }}" class="btn btn-link btn-sm mt-3"><i
                                                class="fa-solid fa-pen-to-square"></i> Edit Profile</a>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        @if (Auth::user()->password != NULL)
                                            <a href="{{ route('change-password') }}" class="btn btn-link btn-sm"><i class="fa-solid fa-lock-open"></i> {{ __("Change Password") }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{--  my device list  --}}

                            <div class="mt-3 d-flex justify-content-center align-items-center">
                                <a href="#" class="btn btn-custome btn-sm mt-2">My Device List</a>
                            </div>

                            <div class="d-none d-md-flex justify-content-center align-items-center b-profile txt-gold mb-5">
                                <div class="chart-container">
                                    <div class="gauge-wrap" data-value="{{ $percentage }}">
                                        <span class="percent txt-gold fw-semibold">{{ $percentage }}%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-block d-md-none progress mt-5 mb-2">
                                <div class="progress-bar bg-custome" role="progressbar" style="width: {{ $percentage }}%;"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $percentage }}%</div>
                            </div>

                            <div class="d-flex justify-content-center align-items-center txt-gold mb-5">
                                <span class="fw-semibold text-bar">Profile Completion</span>
                            </div>

                        </div>

                        <div class="col-md-8 offset-md-1 pt-md-5 mt-md-5">
                            <div class="card">
                                <div class="card-body txt-third m-4">
                                    {{--  full name  --}}
                                    <div class="fullname mb-4">
                                        <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                                        <span class="mx-2 fw-semibold">
                                            {{ Auth::user()->username }}
                                        </span>
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
                                                @if ( $customer->dob == null )
                                                    {{ __('-') }}
                                                @else
                                                    <span>{{ date('d/m/Y', strtotime($customer->dob)) }}</span>
                                                @endif
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
                                                <span>
                                                    {{ preg_replace('/\d{3}/', '($0) - ', str_replace('.', null, trim($customer->phone_number)), 1) }}
                                                </span>
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
    </section>
@endsection

@section('additional-script')
    <script>
        $(document).ready(function() {
            $('.gauge-wrap').simpleGauge({
                width:'120',
                hueLow:'0',
                hueHigh:'0',
                saturation:'0%',
                lightness:'0%',
                gaugeBG:'#fff',
                parentBG:'#fff'
            });
        });
    </script>
@endsection
