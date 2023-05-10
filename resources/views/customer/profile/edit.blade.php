@extends('layouts.dashboard')

@section('title')
    {{ __('Profile') }}
@endsection

@section('content')
    <section class="vh-100">
        <div class="container-fluid">
            <div class="container">
                <div class="col-md-12">
                    <div class="row mt-4">
                        <div class="d-flex justify-content-around pt-5 mt-5">
                            <div class="col-md-2">
                                <div class="card d-flex justify-content-center align-items-center">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/img/profile_picture.png') }}"
                                            class="img-fluid img-thumbnail" alt="profile_picture">

                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="#" class="btn btn-primary btn-sm mt-3"><i
                                                    class="fa-solid fa-pen-to-square"></i> Edit Profile</a>
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('change-password') }}" class="btn btn-primary btn-sm mt-3"><i
                                                    class="fa-solid fa-lock-open"></i> Change Password</a>
                                        </div>
                                    </div>

                                </div>
                                {{--  save button  --}}
                                <div class="d-block justify-content-center text-center align-items-center mt-5">
                                    <button type="submit" class="btn btn-custome col-md-12 mt-3">Save Changes</button>
                                    <a href="{{ route('profile') }}" class="btn btn-light shadow txt-primary col-md-12 mt-3">Cancel</a>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body txt-third m-4">
                                        {{--  full name  --}}
                                        <div class="fullname mb-4">
                                            <img src="{{ url('assets/img/Avatar.png') }}" alt="Avatar" class="img-fluid">
                                            <span class="mx-2 fw-semibold">{{ $customer->fullname }}</span>
                                        </div>

                                        {{--  General Information  --}}
                                        <div class="h5 txt-gold my-4">General Information</div>

                                        <div class="detail-profile">
                                            <div class="fullname col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="fullname" class="form-label fw-semiboldl">{{ __('Fullname') }}</label>
                                                    <input type="text"
                                                        class="form-control @error('fullname') is-invalid @enderror form-control-md"
                                                        id="fullname" name="fullname" required autocomplete="fullname" value="{{ $customer->fullname }}"
                                                        placeholder="Enter your fullname" />
                                                </div>
                                            </div>

                                            <div class="gender col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="gender" class="form-label fw-semiboldl">{{ __('Gender') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender" value="Male">
                                                    <label class="form-check-label" for="gender">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender" value="Female">
                                                    <label class="form-check-label" for="gender">Female</label>
                                                </div>
                                            </div>

                                            <div class="dob col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="dob" class="form-label fw-semiboldl">{{ __('Birth Date') }}</label>
                                                    {{--  dob  --}}
                                                    <input type="date"
                                                        class="form-control @error('dob') is-invalid @enderror form-control-md"
                                                        id="dob" name="dob" required autocomplete="dob" value="{{ date('Y-m-d',strtotime($customer->dob)) }}"
                                                        placeholder="Enter your birth date" />
                                                </div>
                                            </div>

                                        </div>

                                        <hr class="border border-gold border-1 opacity-50 mx-4">

                                        {{--  Contact Information  --}}
                                        <div class="h5 txt-gold my-4">Contact Detail</div>

                                        <div class="detail-profile">
                                            <div class="phone-number col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="phone-number" class="form-label fw-semiboldl">{{ __('Phone Number') }}</label>
                                                    <input type="tel"
                                                        class="form-control @error('phone-number') is-invalid @enderror form-control-md"
                                                        id="phone-number" name="phone-number" required autocomplete="phone-number" value="{{ $customer->phone_number }}"
                                                        placeholder="Enter your phone number" />
                                                </div>
                                            </div>

                                            <div class="email col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="email" class="form-label fw-semiboldl">{{ __('Email') }}</label>
                                                    <input type="text"
                                                        class="form-control @error('email') is-invalid @enderror form-control-md"
                                                        id="email" name="email" required autocomplete="email" value="{{ Auth::user()->email }}"
                                                        placeholder="Enter your email" readonly />
                                                </div>
                                            </div>

                                            <div class="cust_addrs col-md-6 mb-2">
                                                <div class="form-group mt-2">
                                                    <label for="cust_addrs" class="form-label fw-semiboldl">{{ __('Address') }}</label>
                                                    <textarea name="cust_addrs" id="cust_addrs" class="form-control @error('cust_addrs') is-invalid @enderror form-control-md" cols="30" rows="5">{{ $customer->cust_addrs }}</textarea>
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
