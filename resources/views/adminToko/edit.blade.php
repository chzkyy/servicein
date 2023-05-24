@extends('layouts.dashboard')

@section('title')
    {{ __('Edit Profile') }}
@endsection

@section('content')
    <section class="vh-100">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12">
                    <div class="row mt-4">
                        <div class="col-md-2 offset-md-1 pt-5 mt-5">
                            <div class="card d-flex justify-content-center align-items-center">
                                <div class="card-body">

                                    @if ($avatar == null)
                                        <img src="{{ asset('assets/img/profile_picture.png') }}"
                                            class="img-fluid img-thumbnail avatar" alt="profile_picture">
                                    @elseif ($avatar != null)
                                        <img src="{{ $avatar }}" class="img-fluid img-thumbnail avatar mx-auto"
                                            alt="profile_picture" style="width: 150px; height: 150px;">
                                    @endif

                                        <img class="img-fluid img-thumbnail mx-auto img-preview" style="width: 150px; height: 150px;">
                                        {{--  tombol upload  --}}
                                        <div class="d-flex justify-content-center align-items-center my-2">
                                            <button type="submit" class="btn btn-link btn-sm" id="btn_uploadAvatar"><i class="fa-solid fa-pen-to-square"></i> {{ __("Update Picture") }}</button>
                                        </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        <label class="btn btn-link btn-sm custom-file-upload">
                                            <form action="{{ route('update-avatar-admin') }}" method="post" id="updt_avatar" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="profile_picture" id="profile_picture" class="custom-file-upload" onchange="preview_avatar()" accept="image/*">
                                                    <i class="fa-solid fa-upload"></i> Change Picture
                                            </form>
                                        </label>

                                    </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('change-password') }}" class="btn btn-link btn-sm"><i
                                                class="fa-solid fa-lock-open"></i> Change Password</a>
                                    </div>
                                </div>

                            </div>
                            {{--  save button for desktop --}}
                            <div class="d-none d-md-block justify-content-center text-center align-items-center mt-5">
                                {{--  <button type="submit" class="btn btn-custome col-md-12 mt-3" id="btn_saveChanges">Save Changes</button>  --}}
                                <button type="submit" class="btn btn-custome col-md-12 mt-3" id="sc">Save Changes</button>
                                <a href="{{ route('profile.admin') }}"
                                    class="btn btn-light shadow txt-primary col-md-12 mt-3">Cancel</a>
                            </div>
                        </div>

                        <div class="col-md-8 offset-md-1 pt-5 mt-5">
                            <form action="{{ route('update.profile.admin') }}" method="post" id="update_profile">
                                @csrf
                                <div class="card mb-5">
                                    <div class="card-body txt-third m-4">
                                        <div class="merchant_name mb-4">
                                            <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                                            <span class="mx-2 fw-semibold">
                                                @if ( $merchant->merchant_name == '-')
                                                    {{ Auth::user()->username }}
                                                @else
                                                    {{ $merchant->merchant_name }}
                                                @endif
                                            </span>
                                        </div>

                                        <div class="h5 txt-gold my-4">Business Information</div>

                                        <div class="detail-profile">
                                            <div class="merchant_name col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="merchant_name"
                                                        class="form-label fw-semiboldl">{{ __('Business Name') }}</label>
                                                    <input type="text"
                                                        class="form-control @error('merchant_name') is-invalid @enderror form-control-md"
                                                        id="merchant_name" name="merchant_name" required autocomplete="merchant_name"
                                                        value="{{ $merchant->merchant_name }}"
                                                        placeholder="Enter your business name" />
                                                </div>
                                            </div>

                                            <div class="merchant_desc col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="merchant_desc"
                                                        class="form-label fw-semiboldl">{{ __('Businnes Description') }}</label>
                                                    <textarea name="merchant_desc" id="merchant_desc"
                                                        class="form-control @error('merchant_desc') is-invalid @enderror form-control-md" cols="30" rows="5" size="maxlength"
                                                        maxlength="255"  onkeyup="countChar(this)">{{ $merchant->merchant_desc }}</textarea>
                                                        {{--  create note max 255  --}}
                                                        <div class="text-end text-sm text-truncate charCount">
                                                            <span id="charNum">0</span>{{ __(" Characters Remaining") }}
                                                        </div>

                                                </div>
                                            </div>

                                            <div class="phone_number col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="phone_number"
                                                        class="form-label fw-semiboldl">{{ __('Business Phone Number') }}</label>
                                                    <input
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        type = "number"
                                                        maxlength = "12"
                                                        onwheel="this.blur()"
                                                        class="form-control @error('phone_number') is-invalid @enderror form-control-md"
                                                        id="phone_number" name="phone_number" required
                                                        autocomplete="phone_number" value="{{ $merchant->phone_number }}"
                                                        placeholder="Enter your phone number" />
                                                </div>
                                            </div>

                                            <div class="open_hour col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="open_hour"
                                                        class="form-label fw-semiboldl">{{ __('Open Hour') }}</label>
                                                    <div id="timepicker-selectbox"></div>
                                                    <input type="hidden" name="open_hour" id="open_hour">
                                                </div>
                                            </div>

                                            <div class="close_hour col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="close_hour"
                                                        class="form-label fw-semiboldl">{{ __('Close Hour') }}</label>
                                                    <div id="timepicker-selectbox2"></div>
                                                    <input type="hidden" name="close_hour" id="close_hour">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 mt-2 text-black">
                                                <label for="merchant_address"
                                                    class="form-label fw-semiboldl">{{ __('Address') }}</label>
                                                <textarea name="merchant_address" id="merchant_address" size="maxlength"
                                                maxlength="255"  onkeyup="countChar2(this)" class="form-control text-black @error('merchant_address') is-invalid @enderror form-control-md" cols="30" rows="5">{{ $merchant->merchant_address }}</textarea>
                                                <div class="text-end text-sm text-truncate charCount">
                                                    <span id="charNum2">0</span>{{ __(" Characters Remaining") }}
                                                </div>

                                                <input type="hidden" name="geo_location" id="geo_location">
                                            </div>
                                            <div id="googleMap" class="vw-50 vh-100 mt-5"></div>

                                        </div>

                                        <hr class="border border-gold border-1 opacity-50 mx-4">

                                        {{--  Contact Information  --}}
                                        {{--  <div class="h5 txt-gold my-4">Contact Detail</div>  --}}

                                    </div>
                                </div>
                                {{--  save button for mobile  --}}
                                <div class="d-block d-md-none justify-content-center text-center align-items-center mt-5 mb-5">
                                    <div class="submit">
                                        <button type="submit" class="btn btn-custome  col-12 mt-3">Save
                                            Changes</button>
                                    </div>
                                    <a href="{{ route('profile') }}"
                                        class="btn btn-light shadow txt-primary col-12 mt-3">Cancel</a>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection


