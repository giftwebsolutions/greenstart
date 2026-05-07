@section('css')
@endsection

<x-frontend::layouts.master :seo="$seo ?? []" :structuredData="$structuredData ?? []">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li>Category Filter</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <div class="contact-area mb-60px">
        <div class="container">

            <div class="contact-form">
                <div class="contact-title mb-30">
                    <h2>Select Category & Product</h2>
                </div>

                <form id="category-product-form">

                    {{-- CATEGORY SELECT --}}
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label class="mb-2">Select Category</label>
                            <select id="category" class="form-control">
                                <option value="">-- Choose Category --</option>

                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- PRODUCT SELECT --}}
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label class="mb-2">Select Product</label>
                            <select id="product" class="form-control">
                                <option value="">-- Select a Category First --</option>
                            </select>
                        </div>
                    </div>

                </form>

                <div id="product-html" class="mt-4"></div>

            </div>
        </div>
    </div>

</x-frontend::layouts.master>

@section('js')
<script>
    // When Category Changes → Load Products
    $('#category').change(function () {
        let categoryID = $(this).val();

        if (!categoryID) {
            $('#product').html('<option value="">-- Select a Category First --</option>');
            $('#product-html').html("");
            return;
        }

        $.ajax({
            url: "{{ route('frontend.category.products') }}",
            type: "GET",
            data: { category_id: categoryID },
            success: function (res) {

                $('#product').html('<option value="">-- Choose Product --</option>');

                res.products.forEach(function (item) {
                    $('#product').append(
                        `<option value="${item.id}">${item.title}</option>`
                    );
                });
            }
        });
    });

    // When Product Selected → Show Product Box
    $('#product').change(function () {
        let productID = $(this).val();

        if (!productID) {
            $('#product-html').html("");
            return;
        }

        $.ajax({
            url: "{{ route('frontend.product.box') }}",
            type: "GET",
            data: { product_id: productID },
            success: function (res) {
                $('#product-html').html(res.html);
            }
        });
    });
</script>
@endsection
