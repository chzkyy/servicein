@extends('layouts.dashboard')

@section('title')
    {{ __('Device List') }}
@endsection

@section('content')
<section class="mt-5 pt-md-5 min-vh-100">
    <div class="container-fluid">
        <div class="container">
            <div class="col-md-12">
                <div class="container">
                    <div class="button_top my-5 pt-3">
                        <div class="d-flex justify-content-between">
                            {{--  add new btn  --}}
                            <a data-bs-toggle="modal" data-bs-target="#addDevice" class="btn btn-custome fw-bold">{{ __('Add New') }}</a>

                            {{--  search btn  --}}
                            <div class="custom-search">
                                <form action="" method="POST" id="searchDeviceList">
                                    <input type="text" class="custom-search-input" id="searchDevice" placeholder="Search" onkeyup="filter_SearchDevice()">
                                    {{--  <button class="custom-search-botton" type="button">Search</button>  --}}
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="device-list">
                        {{--  device list  --}}
                        <div class="d-flex justify-content-center align-content-center">
                            <div class="col-md-12">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ __('Success') }}!</strong> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{--  check device not empty  --}}
                                @if ( $device->isEmpty() )
                                    <div class="alert alert-secondary al3456789ert-dismissible text-center fade show" role="alert">
                                        <strong></strong> {{ __('No devices found.') }}
                                    </div>
                                @else
                                    @foreach ( $device as $d )
                                        <div class="card my-2 device">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-2 d-flex align-items-center">
                                                        @if ($d->device_picture == null)
                                                            <img src="{{ asset('assets/img/no-image.jpg') }}" alt="device_images" class="img-thumbnail img-fluid" style="width: 150px; height: auto;">
                                                        @else
                                                            <img src="{{ $d->device_picture }}" alt="device_images" class="img-thumbnail img-fluid" style="width: 150px; height: auto;">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8 d-flex align-items-center">
                                                        <div class="row">
                                                            <p class="fw-semibold">{{ $d->device_name }}</p>
                                                            <span>{{ $d->serial_number }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 d-flex align-items-center">
                                                        <div class="row">
                                                            <a data-bs-toggle="modal" data-bs-target="#editDevice" class="btn btn-custome my-2 fw-bold">{{ __('Edit') }}</a>
                                                            {{--  input onclick  --}}

                                                            <button class="btn btn-danger my-2" onclick="remove_Device({{ $d->id }})">{{ __("Delete") }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--  modal edit  --}}
                                        <div class="modal fade" id="editDevice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                                                <div class="modal-content rounded-1 border-0 text-black">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">{{ __('Add Device') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form action="{{ route('edit-device') }}" method="POST" id="form_EditDevice" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label for="edit_device_name" class="form-label">{{ __('Device Name') }}</label>
                                                                        <input type="text" class="form-control @error('edit_device_name') is-invalid @enderror form-control-md" name="edit_device_name" id="edit_device_name" placeholder="Input Your Device Name" value="{{ $d->device_name }}" required autofocus>
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="edit_type" class="form-label">{{ __('Device Type') }}</label>
                                                                        <input type="text" class="form-control @error('edit_type') is-invalid @enderror form-control-md" name="edit_type" id="edit_type" placeholder="Input Your Device Type" value="{{ $d->type }}" required autofocus>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-2">
                                                                        <label for="edit_brand" class="form-label">{{ __('Device Brand') }}</label>
                                                                        <input type="text" class="form-control @error('edit_brand') is-invalid @enderror form-control-md" name="edit_brand" id="edit_brand" placeholder="Input Your Device Brand" value="{{ $d->brand }}" required autofocus>
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="edit_serial_number" class="form-label">{{ __('Device Serial Number') }}</label>
                                                                        <input type="text" class="form-control @error('edit_serial_number') is-invalid @enderror form-control-md" name="edit_serial_number" id="edit_serial_number" placeholder="Input Your Device Serial Number" value="{{ $d->serial_number }}" required autofocus>
                                                                        <small  class="text-muted txt-fz-12">
                                                                            {{ __("*If you don't know your device serial number fill 0") }}
                                                                        </small>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">{{ __("Device Picture") }}</label>
                                                                        <img class="img-fluid img-thumbnail img-preview-edit my-4">
                                                                        <input type="file" class="d-block form-control @error('edit_device_picture') is-invalid @enderror" id="edit_device_image" name="edit_device_image" onchange="preview_EditDevice()" accept="image/*">
                                                                        <small class="form-text text-muted">Maximum size 2MB</small>
                                                                    </div>
                                                                </div>

                                                                <hr class="mt-5">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex justify-content-center align-content-center">
                                                                        <input type="hidden" name="device" id="device" value="{{ $d->id }}">
                                                                        <button type="submit" class="btn btn-custome col-md-2 mx-auto" id="submit_EditDevices">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{--  pagination  --}}
                                    <div class="row">
                                        <div class="col-md-12 float-right">
                                            {{ $device->links() }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>


@include('includes.customer.modal.addDevice')

@endsection


@section('additional-script')
    <script>

        function preview_AddDevice() {
            const avatar = document.querySelector('#device_image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const OFReader = new FileReader();
            OFReader.readAsDataURL(avatar.files[0]);

            OFReader.onload = function(OFREvent) {
                imgPreview.src = OFREvent.target.result;
            }
        }

        function preview_EditDevice() {
            const avatar = document.querySelector('#edit_device_image');
            const imgPreview = document.querySelector('.img-preview-edit');

            imgPreview.style.display = 'block';

            const OFReader = new FileReader();
            OFReader.readAsDataURL(avatar.files[0]);

            OFReader.onload = function(OFREvent) {
                imgPreview.src = OFREvent.target.result;
            }
        }

        // create filter search for displaying card information
        function filter_SearchDevice() {
            const search = document.querySelector('#searchDevice');
            search.focus();

            search.addEventListener('keyup', function() {
                if (this.value.length > 0) {
                    const result = document.querySelectorAll('.device');

                    for (let i = 0; i < result.length; i++) {
                        if (result[i].textContent.toLowerCase().indexOf(this.value.toLowerCase()) > -1) {
                            result[i].classList.remove('d-none');
                        } else {
                            result[i].classList.add('d-none');
                        }
                    }
                }
            });

            // if click enter button, then return false
            search.addEventListener('keydown', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            return false;
        }

        // remove device with sweetalert
        function remove_Device(id) {
            Swal.fire({
                text: 'Are you sure want to delete this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3c10fe5',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('delete-device') }}",
                        data: {
                            _token : "{{ csrf_token() }}",
                            id  : id
                        },
                        success: function() {
                            Swal.fire(
                                'Deleted!',
                                'Your device has been deleted.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error : function(err) {
                            console.log(err);
                        }
                    });
                }
            })
        }

    </script>
@endsection
