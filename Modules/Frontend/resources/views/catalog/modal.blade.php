<div class="modal fade" id="enquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Enquiry Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="enquiryForm">
                @csrf

                <div class="modal-body">
                    <div class="alert alert-success d-none" id="enquirySuccess"></div>
                    <div class="alert alert-danger d-none" id="enquiryError"></div>

                    {{-- Hidden preload fields --}}
                    <input type="hidden" name="product_id" id="enquiry_product_id" value="0">
                    <input type="hidden" name="category_id" id="enquiry_category_id" value="0">

                    <div class="mb-2">
                        <small class="text-muted">Product:</small>
                        <div class="fw-semibold" id="enquiry_product_name">—</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="mobile" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email (optional)</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Qty</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="qty"
                                value="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input readonly="readonly" type="number" step="0.01" min="0" class="form-control"
                                id="product-price" name="price">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Req. Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="req_price">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" rows="3" required></textarea>
                    </div>

                    {{-- Default status for backend --}}
                    <input type="hidden" name="status" value="1">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sw btn-sm js-enquiry-open" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sw-green btn-sm js-enquiry-open" id="enquirySubmitBtn">
                        Submit Enquiry
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            // Create Bootstrap modal instance (required in BS5)
            const enquiryModal = new bootstrap.Modal($('#enquiryModal')[0]);

            /* ----------------------------------------
               Open Enquiry Modal (Buy Now Click)
            ---------------------------------------- */
            $(document).on('click', '.js-enquiry-open', function() {

                const productId = $(this).data('product-id') || 0;
                const price = $(this).data('price') || 0;
                const categoryId = $(this).data('category-id') || 0;
                const productName = $(this).data('product-name') || '—';

                // Reset form
                $('#enquiryForm')[0].reset();

                // Set hidden values
                $('#enquiry_product_id').val(productId);
                $('#enquiry_category_id').val(categoryId);
                $('#enquiry_product_name').text(productName);
                $('#product-price').val(price);

                // Reset alerts
                $('#enquirySuccess').addClass('d-none').text('');
                $('#enquiryError').addClass('d-none').html('');

                enquiryModal.show();
            });

            /* ----------------------------------------
               AJAX Enquiry Submit
            ---------------------------------------- */
            $('#enquiryForm').on('submit', function(e) {
                e.preventDefault();

                const $form = $(this);
                const $btn = $('#enquirySubmitBtn');

                $btn.prop('disabled', true).text('Submitting...');

                $('#enquirySuccess').addClass('d-none').text('');
                $('#enquiryError').addClass('d-none').html('');

                $.ajax({
                    url: "{{ route('frontend.enquiry.store') }}",
                    type: "POST",
                    data: $form.serialize(),
                    dataType: "json",

                    success: function(res) {
                        $('#enquirySuccess')
                            .removeClass('d-none')
                            .text(res.message || 'Enquiry submitted successfully.');

                        setTimeout(function() {
                            enquiryModal.hide();
                        }, 800);
                    },

                    error: function(xhr) {
                        let html = 'Something went wrong. Please try again.';

                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            html = '<ul class="mb-0">';
                            $.each(xhr.responseJSON.errors, function(key, msgs) {
                                html += '<li>' + msgs[0] + '</li>';
                            });
                            html += '</ul>';
                        }

                        $('#enquiryError')
                            .removeClass('d-none')
                            .html(html);
                    },

                    complete: function() {
                        $btn.prop('disabled', false).text('Submit Enquiry');
                    }
                });
            });

        });
    </script>
@endsection()
