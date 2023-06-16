<div class="modal fade" id="createConfirmation" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content rounded-1 border-0 text-black">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Service Confirmation') }}</h5>
                <button type="button" class="btn-close" id="close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="" method="POST" id="form_ServiceConfirmation" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="no_transaction" class="form-label txt-gold fw-semibold">{{ __('No Transaction :') }}</label>
                        <div class="no_transaction mb-4">{{ $transaction->no_transaction }}</div>
                        <label for="service_confirmation" class="form-label txt-gold fw-semibold">{{ __('Description :') }}</label>
                        <textarea name="service_confirmation" id="service_confirmation" class="form-control form-control-md" cols="30" rows="5"></textarea>
                        <input type="hidden" name="customer_id" id="customer_id" value="{{ $transaction->customer_id }}">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center align-content-center">
                        <a class="btn btn-custome col-md-2 mx-auto" id="submitConfirmation">Send</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
