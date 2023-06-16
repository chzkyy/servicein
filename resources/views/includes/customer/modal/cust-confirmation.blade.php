<div class="modal fade" id="confirmation" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content rounded-1 border-0 text-black">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Service Confirmation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="container-fluid mx-auto">
                        <div class="col-md-10 mx-auto">

                            <div class="col-md-12 mb-3 d-flex justify-content-end">
                                <button type="button" class="btn col-md-2 btn-sm btn-block btn-custome">{{ __("Chat") }}</button>

                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="fw-semibold txt-gold">{{ __("Transaction ID :") }}</div>
                                        <div id="SC_transactionID"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="fw-semibold txt-gold">{{ __("Device Name :") }}</div>
                                    <div id="SC_deviceName"></div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="fw-semibold txt-gold">{{ __("Store Name :") }}</div>
                                    <div id="SC_merchantName"></div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="fw-semibold txt-gold">{{ __("Description :") }}</div>
                                    <div id="SC_description"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="merchant_id" id="merchant_id">
                        <a class="btn btn-custome mx-2" id="acceptService">Accept</a>
                        <a class="btn btn-custome-outline mx-2" id="declineService">Decline</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
