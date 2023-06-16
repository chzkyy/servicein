<div class="modal fade" id="reviewModal" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content rounded-1 border-0 text-black">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Add Review') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="POST" id="photos" enctype="multipart/form-data">
                                @csrf
                                <div class="input-field mb-3">
                                    <label class="active form-label fw-semibold">{{ __("Rating") }}</label>
                                    <input id="rating" type="text" name="rating" class="rating" data-size="sm">
                                </div>
                                <div class="input-field mb-3">
                                    <label class="active form-label fw-semibold">{{ __("Review") }}</label>
                                    <textarea id="review" class="form-control" name="review" rows="5" cols="30" required></textarea>
                                </div>
                                <div class="input-field mb-3">
                                    <label class="active form-label fw-semibold">{{ __("Photos") }}</label>
                                    <div class="input-images" style="padding-top: .5rem;"></div>
                                </div>
                                <input type="hidden" name="no_transaction" id="no_transaction" value="{{ $transaction->no_transaction }}">
                                <input type="hidden" name="review_id" id="review_id">
                            </form>
                        </div>

                        <hr class="mt-5">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center align-content-center">
                                <button type="submit" class="btn btn-custome col-md-2 mx-auto" id="submit_review">Add Review</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

