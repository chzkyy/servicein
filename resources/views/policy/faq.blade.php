@extends('layouts.dashboard')

@section('title')
    {{ __('Detail Merchant') }}
@endsection

@section('content')
    <section class="min-vh-100 mt-5 pt-5">
        <div class="container-fluid">
            <div class="container pt-5">
                <div class="col-md-12 pt-5">
                    <div class="row">
                        <div class="d-flex justify-content-center align-content-center align-items-cexnter">
                            <div class="col-md-4">
                                <img class="img-fluid" src="{{ asset('assets/img/qna.png') }}" alt="faq">

                                {{--  BACK TO HOME  --}}
                                <div class="d-flex justify-content-center mt-5">
                                    <a href="{{ route('home') }}" class="btn btn-custome btn-lg">Back to Home</a>
                                </div>
                            </div>

                            <div class="col-md-7 offset-1">
                                <h1 class="text-center mb-4 pb-3 fw-semibold">Frequently Asked Questions</h1>

                                <div class="accordion mt-3" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                {{ __("How does the online laptop repair booking process work?") }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{ __("First you must register their account on our website then they can choose the store from the catalog on homepage or search the store on the search bar after that you can arrange booking from selected store") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button fw-semibold collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                {{ __("How can I track the progress of my laptop repair?") }}
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{ __("After you finished your booking in store catalog your transaction can be tracked at transaction list Page") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button fw-semibold collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                {{ __("Do you offer warranty or guarantees for laptop repairs?") }}
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{ __("Store will inform your warranty information on the invoice, every store have different period of warranty they provide") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFour">
                                            <button class="accordion-button fw-semibold collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                aria-expanded="false" aria-controls="collapseFour">
                                                {{ __("What areas do you serve for online laptop repair bookings?") }}
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse"
                                            aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{ __("The area that we serve for online repair is depends on the merchant you choose you can ask them directly if they capable or not in handling your problem") }}
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