@section('additional-script')
    {{--  <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="{{ url('api/maps') }}" async defer></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.js"></script>

    <script type='text/javascript'>
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
            countChar(document.getElementById("merchant_desc"));
            countChar2(document.getElementById("merchant_address"));

        });

        function countChar(val) {
            var len = val.value.length;
            if (len >= 255) {
                val.value = val.value.substring(0, 255);
            } else {
                $('#charNum').text(255 - len);
            }
        };

        function countChar2(val) {
            var len = val.value.length;
            if (len >= 255) {
                val.value = val.value.substring(0, 255);
            } else {
                $('#charNum2').text(255 - len);
            }
        };

        // set geo
        setGeo = function(geo) {

            return geo;
        }

        function showPosition(position) {
            // text area autocomplete
            $('textarea#merchant_address').on('focus', function() {
                $(this).autocomplete({
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
                        $('textarea#merchant_address').val(ui.item.label); // display the selected text
                        return false;
                    },
                    select: function (event, ui) {
                        // Set selection
                        $('textarea#merchant_address').val(ui.item.value); // display the selected text

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

            // isi nilai koordinat ke form
            document.getElementById("geo_location").value = posisiTitik.lat() +"/"+ posisiTitik.lng();

            // event ketika marker di drag
            google.maps.event.addListener(marker, 'drag', function() {
                // koordinat latitude longitude
                document.getElementById("geo_location").value = marker.getPosition().lat() +"/"+ marker.getPosition().lng();
            });
        }

        function initialize() {
            var propertiPeta = {
                center: new google.maps.LatLng(-6.209339, 106.847446),
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);


            // get geo
            setGeo = function(geo) {
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
                // console.log(peta);
                // atur zoom peta
                peta.setZoom(16);
                // pindahkan center peta
                peta.setCenter(event.latLng);
                // map type
                peta.setMapTypeId(google.maps.MapTypeId.ROADMAP);
                buatMarker(this, event.latLng);
            });

            window.onload = function () {
                // set marker on load
                var lat = {{ explode('/', $merchant->geo_location)[0] }};
                var lng = {{ explode('/', $merchant->geo_location)[1] }};
                setGeo(lat + ',' + lng);
            }
        }

        var open_h;
        var open_m;

        var close_h;
        var close_m;

        if ({{ $merchant->open_h != '-' }} != '-') {
            open_h = {{ explode(':', $merchant->open_hour)[0] }};
            open_m = {{ explode(':', $merchant->open_hour)[1] }};
        } else {
            open_h = 0;
            open_m = 0;
        }

        if ({{ $merchant->close_hour != '-' }} != '-') {
            close_h = {{ explode(':', $merchant->close_hour)[0] }};
            close_m = {{ explode(':', $merchant->close_hour)[1] }};
        } else {
            close_h = 0;
            close_m = 0;
        }

        var tpSelectbox = new tui.TimePicker('#timepicker-selectbox', {
            initialHour: open_h,
            initialMinute: open_m,
            inputType: 'selectbox',
            showMeridiem: false
        });

        var tpSelectbox2 = new tui.TimePicker('#timepicker-selectbox2', {
            initialHour: close_h,
            initialMinute: close_m,
            inputType: 'selectbox',
            showMeridiem: false
        });

       // on click
        $("#sc").click(function(){
            // sekect value tpSelectbox\
            $("#open_hour").val(tpSelectbox.getHour() + ":" + tpSelectbox.getMinute());
            $("#close_hour").val(tpSelectbox2.getHour() + ":" + tpSelectbox.getMinute());
            $('#update_profile').submit();
        });
    </script>
@endsection
