<div class="modal fade" id="addDevice" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content rounded-1 border-0 text-black">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Add Device') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('add-device') }}" method="POST" id="form_addDevice" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="device_name" class="form-label">{{ __('Device Name') }}</label>
                                <input type="text" class="form-control @error('device_name') is-invalid @enderror form-control-md" name="device_name" id="device_name" placeholder="Input Your Device Name" required autofocus>
                            </div>

                            <div class="form-group mb-2">
                                <label for="type" class="form-label">{{ __('Device Type') }}</label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror form-control-md" name="type" id="type" placeholder="Input Your Device Type" required autofocus>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="brand" class="form-label">{{ __('Device Brand') }}</label>
                                <input type="text" class="form-control @error('brand') is-invalid @enderror form-control-md" name="brand" id="brand" placeholder="Input Your Device Brand" required autofocus>
                            </div>

                            <div class="form-group mb-2">
                                <label for="serial_number" class="form-label">{{ __('Device Serial Number') }}</label>
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror form-control-md" name="serial_number" id="serial_number" placeholder="Input Your Device Serial Number" required autofocus>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ __("Device Picture") }}</label>
                                <img class="img-fluid img-thumbnail img-preview my-4">
                                <input type="file" class="d-block form-control @error('device_picture') is-invalid @enderror" id="device_image" name="device_image" onchange="preview_AddDevice()" accept="image/*">
                                <small class="form-text text-muted">Maximum size 2MB</small>
                            </div>
                        </div>

                        <hr class="mt-5">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center align-content-center">
                                <button type="submit" class="btn btn-custome col-md-2 mx-auto" id="submit_addDevices">Add Device</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
