@extends('layouts.app')

@section('content')
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
                            <select class="col-md-12 js-data-example-ajax form-control">
                                <option></option>
                            </select>
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

    <script src="{{ url('api/maps') }}" async defer></script>

    <script type='text/javascript'>
        var x = document.getElementById("demo");
        const geo = '';

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

            $('.js-data-example-ajax').select2({
                ajax: {
                    url: "{{ url('api/searchPlace') }}",
                    data: function(params) {
                        var query = {
                            origin: position.coords.latitude + ',' + position.coords.longitude,
                            place: params.term,
                        }
                        // Query parameters will be ?origin=[key]&place=[input]
                        return query;
                    },
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data, params) {
                        return {
                            results: $.map(data.results, function(item) {
                                return {
                                    text: formatResult(item),
                                    title: item.name,
                                    id: item.name + ' - ' + item.formatted_address,
                                    name: item.name,
                                    formatted_address: item.formatted_address,
                                    geo: item.geometry.location.lat + ',' + item.geometry
                                        .location.lng
                                }
                            })
                        };
                    },
                },
                placeholder: "Masukkan alamat toko anda.",
                templateSelection: formatSelection,
                minimumInputLength: 1,
            });

            function formatResult(data) {
                if (data.loading) {
                    return data.text;
                }

                var $container = $(
                    "<div class='select2-result'>" +
                    "<b>" + data.name + "</b><br>" +
                    "<span>" + data.formatted_address + "</span>" +
                    "</div>"
                );

                return $container;
            }

            function formatSelection(data) {
                return data.id || data.text;
            }

            $('.js-data-example-ajax').on('select2:select', function(e) {
                var data = e.params.data;
                // console.log(data);
                $('#link').html('<a href="https://www.google.com/maps/dir/?api=1&origin=' + position
                    .coords.latitude + ',' + position.coords.longitude + '&destination=' + data
                    .geo + '&travelmode=driving" target="_blank">Buka Google Maps</a>');

                // send data geo
                setGeo(data.geo);
            });
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
                buatMarker(peta, latlng);
            }

            // even listner ketika peta diklik
            google.maps.event.addListener(peta, 'click', function (event) {
                console.log(peta);
                buatMarker(this, event.latLng);

            });

        }

    </script>
@endsection
