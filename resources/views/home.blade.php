@extends('layouts.dashboard')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <section class="vh-100">
        {{--  Jumbotron   --}}
        <div class="p-5 text-center bg-image jdashboard">
            <div class="mask pt-5">
                <div class="d-flex justify-content-center align-items-center pt-5 mt-5">
                    <div class="text-white pt-5">
                        <h1 class="mb-3">{{ __('Your solution in service') }}</h1>
                        <h4 class="mb-3">{{ __('Find a way to repair your device in one website') }}</h4>
                        <a class="btn btn-custome btn-lg" href="#book_merchant" role="button">Book Now</a>
                    </div>
                </div>
            </div>
        </div>

        {{--  content   --}}
        <div class="containe my-4">
            <div class="col-md-12 px-5">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center align-content-center">
                        <div class="col-md-8 justify-content-center align-content-center">
                            <img src="{{ url('assets/img/banner.png') }}" class="img-fluid" alt="banner">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex justify-content-start align-items-start">
                            <div class="txt-third mt-2">
                                <h1 class="mb-2 text-title-dashboard fw-semibold">{{ __('Why Using Service.in ?') }}</h1>
                                <div
                                    class="d-flex justify-content-center align-items-center justify-content-md-start align-items-md-center">
                                    <hr class="border border-cust border-2 opacity-50 TitleLine">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <div class="icon mt-2">
                                        <i class="fa-solid fa-truck-fast fa-2xl txt-primary"></i>
                                    </div>
                                    <div class="mx-4 txt-third descText">
                                        <h6 class="uppercase fw-semibold">{{ __('Nearest Store') }}</h6>
                                        <p>{{ __('Showing the nearest store available. We prioritize the nearest store for your device repairment service.') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <div class="icon mt-2">
                                        <i class="fa-solid fa-arrow-rotate-left fa-2xl txt-primary"></i>
                                    </div>
                                    <div class="mx-4 txt-third descText">
                                        <h6 class="uppercase fw-semibold">{{ __('Free Complaint') }}</h6>
                                        <p>{{ __('Aftersales complaint guarantee. We will help you communicate with the store even after the device was done.') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <div class="icon mt-2">
                                        <i class="fa-solid fa-fingerprint fa-2xl txt-primary"></i>
                                    </div>
                                    <div class="mx-4 txt-third descText">
                                        <h6 class="uppercase fw-semibold">{{ __('Community Trusted') }}</h6>
                                        <p>{{ __('Handled by experienced store and technician only. We curated the store that already have a good review and professional Technician.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{--  end content  --}}

        <div class="my-5 d-flex justify-content-center align-items-center">
            <hr class="border border-cust border-1 opacity-50 w-75">
        </div>
        {{--  content 2  --}}
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="d-flex justify-content-center align-items-center txt-third mt-5" id="book_merchant">
                    <h1 class="mb-2 text-title-dashboard fw-semibold">{{ __('BOOK OUR SERVICE BELOW') }}</h1>
                </div>

                {{--  product card --}}
                <div class="container">
                    <div class="row justify-content-center align-items-center txt-third mt-5">
                        <div class="card mt-2 mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 my-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{ asset('assets/img/example-img-merchant.png') }}" class="card-img-top" alt="...">
                                                {{--  rate  --}}
                                                <div class="rate">
                                                    <div class="col-12 container">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div
                                                                    class="d-flex justify-content-start align-items-center">
                                                                    <div
                                                                        class="star d-block justify-content-center align-items-center">
                                                                        <div class="star text-center">
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #ffa800;"></i>
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #ffa800;"></i>
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #ffa800;"></i>
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #ffa800;"></i>
                                                                        </div>
                                                                        <div class="star-desc">
                                                                            <span>4.5 out of 5.0</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <div
                                                                        class="distance d-block justify-content-center align-items-center">
                                                                        <div class="distance text-center">
                                                                            <i class="fa-solid fa-map-location-dot"
                                                                                style="color: #ffa800;"></i>
                                                                        </div>
                                                                        <div class="star-desc">
                                                                            <span>4,5 KM</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center my-3">
                                                    <a href="#" class="btn btn-custome btn-sm">{{ __("Book this Service") }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 my-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{ asset('assets/img/example-img-merchant.png') }}" class="card-img-top" alt="...">
                                                {{--  rate  --}}
                                                <div class="rate">
                                                    <div class="col-12 container">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div
                                                                    class="d-flex justify-content-start align-items-center">
                                                                    <div
                                                                        class="star d-block justify-content-center align-items-center">
                                                                        <div class="star text-center">
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #ffa800;"></i>
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #ffa800;"></i>
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #ffa800;"></i>
                                                                            <i class="fa-solid fa-star"
                                                                                style="color: #ffa800;"></i>
                                                                        </div>
                                                                        <div class="star-desc">
                                                                            <span>4.5 out of 5.0</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="d-flex justify-content-end align-items-center">
                                                                    <div
                                                                        class="distance d-block justify-content-center align-items-center">
                                                                        <div class="distance text-center">
                                                                            <i class="fa-solid fa-map-location-dot"
                                                                                style="color: #ffa800;"></i>
                                                                        </div>
                                                                        <div class="star-desc">
                                                                            <span>4,5 KM</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center my-3">
                                                    <a href="#" class="btn btn-custome btn-sm">{{ __("Book this Service") }}</a>
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
