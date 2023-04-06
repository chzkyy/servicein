@extends('layouts.app')

@section('content')
    <style type="text/css">
        #alamat-label {
            display: block;
            font-weight: bold;
            margin-bottom: 1em;
        }

        .ui-autocomplete {
            width: 50%;
        }

    </style>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('Get Location : ') }}
                        <p id="demo"></p>
                        <p id="alamat"></p>
                        <br>
                        <div class="col-md-12">
                            {{--  <select class="col-md-12 js-data-example-ajax form-control">
                                <option></option>
                            </select>  --}}

                            <div class="form-group">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class=" form-control" placeholder="Alamat" id="alamat" name="alamat">
                            </div>
                        </div>

                        <br>
                        <p id="link"></p>
                        <br><br><br>
                        <div id="googleMap" class="vw-50 vh-100"></div>

                        <form action="" method="post">
                            <input type="text" id="lat" name="lat" value="">
                            <input type="text" id="lng" name="lng" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


    <script src="{{ url('api/maps') }}" async defer></script>

    <script type='text/javascript'>
        var x = document.getElementById("demo");
        const geo = '';
        var urlSearchAddress = "{{ url('api/searchPlace') }}";

        $(document).ready(function() {
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }
            }

            getLocation();
        });

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;

            $.ajax({
                // call api route
                url: "{{ url('api/getLocation') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    geo: position.coords.latitude + ',' + position.coords.longitude
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data);
                    $('#alamat').html('Alamat : ' + data.data);
                }
            });

            $.ajax({
                // call api route
                url: "{{ url('api/getMatrix') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    destination: '-6.200145399999999,106.7855597',
                    origin: position.coords.latitude + ',' + position.coords.longitude
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                }
            });

            $('input#alamat').autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: urlSearchAddress,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            geo: position.coords.latitude + ',' + position.coords.longitude,
                            q: request.term,
                        },
                        success: function( res ) {
                            // loop for get data
                            var array = [];
                            $.each(res, function (index, value) {
                                // get data from value
                                array.push(value.data.address);

                            });
                            // response(array);
                            // set label
                            response($.map(res, function (item) {
                                return {
                                    label: item.data.place,
                                    value: item.data.address,
                                    geo: item.data.lat + ',' + item.data.lng
                                }
                            }));
                        }
                    });
                },
                focus: function (event, ui) {
                    $('input#alamat').val(ui.item.label); // display the selected text
                    return false;
                },
                select: function (event, ui) {
                    console.log(ui.item);
                    console.log(ui.item.label); // display the selected text
                    console.log(ui.item.value); // save selected id to input
                    // Set selection
                    $('input#alamat').val(ui.item.value); // display the selected text
                    $('#link').html('<a href="https://www.google.com/maps/dir/?api=1&origin=' + position
                        .coords.latitude + ',' + position.coords.longitude + '&destination=' + ui
                        .item.geo + '&travelmode=driving" target="_blank">Buka Google Maps</a>');

                    // send data geo
                    setGeo(ui.item.geo);
                    return false;
                }
            })
            .autocomplete("instance")._renderItem = function(ui, item) {
                return $("<li>")
                    .append('<div class="text-truncate">' + item.label + "<br>" + item.value + '</div>')
                    .appendTo(ui);
            };
        }

        // variabel global marker
        var marker;

        function buatMarker(peta, posisiTitik) {

            if (marker) {
                // pindahkan marker
                marker.setPosition(posisiTitik);
            } else {
                // buat marker baru
                marker = new google.maps.Marker({
                    position: posisiTitik,
                    map: peta,
                    draggable: true,
                    animation: google.maps.Animation.BOUNCE,
                });
            }

            //

            // isi nilai koordinat ke form
            document.getElementById("lat").value = posisiTitik.lat();
            document.getElementById("lng").value = posisiTitik.lng();

        }

        function initialize() {
            var propertiPeta = {
                center: new google.maps.LatLng(-6.209339, 106.847446),
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);


            setGeo = (geo) => {
                this.geo = geo;
                var latlng = new google.maps.LatLng(geo.split(',')[0], geo.split(',')[1]);
                // atur zoom peta
                peta.setZoom(16);
                // pindahkan center peta
                peta.setCenter(latlng);
                // map type
                peta.setMapTypeId(google.maps.MapTypeId.ROADMAP);
                buatMarker(peta, latlng);
            }

            // even listner ketika peta diklik
            google.maps.event.addListener(peta, 'click', function (event) {
                console.log(peta);
                // atur zoom peta
                peta.setZoom(16);
                // pindahkan center peta
                peta.setCenter(event.latLng);
                // map type
                peta.setMapTypeId(google.maps.MapTypeId.ROADMAP);
                buatMarker(this, event.latLng);
            });

        }

    </script>
@endsection
