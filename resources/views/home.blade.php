@extends('layouts.dashboard')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <section>
        <section>
            {{--  Jumbotron   --}}
            <div class="p-5 text-center bg-image jdashboard">
                <div class="mask pt-5">
                    <div class="d-flex justify-content-center align-items-center pt-5 mt-5">
                        <div class="text-white pt-5">
                            <h1 class="mb-3">{{ __('Your solution in service') }}</h1>
                            <h4 class="mb-3">{{ __('Find a way to repair your device in one website') }}</h4>
                            <a class="btn btn-custome btn-lg" href="#book_merchant" id="btn_bookNow" role="button">Book Now</a>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{--  content   --}}
        <div class="container my-4 mx-2">
            <div class="col-md-12 px-5">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center align-content-center">
                        <div class="col-md-10 d-block my-auto justify-content-center align-content-center">
                            <img src="{{ url('assets/img/banner.png') }}" class="img-fluid" alt="banner">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex justify-content-start align-items-start">
                            <div class="txt-third mt-2">
                                <h1 class="mb-2 text-title dashboard fw-semibold">{{ __('Why Using Service.in ?') }}</h1>
                                <div
                                    class="d-flex justify-content-center align-items-center justify-content-md-start align-items-md-center">
                                    <hr class="border-cust border-2 opacity-50 TitleLine">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <div class="icon mt-2">
                                        <i class="fa-solid fa-truck-fast fa-2xl txt-primary"></i>
                                    </div>

                                    <div class="mx-4 txt-third descText">
                                        <h6 class="uppercase fw-semibold">{{ __('Nearest Store') }}</h6>
                                        <p class="text-break">{{ __('Showing the nearest store available. We prioritize the nearest store for your device repairment service.') }}</p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <div class="icon mt-2">
                                        <i class="fa-solid fa-arrow-rotate-left fa-2xl txt-primary"></i>
                                    </div>
                                    <div class="mx-4 txt-third descText">
                                        <h6 class="uppercase fw-semibold">{{ __('Free Complaint') }}</h6>
                                        <p class="text-break">{{ __('Aftersales complaint guarantee. We will help you communicate with the store even after the device was done.') }}</p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <div class="icon mt-2">
                                        <i class="fa-solid fa-fingerprint fa-2xl txt-primary"></i>
                                    </div>
                                    <div class="mx-4 txt-third descText">
                                        <h6 class="uppercase fw-semibold">{{ __('Community Trusted') }}</h6>
                                        <p class="text-break">{{ __('Handled by experienced store and technician only. We curated the store that already have a good review and professional Technician.') }}</p>
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
            <hr class="border-cust border-1 opacity-50 w-75">
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
                        <div class="card mt-2 mb-4 border-2">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center align-items-center" id="data-container">
                                </div>
                            </div>

                            {{--  pagination  --}}
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-md-12  d-flex justify-content-center align-items-center mb-3" id="pagination">
                                    <div id="pagination-container"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ url('assets/library/pagination.js.org_dist_2.6.0_pagination.js') }}"></script>

    <script type="text/javascript">
        var urlSearchAddress = "{{ url('api/searchPlace') }}";
        const geo = '';

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
        });

        function showPosition(position) {
            //alert("Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude);

            $.ajax({
                // call api route
                url: "{{ url('api/getMatrix') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    origin: position.coords.latitude + ',' + position.coords.longitude
                },
                dataType: "json",
                success: function(data) {

                    if (data.message == "Success") {
                        var html = '';
                        // object to array
                        var arr = $.map(data.data, function(el) {
                            // if persentase is <70 then remove the data
                            if (el['percentage'] < 100) {
                                return null;
                            }

                            return el
                        });

                        $('#pagination-container').pagination({
                            dataSource: arr,
                            pageSize: 6,
                            showNavigator: true,
                            formatNavigator: '<%= rangeStart %>-<%= rangeEnd %> of <%= totalNumber %> items',
                            position: 'bottom',
                            callback: function(data, pagination) {
                                var i;
                                if ( data.length != '0' ){
                                    for (i = 0; i<data.length; i++) {
                                        // console.log(data);
                                        if ( data[i]['gallery'][0] == undefined ){
                                            var img_url = 'assets/img/no-image.jpg';
                                        }else{
                                            var img_url = data[i]['gallery'][0];
                                        }

                                        var merchant_name = data[i]['merchant_name'];
                                        var merchant_id = data[i]['id'];
                                        var rating = data[i]['rating'];
                                        var jarak = data[i]['jarak'];

                                        html += '<div class="col-md-3 my-3">'+
                                            '<div class="card border-2">'+
                                                '<div class="card-body">'+
                                                    '<div class="d-flex justify-content-center">'+
                                                        '<img src="'+url+'/'+img_url+'" class="card-img-top object-fit-cover img-thumbnail" style="width:200px;  height:150px;" alt="image_toko">'+
                                                    '</div>'+
                                                    '<div class="title text-center fw-semibold my-2" id="Merchant_name">'+merchant_name+'</div>'+

                                                    '<div class="rate">'+
                                                        '<div class="container">'+
                                                            '<div class="row">'+
                                                                '<div class="col-md-6">'+
                                                                    '<div class="d-flex justify-content-center align-items-center">'+
                                                                        '<div class="star d-block justify-content-center align-items-center">'+
                                                                            '<div class="star text-center">'+
                                                                                '<i class="fa-solid fa-star" style="color: #ffa800;"></i>'+
                                                                            '</div>'+
                                                                            '<div class="star-desc text-center">'+
                                                                                '<span id="rate">'+rating+'/5 <br> <sub class="fw-semibold">Reviews</sub></span>'+
                                                                            '</div>'+
                                                                        '</div>'+

                                                                    '</div>'+
                                                                '</div>'+

                                                                '<div class="col-md-6">'+
                                                                    '<div class="d-flex justify-content-center align-items-center">'+
                                                                        '<div class="distance d-block justify-content-center align-items-center mt-3 m-md-0">'+
                                                                            '<div class="distance text-center">'+
                                                                                '<i class="fa-solid fa-map-location-dot" style="color: #ffa800;"></i>'+
                                                                            '</div>'+
                                                                            '<div class="star-desc text-center">'+
                                                                                '<span id="distance">'+jarak+'<br><sub class="fw-semibold">From your location</sub> </span>'+
                                                                            '</div>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                '</div>'+

                                                            '</div>'+

                                                            '<div class="d-flex justify-content-center align-items-center my-3 mx-auto">'+
                                                                '<a href="'+url+'/detail-merchant/'+merchant_id+'" class="btn btn-custome btn-sm" id="booking">{{ __("Book this Service") }}</a>'+
                                                            '</div>'+

                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>';
                                    }
                                    // $("#card_merchant").html(html);

                                } else {
                                    var html = '';

                                    html += '<div class="alert alert-secondary" role="alert">';
                                    html += '<h4 class="alert-heading text-center">Data Not Found!</h4>';
                                    html += '</div>';
                                    //$("#card_merchant").html(html);
                                }

                                 // menhapus undifined di html
                                html = html.replace(/undefined/g, "");
                                $("#pagination-container").find(".paginationjs-pages").before("<br>");
                                var template = $('#data-container').html(html);
                                var html = pagination.totalPages > 1? template : "";
                                return html;
                            }
                        });
                    }
                },
                // error
                error: function(xhr, status, error) {
                    var html = '';
                    html += '<div class="alert alert-danger" role="alert">';
                    html += '<h4 class="alert-heading text-center">Error!</h4>';
                    html += '<p>'+error+'</p>';
                    html += '</div>';
                    $("#card_merchant").html(html);
                }
            });
        }


    </script>

@endsection
