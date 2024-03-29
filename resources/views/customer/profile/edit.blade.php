@extends('layouts.dashboard')

@section('title')
    {{ __('Edit Profile') }}
@endsection

@section('content')
    <section>
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12 mt-4">


                    <div class="row pt-5 mt-5">
                        {{--  show error  --}}
                        @if (session('success'))
                            <div class="col-md-12 d-flex justify-content-center ">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ __('Success') }}!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="col-md-10 d-flex justify-content-center">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ __('Failed') }}!</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-3 offset-1">
                            <div class="card shadow border d-flex justify-content-center align-items-center">
                                <div class="card-body">

                                        @if ($avatar == null)
                                            <img src="{{ asset('assets/img/profile_picture.png') }}"
                                                class="img-fluid img-thumbnail avatar " alt="profile_picture"
                                                style="width: auto; height: 150px;">
                                        @elseif ($avatar != null)
                                            <img src="{{ $avatar }}" class="img-fluid img-thumbnail avatar mx-auto card-img object-fit-none"
                                                alt="profile_picture" style="width: auto; height: 150px;">
                                        @endif

                                        <img class="img-fluid img-thumbnail card-img mx-auto object-fit-none img-preview" style="width: auto; height: 150px;">

                                        {{--  tombol upload  --}}
                                        <div class="d-flex justify-content-center align-items-center my-2">
                                            <button type="submit" class="btn btn-custome btn-sm" id="btn_uploadAvatar"><i class="fa-solid fa-pen-to-square"></i> {{ __("Update Picture") }}</button>
                                        </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        <label class="btn btn-link btn-sm custom-file-upload">
                                            <form action="{{ route('update-avatar') }}" method="post" id="updt_avatar" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="profile_picture" id="profile_picture" class="custom-file-upload" onchange="preview_avatar()" accept="image/*">
                                                    <small>
                                                        <i class="fa-solid fa-upload"></i> {{ __("Change Picture") }}
                                                    </small>
                                            </form>
                                        </label>

                                    </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        @if (Auth::user()->password != NULL)
                                            <a href="{{ route('change-password') }}" class="btn btn-link btn-sm">
                                                <small>
                                                    <i class="fa-solid fa-lock-open"></i> {{ __("Change Password") }}
                                                </small>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-7">
                            <form action="{{ route('update.profile') }}" method="post" id="update_profile">
                                @csrf
                                <div class="card shadow border mb-5">
                                    <div class="card-body txt-third m-4">
                                        {{--  full name  --}}
                                        <div class="fullname mb-4">
                                            <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                                            <span class="mx-2 fw-semibold">{{ Auth::user()->username }}</span>
                                        </div>

                                        {{--  General Information  --}}
                                        <div class="h5 txt-gold my-4">{{ __("General Information") }}</div>

                                        <div class="detail-profile">
                                            <div class="fullname col-md-12 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="fullname"
                                                        class="form-label fw-semiboldl">{{ __('Fullname') }}</label>
                                                    <input type="text"
                                                        class="form-control @error('fullname') is-invalid @enderror form-control-md"
                                                        id="fullname" name="fullname" required autocomplete="fullname"
                                                        value="{{ $customer->fullname }}"
                                                        placeholder="Enter your fullname" />
                                                </div>
                                            </div>

                                            <div class="gender col-md-12 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="gender"
                                                        class="form-label fw-semiboldl">{{ __('Gender') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror"
                                                        type="radio" name="gender" id="gender" value="Male"
                                                        @checked($customer->gender == 'Male')>
                                                    <label class="form-check-label" for="gender">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror"
                                                        type="radio" name="gender" id="gender" value="Female"
                                                        @checked($customer->gender == 'Female')>
                                                    <label class="form-check-label" for="gender">Female</label>
                                                </div>
                                            </div>

                                            {{--  error message  --}}


                                            <div class="dob col-md-12 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="dob"
                                                        class="form-label fw-semiboldl">{{ __('Birth Date') }}</label>
                                                    {{--  dob  --}}
                                                    <input type="text"
                                                        class="form-control @error('dob') is-invalid @enderror form-control-md"
                                                        id="dob" name="dob" required value="{{ date("d-m-Y", strtotime($customer->dob)) }}"
                                                        placeholder="Enter your birth date" />
                                                </div>
                                            </div>

                                        </div>

                                        <hr class="border border-gold border-1 opacity-50 mx-4">

                                        {{--  Contact Information  --}}
                                        <div class="h5 txt-gold my-4">{{ __("Contact Detail") }}</div>

                                        <div class="detail-profile">
                                            <div class="phone_number col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="phone_number"
                                                        class="form-label fw-semiboldl">{{ __('Phone Number') }}</label>
                                                    <input
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        type = "number"
                                                        maxlength = "12"
                                                        onwheel="this.blur()"
                                                        class="form-control @error('phone_number') is-invalid @enderror form-control-md"
                                                        id="phone_number" name="phone_number" required
                                                        autocomplete="phone_number" value="{{ $customer->phone_number }}"
                                                        placeholder="Enter your phone number" />
                                                </div>
                                            </div>

                                            <div class="email col-md-12 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="email"
                                                        class="form-label fw-semiboldl">{{ __('Email') }}</label>
                                                    <input type="text"
                                                        class="form-control @error('email') is-invalid @enderror form-control-md"
                                                        id="email" name="email" required autocomplete="email"
                                                        value="{{ Auth::user()->email }}" placeholder="Enter your email"
                                                        readonly />
                                                </div>
                                            </div>

                                            <div class="cust_address col-md-12 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="cust_address"
                                                        class="form-label fw-semiboldl">{{ __('Address') }}</label>
                                                    <textarea name="cust_address" id="cust_address"
                                                        class="form-control @error('cust_address') is-invalid @enderror form-control-md" cols="30" rows="5">{{ $customer->cust_address }}</textarea>
                                                </div>
                                            </div>

                                        </div>

                                        {{--  save button for desktop --}}
                                        <div class="d-none d-md-block justify-content-center text-end align-items-end mt-5">
                                            <a href="{{ route('profile') }}" class="btn btn-light col-md-2 shadow txt-primary mx-1 mt-4">Cancel</a>
                                            <button type="submit" class="btn btn-custome mt-3 mx-1" id="btn_saveChanges">{{ __("Save Changes") }}</button>
                                        </div>

                                    </div>
                                </div>
                                {{--  save button for mobile  --}}
                                <div class="d-block d-md-none justify-content-center text-center align-items-center mt-5 mb-5">
                                    <div class="submit">
                                        <button type="submit" class="btn btn-custome  col-12 mt-3">Save Changes</button>
                                    </div>
                                    <a href="{{ route('profile') }}" class="btn btn-light shadow txt-primary col-12 mt-3">Cancel</a>
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
    <script>
        $('#dob').datepicker({
            format: 'dd-mm-yyyy',
            maxDate: new Date(),
            uiLibrary: 'bootstrap5',
            iconsLibrary: 'fontawesome',
            showRightIcon: true,
            size: 'small',
            autoclose: true,
            todayHighlight: true,
        });

        $('#dob').change(function() {
            var date = $(this).val();
            var newDate = new Date(date);
            var format = newDate.toLocaleDateString('en-CA', {
                day: 'numeric',
                month: 'numeric',
                year: 'numeric'
            });
        })

        @if ($errors->has('fullname'))
            Swal.fire({
                icon: 'error',
                title: '{{ $errors->first('fullname') }}',
                text: '{{ $errors->first('fullname') }}'
            });
        @endif
        @if ($errors->has('dob'))
            Swal.fire({
                icon: 'error',
                title: '{{ $errors->first('dob') }}',
                text: '{{ $errors->first('dob') }}'
            });
        @endif
        @if ($errors->has('gender'))
            Swal.fire({
                icon: 'error',
                title: '{{ $errors->first('gender') }}',
                text: '{{ $errors->first('gender') }}'
            });
        @endif
        @if ($errors->has('phone_number'))
            Swal.fire({
                icon: 'error',
                title: '{{ $errors->first('phone_number') }}',
                text: '{{ $errors->first('phone_number') }}'
            });
        @endif
        @if ($errors->has('cust_address'))
            Swal.fire({
                icon: 'error',
                title: '{{ $errors->first('cust_address') }}',
                text: '{{ $errors->first('cust_address') }}'
            });
        @endif
    </script>
@endsection
