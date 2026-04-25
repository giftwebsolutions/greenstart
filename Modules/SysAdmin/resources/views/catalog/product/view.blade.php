@php
    use Modules\SysAdmin\Helpers\ImageUploader;
    use Carbon\Carbon;

    $createdAt = $product->created_at
        ? Carbon::createFromTimestamp($product->created_at)->toDateTimeString()
        : null;

    // Product thumbnail (fallback image)
    $productThumb = ImageUploader::getFilePath(
        $product->thumb ?? null,
        $createdAt,
        'thumbnail'
    );
@endphp

@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>View Product</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Products</li>
    <li class="breadcrumb-item active">{{ $product->title }}</li>
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">

        {{-- LEFT: PRODUCT DETAILS --}}
        <div class="col-md-8">
            <div class="card p-3 mb-3">
                <h4 class="mb-2">{{ $product->title }}</h4>

                <p class="mb-1"><strong>Model:</strong> {{ $product->model ?: '-' }}</p>
                <p class="mb-1"><strong>Product Code:</strong> {{ $product->product_code ?: '-' }}</p>
                <p class="mb-1"><strong>Status:</strong> {{ $status }}</p>
                <p class="mb-1"><strong>Type:</strong> {{ (int)$product->type === 2 ? 'Variable' : 'Simple' }}</p>
                <p class="mb-1"><strong>Category:</strong> {{ $category->name ?? '-' }}</p>
                <p class="mb-1"><strong>Sub Category:</strong> {{ $subCategory->name ?? '-' }}</p>
                <p class="mb-1"><strong>Attribute Set:</strong> {{ $attributeSet->name ?? '-' }}</p>

                <hr>

                <p><strong>Short Description</strong></p>
                <p>{{ $product->short_description ?: '-' }}</p>

                <hr>

                <p><strong>Description</strong></p>
                <div class="border rounded p-2 bg-light">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            {{-- VARIANTS (only for variable products) --}}
            @if ((int)$product->type === 2 && $variants->count())
                <div class="card p-3">
                    <h5 class="mb-3">Variants</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Variant</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Attributes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($variants as $variant)
                                    @php
                                        $variantImage = ImageUploader::getFilePath(
                                            $variant->thumb ?? null,
                                            $createdAt,
                                            'thumbnail'
                                        );
                                    @endphp
                                    <tr>
                                        <td style="width:80px;">
                                            <img src="{{ $variantImage }}"
                                                 class="img-fluid rounded"
                                                 alt="variant"
                                                 style="max-height:60px;">
                                        </td>
                                        <td>{{ $variant->name ?: '-' }}</td>
                                        <td>{{ $variant->sku }}</td>
                                        <td>{{ number_format($variant->price, 2) }}</td>
                                        <td>{{ $variant->stock }}</td>
                                        <td>
                                            <span class="badge {{ $variant->status ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $variant->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            @foreach ($variant->values as $val)
                                                <div>
                                                    <strong>{{ $val->attribute->name }}:</strong>
                                                    {{ $val->attributeValue->value ?? '-' }}
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        {{-- RIGHT: IMAGES --}}
        <div class="col-md-4">

            {{-- MAIN PRODUCT IMAGE --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Product Image</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $productThumb }}"
                         alt="product"
                         class="img-fluid rounded">
                </div>
            </div>

            {{-- PRODUCT GALLERY --}}
            @if (!empty($galleryImages) && count($galleryImages))
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Gallery</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach ($galleryImages as $img)
                                @php
                                    $galleryPath = ImageUploader::getFilePath(
                                        $img->image,
                                        $createdAt,
                                        'thumbnail'
                                    );
                                @endphp
                                <div class="col-6">
                                    <img src="{{ $galleryPath }}"
                                         class="img-fluid rounded border"
                                         alt="gallery">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
