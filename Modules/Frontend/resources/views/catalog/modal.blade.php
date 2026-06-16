<div class="modal fade ga-enquiry-modal" id="enquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header ga-enquiry-head">
                <div>
                    <span class="ga-enquiry-kicker">Product enquiry</span>
                    <h5 class="modal-title">Get best price &amp; service support</h5>
                </div>
                <button type="button" class="ga-enquiry-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="enquiryForm">
                @csrf

                <div class="modal-body ga-enquiry-body">
                    <div class="alert alert-success d-none ga-enquiry-alert" id="enquirySuccess"></div>
                    <div class="alert alert-danger d-none ga-enquiry-alert" id="enquiryError"></div>

                    {{-- Hidden preload fields --}}
                    <input type="hidden" name="product_id" id="enquiry_product_id" value="0">
                    <input type="hidden" name="category_id" id="enquiry_category_id" value="0">

                    <div class="ga-enquiry-product">
                        <span class="ga-enquiry-product-icon"><i class="fa-solid fa-droplet"></i></span>
                        <div>
                            <small>Selected product</small>
                            <strong id="enquiry_product_name">—</strong>
                        </div>
                    </div>

                    <div class="ga-enquiry-grid">
                        <label class="ga-field">
                            <span>Name</span>
                            <input type="text" class="form-control" name="name" required placeholder="Your name">
                        </label>

                        <label class="ga-field">
                            <span>Mobile</span>
                            <input type="tel" class="form-control" name="mobile" required placeholder="Mobile number">
                        </label>

                        <label class="ga-field ga-field-wide">
                            <span>Email <em>optional</em></span>
                            <input type="email" class="form-control" name="email" placeholder="Email address">
                        </label>

                        <label class="ga-field">
                            <span>City</span>
                            <input type="text" class="form-control" name="city" placeholder="City">
                        </label>

                        <label class="ga-field">
                            <span>State</span>
                            <input type="text" class="form-control" name="state" placeholder="State">
                        </label>

                        <label class="ga-field">
                            <span>Qty</span>
                            <input type="number" step="0.01" min="1" class="form-control" name="qty" value="1">
                        </label>

                        <label class="ga-field">
                            <span>Product price</span>
                            <input readonly="readonly" type="number" step="0.01" min="0" class="form-control" id="product-price" name="price">
                        </label>

                        <label class="ga-field">
                            <span>Expected price</span>
                            <input type="number" step="0.01" min="0" class="form-control" name="req_price" placeholder="Optional">
                        </label>
                    </div>

                    <label class="ga-field ga-message">
                        <span>Message</span>
                        <textarea class="form-control" name="message" rows="3" required placeholder="Tell us your requirement, installation location, or service need"></textarea>
                    </label>

                    {{-- Default status for backend --}}
                    <input type="hidden" name="status" value="1">
                </div>

                <div class="modal-footer ga-enquiry-footer">
                    <button type="button" class="ga-enquiry-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="ga-enquiry-submit" id="enquirySubmitBtn">
                        <i class="fa-regular fa-paper-plane"></i>
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

                $btn.prop('disabled', true).addClass('is-loading').html('<span class="shop-load-spinner"></span> Submitting...');

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
                        $btn.prop('disabled', false).removeClass('is-loading').html('<i class="fa-regular fa-paper-plane"></i> Submit Enquiry');
                    }
                });
            });

        });
    </script>
@endsection()
