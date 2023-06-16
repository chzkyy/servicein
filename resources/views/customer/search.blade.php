@extends('layouts.dashboard')

@section('title')
    {{ __('Search Merchant') }}
@endsection

@section('content')
    <section>
        {{--  content 2  --}}
        <div class="container-fluid pt-5">
            <div class="row">
                <div class="col-md-12 mt-5 pt-2">
                    <div class="container">
                        <div class="title">
                            <span class="fw-semibold ">{{ __("Showing results for") }}</span>
                            <span class="fw-semibold">"{{ $search }}"</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="container">
                    <div class="row justify-content-center align-items-center txt-third mt-5">
                        <div class="card mt-2 mb-4 border-2">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center align-items-center" id="data-container">

                                        @if ( count($transaction) > 0)
                                            @for ( $i = 0; $i < count($transaction); $i++ )

                                                <div class="col-md-3 my-3">
                                                    <div class="card border-2">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-center">
                                                                {{--  {{ $transaction[$i]['gallery'] == [] }}  --}}
                                                                @if ( !isset($transaction[$i]['gallery']) )
                                                                    <img src="{{ asset('assets/img/no-image.jpg') }}" class="card-img-top object-fit-cover img-thumbnail" style="width:350px;  height:130px;" alt="image_toko"
                                                                @endif
                                                                <img src="{{ $transaction[$i]['gallery'][0] }}" class="card-img-top object-fit-cover img-thumbnail" style="width:350px;  height:130px;" alt="image_toko">
                                                            </div>
                                                            <div class="title text-center fw-semibold my-2" id="Merchant_name">{{ $transaction[$i]['merchant_name'] }}</div>

                                                            <div class="rate">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="d-flex justify-content-center align-items-center">
                                                                                <div class="star d-block justify-content-center align-items-center">
                                                                                    <div class="star text-center">
                                                                                        <i class="fa-solid fa-star" style="color: #ffa800;"></i>
                                                                                    </div>
                                                                                    <div class="star-desc text-center">
                                                                                        <span id="rate">{{ $transaction[$i]['rating'] }}/5 <br> <sub class="fw-semibold">Reviews</sub></span>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="d-flex justify-content-center align-items-center">
                                                                                <div class="distance d-block justify-content-center align-items-center mt-3 m-md-0">
                                                                                    <div class="distance text-center">
                                                                                        <i class="fa-solid fa-map-location-dot" style="color: #ffa800;"></i>
                                                                                    </div>
                                                                                    <div class="star-desc text-center">
                                                                                        <span id="distance">{{ $transaction[$i]['jarak'] }}<br><sub class="fw-semibold">From your location</sub> </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="d-flex justify-content-center align-items-center my-3 mx-auto">
                                                                        <a href="{{ route('detail-merchant', ['id'=> $transaction[$i]['id']]) }}" class="btn btn-custome btn-sm" id="booking">{{ __("Book this Service") }}</a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        @else
                                            {{--  create no data found  --}}
                                            <div class="alert alert-secondary text-center fade show" role="alert">
                                                <strong>{{ __('No Data Found!') }}
                                            </div>
                                        @endif
                                </div>

                                {{--  paggination  --}}
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-center align-items-center">
                                            {{ $transaction->links() }}
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

