<div class="modal fade" id="editInvoice" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content rounded-1 border-0 text-black">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Edit Items') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="" method="POST" id="form_ServiceConfirmation" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="item" class="form-label txt-gold fw-semibold">{{ __('Item :') }}</label>
                        <input type="text" name="edit_item_desc" id="edit_item_desc" class="form-control form-control-md" placeholder="Service fee">
                    </div>
                    <div class="form-group">
                        <label for="price" class="form-label txt-gold fw-semibold">{{ __('Price :') }}</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="hidden" name="id" id="id">
                            <input type="number" class="form-control" name="edit_item_price" id="edit_item_price" placeholder="150000" aria-label="edit_item_price" aria-describedby="basic-addon1">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center align-content-center">
                        <a class="btn btn-custome col-md-2 mx-auto" id="editItems">Save Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
