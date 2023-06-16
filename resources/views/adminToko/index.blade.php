@extends('layouts.profileMerchant')

@section('title')
    {{ __('Profile') }}
@endsection

@section('content')
    <section>
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12">

                    {{--  @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ __('Success') }}!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif  --}}

                    <div class="row">
                        <div class="col-sm-12 col-md-3 offset-md-1 ">
                            <div class="card shadow border d-flex justify-content-center align-items-center">

                                <div class="card-body">

                                    @if ($avatar == null)
                                        <img src="{{ asset('assets/img/profile_picture.png') }}"
                                            class="img-fluid card-img d-block mx-auto object-fit-none" alt="profile_picture"
                                            style="width: auto; height: 150px;">
                                    @elseif ($avatar != null)
                                        <img src="{{ $avatar }}" class="img-fluid card-img d-block mx-auto object-fit-none"
                                            alt="profile_picture" style="width: auto; height: 150px;">
                                    @endif

                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('edit.profile.admin') }}" class="btn btn-link btn-sm mt-3"><i
                                                class="fa-solid fa-pen-to-square"></i> Edit Profile</a>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        @if (Auth::user()->password != NULL)
                                            <a href="{{ route('change-password') }}" class="btn btn-link btn-sm"><i class="fa-solid fa-lock-open"></i> {{ __("Change Password") }}</a>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="d-none d-md-flex justify-content-center align-items-center b-profile txt-gold mb-5">
                                <div class="chart-container">
                                    <div class="gauge-wrap" data-value="{{ $percentage }}">
                                        <span class="percent txt-gold fw-semibold">{{ $percentage }}%</span>
                                    </div>
                                </div>
                            </div>

                            {{--  mobile view  --}}
                            <div class="d-block d-md-none progress mt-5 mb-2">
                                <div class="progress-bar bg-custome" role="progressbar" style="width: {{ $percentage }}%; height: 20px;"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $percentage }}%</div>
                            </div>

                            <div class="d-flex justify-content-center align-items-center txt-gold mb-5">
                                <span class="fw-semibold text-bar">Profile Completion</span>
                            </div>

                        </div>

                        <div class="col-md-7 mb-4">
                            <div class="card shadow border">
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
                                                <span>-</span>
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

                                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                        id: "{{ $ph['id'] }}",
                        src: "{{ $ph['src'] }}"
                    },
                @endforeach
            ];

            $('.input-images').imageUploader({
                imagesInputName: 'photos',
                preloaded: preloaded,
                accept: 'image/*',
                // image only
                extensions: ['.jpg', '.jpeg', '.png'],
                // maxfile size 2MB
                maxFileSize: 2097152,
                preloadedInputName: 'old',
            });

            $(".delete-image").click(function(e){
                // mengambil id dari input old dari dalam uploaded-image
                e.preventDefault();
                let id = $(this).parent().find('input').val();

                Swal.fire({
                    text: 'Are you sure want to delete this image?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3c10fe5',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('delete-merchant-gallery') }}",
                            data: {
                                _token : "{{ csrf_token() }}",
                                id  : id
                            },

                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your device has been deleted.',
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            }
                        })
                    }
                })

            });

            $("input[type='file']").on("change", function () {
                if(this.files[0].size > 2000000) {
                    file = $(this)[0].files[0];
                    //console.log(file);

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: file.name + ' size must be less than 2 MB!',
                    }).then((result) => {
                        location.reload();
                    });
                }

                return false;
            });

            $('#save_gallery').click(function(e) {
                e.preventDefault();

                let form = $('#photos')[0];
                let formData = new FormData(form);
                let file = $("input[type='file']")[0].files[0];

                // console.log(file);

                if( file == undefined ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select image!',
                    })

                    return false;
                }else if(file.size > 2000000) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'File size must be less than 2 MB!',
                    })

                    return false;
                }
                else {
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.responseJSON.message,
                                showConfirmButton: false,
                                timer: 20000 // waktu popup 20 detik = 20000 ms
                            });

                            console.clear();
                        }
                    });
                }

            });
        });
    </script>
@endsection
