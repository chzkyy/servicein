@extends('layouts.dashboard')

@section('title')
    {{ __("Dashboard") }}
@endsection

@section('content')
    <section class="vh-100">
        {{--  Jumbotron   --}}
        <div class="p-5 text-center bg-image jdashboard">
            <div class="mask pt-5">
                <div class="d-flex justify-content-center align-items-center pt-5 mt-5">
                    <div class="text-white pt-5">
                        <h1 class="mb-3">{{ __("Your solution in service") }}</h1>
                        <h4 class="mb-3">{{ __("Find a way to repair your device in one website") }}</h4>
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
                                <div class="d-flex justify-content-center align-items-center justify-content-md-start align-items-md-center">
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
                                        <h6 class="uppercase fw-semibold">{{ __("Nearest Store") }}</h6>
                                        <p>{{ __("Showing the nearest store available. We prioritize the nearest store for your device repairment service.") }}</p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <div class="icon mt-2">
                                        <i class="fa-solid fa-arrow-rotate-left fa-2xl txt-primary"></i>
                                    </div>
                                    <div class="mx-4 txt-third descText">
                                        <h6 class="uppercase fw-semibold">{{ __("Free Complaint") }}</h6>
                                        <p>{{ __("Aftersales complaint guarantee. We will help you communicate with the store even after the device was done.") }}</p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <div class="icon mt-2">
                                        <i class="fa-solid fa-fingerprint fa-2xl txt-primary"></i>
                                    </div>
                                    <div class="mx-4 txt-third descText">
                                        <h6 class="uppercase fw-semibold">{{ __("Community Trusted") }}</h6>
                                        <p>{{ __("Handled by experienced store and technician only. We curated the store that already have a good review and professional Technician.") }}</p>
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
                        <div class="card txt-third card-merchant mx-4 mt-5">
                            <img src="{{ url('assets/img/example-img-merchant.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ __("Toko Service Jaya Abadi") }}</h5>
                                <p class="card-text">{{ __("Some quick example text to build on the card title and make up the bulk of the card's content.") }}</p>
                                <div class="text-center">
                                    <a href="#" class="btn btn-custome">{{ __("Book this Service") }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="card txt-third card-merchant mx-4 mt-5">
                            <img src="{{ url('assets/img/example-img-merchant.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ __("Toko Service Jaya Abadi") }}</h5>
                                <p class="card-text">{{ __("Some quick example text to build on the card title and make up the bulk of the card's content.") }}</p>
                                <div class="text-center">
                                    <a href="#" class="btn btn-custome">{{ __("Book this Service") }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="card txt-third card-merchant mx-4 mt-5">
                            <img src="{{ url('assets/img/example-img-merchant.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ __("Toko Service Jaya Abadi") }}</h5>
                                <p class="card-text">{{ __("Some quick example text to build on the card title and make up the bulk of the card's content.") }}</p>
                                <div class="text-center">
                                    <a href="#" class="btn btn-custome">{{ __("Book this Service") }}</a>
                                </div>
                            </div>
                        </div>


                        <div class="card txt-third card-merchant mx-4 mt-5">
                            <img src="{{ url('assets/img/example-img-merchant.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ __("Toko Service Jaya Abadi") }}</h5>
                                <p class="card-text">{{ __("Some quick example text to build on the card title and make up the bulk of the card's content.") }}</p>
                                <div class="text-center">
                                    <a href="#" class="btn btn-custome">{{ __("Book this Service") }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="card txt-third card-merchant mx-4 mt-5">
                            <img src="{{ url('assets/img/example-img-merchant.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ __("Toko Service Jaya Abadi") }}</h5>
                                <p class="card-text">{{ __("Some quick example text to build on the card title and make up the bulk of the card's content.") }}</p>
                                <div class="text-center">
                                    <a href="#" class="btn btn-custome">{{ __("Book this Service") }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="card txt-third card-merchant mx-4 mt-5">
                            <img src="{{ url('assets/img/example-img-merchant.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ __("Toko Service Jaya Abadi") }}</h5>
                                <p class="card-text">{{ __("Some quick example text to build on the card title and make up the bulk of the card's content.") }}</p>
                                <div class="text-center">
                                    <a href="#" class="btn btn-custome">{{ __("Book this Service") }}</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
