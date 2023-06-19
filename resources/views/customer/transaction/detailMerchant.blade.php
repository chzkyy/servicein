@extends('layouts.dashboard')

@section('title')
    {{ __('Detail Merchant') }}
@endsection

@section('content')
    <section>
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="col-md-8 mt-5 pt-5">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ __('Success') }}!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="container mx-2 my-5 pt-5">
                        <div class="row">
                            <div class="col-md-12 my-4">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <small class="fw-semibold">
                                            <a href="{{ url()->previous() }}" class="btn btn-light"> <i
                                                    class="fa fa-chevron-left" aria-hidden="true"></i>
                                                {{ __('Back') }}</a>
                                        </small>
                                    </div>
                                </div>
                            </div>


                            <div class="col md-12">
                                <div class="container-fluid">
                                    <h2 class="fw-semibold title-merchant d-block d-md-none mb-4"></h2>
                                    <div class="row">
                                        <div class="d-block d-md-flex justify-content-md-between align-content-center">
                                            <div class="col-md-4 col-sm-12">
                                                <ul id="imageGallery">
                                                    @foreach ( $gallery as $img )
                                                        @if( $img == null )
                                                            <li data-thumb="{{ url('assets/img/no-image.jpg') }}" data-src="img/largeImage.jpg">
                                                                <img src="{{ url('assets/img/no-image.jpg') }}" class="img-fluid"/>
                                                            </li>
                                                        @else
                                                            <li data-thumb="{{ url($img) }}" data-src="{{ url($img) }}">
                                                                <img src="{{ url($img) }}" class="img-fluid"/>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="col-md-7 offset-1 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h2 class="fw-semibold title-merchant d-none d-md-block mb-4"></h2>

                                                        <div class="row mb-4 mt-4 mt-md-0">
                                                            <div class="col-md-4 mt-2">
                                                                <div class="star d-block justify-content-center align-items-center">
                                                                    <div class="star text-center">
                                                                        <i class="fa-solid fa-star" style="color: #ffa800;"></i>
                                                                    </div>
                                                                    <div class="star-desc text-center">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8 mt-2">
                                                                <div class="distance d-block justify-content-center align-items-center">
                                                                    <div class="distance text-center">
                                                                        <i class="fa-solid fa-map-location-dot" style="color: #ffa800;"></i>
                                                                    </div>
                                                                    <div class="destination-desc text-center">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="desc-merchant text-left text-wrap mb-3 mt-4 mt-md-0" style="white-space: pre-line;"></div>
                                                </div>
                                                <div class="col-md-12 pt-3">
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-12">
                                                            <a href="{{ route('create-booking', $id) }}"
                                                                class="btn btn-custome col-md-12">
                                                                {{ __('Book') }}
                                                            </a>
                                                        </div>

                                                        <div class="col-md-9 col-sm-12 mt-md-0 mt-3">
                                                            <a href="{{ route('chat-merchant', $id) }}" class="btn btn-custome-outline">
                                                                {{ __('Chat Merchant') }}
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row pt-5">
                                        <div class="d-flex justify-content-start align-content-center my-4 pt-3 pb-4">
                                            <div class="container-fluid">
                                                <div class="row">

                                                    <div class="col-md-3 offset-0 d-block d-md-none offset-md-1 col-sm-12">
                                                        <div class="card my-2 review border border-2 shadow my-3">
                                                            <div class="card-body">
                                                                <div class="title d-flex justify-content-center align-content-center fw-semibold">
                                                                    {{ __('Contact Detail') }}
                                                                </div>

                                                                <div class="detail d-flex justify-content-center align-content-center">
                                                                    <div class="title text-center mt-4 mb-3">
                                                                        {{ __('Open Hour') }}
                                                                        <div class="desc">
                                                                            <small class="open-house"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="detail d-flex justify-content-center align-content-center">
                                                                    <div class="title text-center mb-3">
                                                                        {{ __('Email') }}
                                                                        <div class="desc">
                                                                            <small class="email-merchant"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="detail d-flex justify-content-center align-content-center">
                                                                    <div class="title text-center mb-3">
                                                                        {{ __('Address') }}
                                                                        <div class="desc">
                                                                            <small class="address-merchant"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8 col-sm-12">
                                                        {{-- start review --}}
                                                        @if ( $review == null )
                                                            <div class="card my-2 review border border-2 shadow my-3">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 text-center   ">
                                                                            {{ __('No Review') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            @foreach ($review as $r )
                                                                <div class="card my-2 review border border-2 shadow my-3">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="row">
                                                                                    <div class="col-md-2 profile-img my-auto d-flex justify-content-center align-content-center">
                                                                                        <img src="{{ url($r['avatar']) }}"
                                                                                            class="img-circle" alt="Profile Image">
                                                                                    </div>
                                                                                    <div class="col-md-7 profile-text my-auto">
                                                                                        <h4 class="my-auto">{{ ucwords($r['username']) }}</h4>
                                                                                    </div>

                                                                                    <div class="col-md-3 rate my-auto">
                                                                                        @if ( $r['rating'] == 0 )
                                                                                            <div class="non-star d-block">
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                            </div>
                                                                                        @elseif ( $r['rating'] == 1 )
                                                                                            <div class="one-star d-block">
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                            </div>
                                                                                        @elseif ( $r['rating'] == 2 )
                                                                                            <div class="two-star d-block">
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                            </div>
                                                                                        @elseif ( $r['rating'] == 3 )
                                                                                            <div class="three-star d-block">
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                            </div>
                                                                                        @elseif ( $r['rating'] == 4 )
                                                                                            <div class="four-star d-block">
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-regular fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                            </div>
                                                                                        @elseif ( $r['rating'] == 5 )
                                                                                            <div class="five-star d-block">
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: #ffa800;"></i>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                                <div class="container">
                                                                                    <div class="review mt-4">
                                                                                        {{ ucwords($r['review']) }}
                                                                                    </div>

                                                                                    <div class="date mt-2 text-muted">
                                                                                        <small>
                                                                                            {{ date('d F Y', strtotime($r['created_at'])) }}
                                                                                        </small>
                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                        {{--  end review  --}}
                                                    </div>

                                                    <div class="col-md-3 offset-0 d-none d-md-block offset-md-1 col-sm-12 sidebar">
                                                        <div class="card my-2 review border border-2 shadow my-3">
                                                            <div class="card-body">
                                                                <div
                                                                    class="title d-flex justify-content-center align-content-center fw-semibold">
                                                                    {{ __('Contact Detail') }}</div>
                                                                <div
                                                                    class="detail d-flex justify-content-center align-content-center">
                                                                    <div class="title text-center mt-4 mb-3">
                                                                        {{ __('Open Hour') }}
                                                                        <div class="desc">
                                                                            <small class="open-house"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="detail d-flex justify-content-center align-content-center">
                                                                    <div class="title text-center mb-3">
                                                                        {{ __('Email') }}
                                                                        <div class="desc">
                                                                            <small class="email-merchant"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="detail d-flex justify-content-center align-content-center">
                                                                    <div class="title text-center mb-3">
                                                                        {{ __('Address') }}
                                                                        <div class="desc">
                                                                            <small class="address-merchant"></small>
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
            $('#imageGallery').lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 4,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left',
                auto: true,
                onSliderLoad: function(el) {
                    // console.log(el);
                    // slider
                    var slider = el.find('.light-slider');
                    slider.lightSlider({
                        slideshow: true,
                        slide: function(event, ui) {
                            //console.log(ui);
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Geolocation is not supported by this browser.',
                    });
                }
            }

            getLocation();

            function showPosition(position) {
                //alert("Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude);
                var id = window.location.href.split('/').pop();
                $.ajax({
                    // call api route
                    url: url+"/get-detail/merchant",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        origin: position.coords.latitude + ',' + position.coords.longitude,
                        merchant_id: id
                    },
                    dataType: "json",
                    success: function(data) {

                        if (data.message == "Success") {
                            var html = '';
                            // get id from url
                            // object to array
                            var arr = $.map(data.data, function(el) {
                                // if persentase is <70 then remove the data
                                // console.log(el['id']);
                                if (el['id'] == id) {
                                    return null;
                                }

                                //console.log(el);
                                return el
                            });

                            var i;
                            if (arr.length != '0') {
                                // mapping data to html
                                for (i = 0; i < arr.length; i++) {
                                    // find merchant by id
                                    var merchant = data.data.find(x => x.id == arr[i]['id']);
                                    // console.log(merchant);

                                    // append to html
                                    $(".title-merchant").append(merchant['merchant_name']);
                                    $(".desc-merchant").append(merchant['merchant_desc']);
                                    // if open hour is 9:00 then show 09:00
                                    var open = merchant['open_hour'].length == 4 ? '0' + merchant['open_hour'] :
                                        merchant['open_hour'];
                                    var close = merchant['close_hour'].length == 4 ? '0' + merchant['close_hour'] :
                                        merchant['close_hour'];
                                    $(".open-house").append(open + ' - ' + close);

                                    $(".email-merchant").append(merchant['email']);
                                    $(".address-merchant").append(merchant['merchant_address']);
                                    $(".destination-desc").html('<small class="text-muted" id="distance">'+merchant['jarak']+'<span> From your location</span></small>');
                                    $(".star-desc").html('<small id="rate" class="text-muted">'+merchant['rating']+'/5 <span>Reviews</span></small>');
                                }

                            } else {
                                var html = '';
                                html += '<div class="alert alert-secondary" role="alert">';
                                html += '<h4 class="alert-heading text-center">Data Not Found!</h4>';
                                html += '</div>';
                                $("#card_merchant").html(html);
                            }
                        }
                    },
                    // error
                    error: function(xhr, status, error) {
                        var html = '';
                        html += '<div class="alert alert-danger" role="alert">';
                        html += '<h4 class="alert-heading text-center">Error!</h4>';
                        html += '<p>' + error + '</p>';
                        html += '</div>';
                        $("#card_merchant").html(html);
                    }
                });
            }
        });

    </script>
@endsection
