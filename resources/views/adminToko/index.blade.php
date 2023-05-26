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
                                        <a href="{{ route('edit.profile.admin') }}" class="btn btn-link btn-sm mt-3"><i
                                                class="fa-solid fa-pen-to-square"></i> Edit Profile</a>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('change-password') }}" class="btn btn-link btn-sm"><i
                                                class="fa-solid fa-lock-open"></i> Change Password</a>
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

                        <div class="col-md-8 offset-md-1 pt-md-5 mt-md-5 mb-4">
                            <div class="card">
                                <div class="card-body txt-third m-4">
                                    {{--  full name  --}}
                                    <div class="fullname mb-4">
                                        <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                                        <span class="mx-2 fw-semibold">
                                            @if ( $merchant->merchant_name == '-')
                                                {{ Auth::user()->username }}
                                            @else
                                                {{ $merchant->merchant_name }}
                                            @endif
                                        </span>
                                    </div>

                                    {{--  General Information  --}}
                                    <div class="h5 txt-gold my-4">Business Information</div>

                                    <div class="detail-profile">
                                        <div class="fullname mb-2">
                                            <span class="fw-semibold">Business Name</span>
                                            <div class="data">
                                                <span>{{ $merchant->merchant_name }}</span>
                                            </div>
                                        </div>

                                        <div class="desc mb-2">
                                            <span class="fw-semibold">Business Description</span>
                                            <div class="data">
                                                <span>{{ $merchant->merchant_desc }}</span>
                                            </div>
                                        </div>

                                        <div class="phone-number mb-2">
                                            <span class="fw-semibold">Phone Number</span>
                                            <div class="data">
                                                <span>
                                                    {{ preg_replace('/\d{3}/', '($0) - ', str_replace('.', null, trim($merchant->phone_number)), 1) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="open mb-2">
                                            <span class="fw-semibold">Open Hour</span>
                                            <div class="data">
                                                <span>
                                                    @if ( $merchant->open_hour == '-')
                                                        {{ __(NULL) }}
                                                    @else
                                                        {{ date("H:i", strtotime( $merchant->open_hour )) }}
                                                    @endif
                                                </span>
                                                <span class="blockquote-footer"></span>
                                                <span>
                                                    @if ( $merchant->close_hour == '-')
                                                        {{ __(NULL) }}
                                                    @else
                                                        {{ date("H:i", strtotime( $merchant->close_hour )) }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                        <div class="cust_addrs mb-2">
                                            <span class="fw-semibold">Address</span>
                                            <div class="data">
                                                <span>{{ $merchant->merchant_address }}</span>
                                            </div>
                                        </div>

                                        <div class="picture mb-2">
                                            <span class="fw-semibold">{{ __("Picture or photos") }}</span>
                                            {{-- card picture  --}}
                                            <div class="card mt-2">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <form action="" method="POST" id="photos" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="merchant_id" value="{{ $merchant->id }}">
                                                            <div class="input-images"></div>

                                                            <div class="col-md-12 mt-3">
                                                                <button id="save_gallery" class="btn btn-custome btn-block">Save</button>
                                                            </div>
                                                        </form>

                                                        {{--  @foreach ($photos as $ph )

                                                            {{ $ph }}
                                                            <div class="col-md-3">
                                                                <div class="card">
                                                                    <img src="{{ asset('assets/img/example-img-merchant.png') }}"
                                                                        class="card-img-top" alt="...">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>  --}}
                                                </div>


                                            </div>
                                        </div>

                                    </div>

                                    {{--  <hr class="border border-gold border-1 opacity-50 mx-4">  --}}

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
    <script src="{{ asset('assets/js/image-uploader.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2rint@11"></script>

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

            let preloaded = [
                @foreach ($photos as $ph)
                    {
                        id: "{{ $loop->iteration }}",
                        src: "{{ $ph['src'] }}"
                    },
                @endforeach
            ];

            $('.input-images').imageUploader({
                imagesInputName: 'photos',
                preloaded: preloaded,
                preloadedInputName: 'old'
            });

            $(".delete-image").click(function(e){
                
            });

            $('#save_gallery').click(function(e) {
                e.preventDefault();

                let form = $('#photos')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('merchant-gallery') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Success upload images',
                            showConfirmButton: false,
                            timer: 20000 // waktu popup 20 detik = 20000 ms
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endsection
