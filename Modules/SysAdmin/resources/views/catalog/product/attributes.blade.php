@extends('sysadmin::layouts.master')

@section('breadcrumb-title')
    <h3>Product Attributes - {{ $product->title }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Products</li>
    <li class="breadcrumb-item">
        <a href="{{ route('sysadmin.catalog.product.index') }}">List</a>
    </li>
    <li class="breadcrumb-item active">Attributes</li>
@endsection

@section('content')
    <div class="container-fluid">

        {{-- ✅ enctype required for variant image upload --}}
        <form method="POST" enctype="multipart/form-data"
            action="{{ route('sysadmin.catalog.product.attributes.store', $product->id) }}">
            @csrf

            <div class="row">
                {{-- Alerts --}}
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>

                {{-- LEFT MAIN COLUMN --}}
                <div class="col-md-8">
                    {{-- ATTRIBUTES CARD --}}
                    <div class="card">
                        <div class="card-header p-3">
                            <h5 class="mb-0">
                                Attributes from: {{ $group->name ?? 'Attribute Set' }}
                            </h5>
                            <small class="text-muted">
                                Fill values and (for dropdown attributes) mark which ones will be used for variants.
                            </small>
                        </div>

                        <div class="card-body p-3">
                            @foreach ($group->attributes as $attribute)
                                @php
                                    $existing = $productAttributeValues->get($attribute->id) ?? null;
                                    $currentValue = old("attributes.{$attribute->id}", $existing->value ?? null);

                                    $isConfigurableAttr = in_array(
                                        $attribute->id,
                                        old('configurable_attributes', $existingConfigurable),
                                    );

                                    $canBeVariant =
                                        (int) $attribute->configurable === 1 && (int) $attribute->type === 3;
                                @endphp

                                <div class="border rounded p-3 mb-3">
                                    <div class="row">
                                        <label class="col-md-12 col-form-label mb-2">
                                            {{ $attribute->name }}
                                        </label>

                                        <div class="col-md-12 mb-2">
                                            @if ($attribute->type == 3 && $attribute->values->count())
                                                <select name="attributes[{{ $attribute->id }}]" class="form-select">
                                                    <option value="">Select {{ $attribute->name }}</option>
                                                    @foreach ($attribute->values as $v)
                                                        <option value="{{ $v->id }}"
                                                            {{ (string) $currentValue === (string) $v->id ? 'selected' : '' }}>
                                                            {{ $v->value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" name="attributes[{{ $attribute->id }}]"
                                                    class="form-control" value="{{ $currentValue }}">
                                            @endif
                                        </div>

                                        @if ($canBeVariant)
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="configurable_attributes[]" value="{{ $attribute->id }}"
                                                        id="configurable_{{ $attribute->id }}"
                                                        {{ $isConfigurableAttr ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="configurable_{{ $attribute->id }}">
                                                        Use this attribute for variants (configurable)
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- VARIANTS CARD --}}
                    @if ((int) $product->type === 2 && isset($variantAttributes) && $variantAttributes->count())
                        <div class="card mt-4">
                            <div class="card-header p-3">
                                <h5 class="mb-0">Variants</h5>
                                <small class="text-muted">
                                    Create variants using the configurable dropdown attributes.
                                </small>
                            </div>

                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="variants-table">
                                        <thead>
                                            <tr>
                                                <th>Variant Name</th>
                                                <th>SKU</th>
                                                <th>Price</th>
                                                <th>Stock</th>

                                                {{-- ✅ NEW --}}
                                                <th style="min-width:220px;">Image</th>

                                                <th>Status</th>
                                                @foreach ($variantAttributes as $attr)
                                                    <th>{{ $attr->name }}</th>
                                                @endforeach
                                                <th style="width:40px;">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $rowIndex = 0; @endphp

                                            @forelse ($existingVariants as $variant)
                                                @php
                                                    $valueMap = $variant->values->keyBy('attribute_id');

                                                    // existing thumb preview url
                                                    $variantThumbUrl = null;
                                                    if (!empty($variant->thumb)) {
                                                        $variantThumbUrl = \Modules\SysAdmin\Helpers\ImageUploader::getFilePath(
                                                            $variant->thumb,
                                                            $product->created_at,
                                                            'thumbnail',
                                                        );
                                                    }
                                                @endphp

                                                <tr id="variant-template" class="d-none">
                                                    <td>
                                                        <input type="text" name="__NAME__" class="form-control"
                                                            value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="__SKU__" class="form-control"
                                                            value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="__PRICE__" class="form-control"
                                                            value="">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="__STOCK__" class="form-control"
                                                            value="0">
                                                    </td>
                                                    <td>
                                                        <input type="file" name="__THUMB__"
                                                            class="form-control form-control-sm variant-thumb-input"
                                                            accept=".jpg,.jpeg,.png,.gif,.webp">

                                                        <input type="hidden" name="__REMOVE_THUMB__"
                                                            class="variant-remove-flag" value="0">

                                                        <div class="d-flex gap-2 align-items-center mt-2">
                                                            <img src=""
                                                                class="img-fluid border rounded variant-thumb-preview d-none"
                                                                style="width:60px;height:60px;object-fit:cover;"
                                                                alt="variant">
                                                            <button type="button"
                                                                class="btn btn-outline-danger btn-sm variant-remove-thumb d-none">
                                                                Remove
                                                            </button>
                                                        </div>

                                                        {{-- ✅ keep an element to show current image filename, but empty for template --}}
                                                        <small
                                                            class="text-muted d-block mt-1 current-thumb-text d-none"></small>
                                                    </td>
                                                    <td>
                                                        <select name="__STATUS__" class="form-select">
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </td>

                                                    @foreach ($variantAttributes as $attr)
                                                        <td>
                                                            <select name="__ATTR__{{ $attr->id }}__"
                                                                class="form-select">
                                                                <option value="">Select {{ $attr->name }}</option>
                                                                @foreach ($attr->values as $v)
                                                                    <option value="{{ $v->id }}">
                                                                        {{ $v->value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    @endforeach

                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger remove-variant-row">&times;</button>
                                                    </td>
                                                </tr>
                                                @php $rowIndex++; @endphp
                                            @empty
                                                {{-- one empty row --}}
                                                <tr>
                                                    <td><input type="text" name="variants[0][name]"
                                                            class="form-control"></td>
                                                    <td><input type="text" name="variants[0][sku]"
                                                            class="form-control"></td>
                                                    <td><input type="text" name="variants[0][price]"
                                                            class="form-control"></td>
                                                    <td><input type="number" name="variants[0][stock]"
                                                            class="form-control" value="0"></td>

                                                    {{-- ✅ NEW --}}
                                                    <td>
                                                        <input type="file" name="variants[0][thumb]"
                                                            class="form-control form-control-sm variant-thumb-input"
                                                            accept=".jpg,.jpeg,.png,.gif,.webp">
                                                        <input type="hidden" name="variants[0][remove_thumb]"
                                                            class="variant-remove-flag" value="0">

                                                        <div class="d-flex gap-2 align-items-center mt-2">
                                                            <img src=""
                                                                class="img-fluid border rounded variant-thumb-preview d-none"
                                                                style="width:60px;height:60px;object-fit:cover;"
                                                                alt="variant">
                                                            <button type="button"
                                                                class="btn btn-outline-danger btn-sm variant-remove-thumb d-none">
                                                                Remove
                                                            </button>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <select name="variants[0][status]" class="form-select">
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </td>

                                                    @foreach ($variantAttributes as $attr)
                                                        <td>
                                                            <select name="variants[0][attributes][{{ $attr->id }}]"
                                                                class="form-select">
                                                                <option value="">Select {{ $attr->name }}</option>
                                                                @foreach ($attr->values as $v)
                                                                    <option value="{{ $v->id }}">
                                                                        {{ $v->value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    @endforeach

                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger remove-variant-row">
                                                            &times;
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <button type="button" class="btn btn-outline-primary mt-2" id="add-variant-row">
                                    + Add Variant
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Footer --}}
                    <div class="mt-3 text-end">
                        <a href="{{ route('sysadmin.catalog.product.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary mx-2">
                            Save Attributes @if ((int) $product->type === 2)
                                & Variants
                            @endif
                        </button>
                    </div>
                </div>

                {{-- RIGHT SUMMARY COLUMN --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header p-3">
                            <h5 class="mb-0">Product Summary</h5>
                        </div>
                        <div class="card-body p-3">
                            <p class="mb-1"><strong>Title:</strong> {{ $product->title }}</p>
                            <p class="mb-1"><strong>SKU:</strong> {{ $product->sku }}</p>
                            <p class="mb-1">
                                <strong>Type:</strong>
                                {{ (int) $product->type === 2 ? 'Variable' : 'Simple' }}
                            </p>
                            <p class="mb-0">
                                <strong>Attribute Set:</strong>
                                {{ $group->name ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@pushOnce('scripts')
<script>
(function () {
    const tableBody = document.querySelector('#variants-table tbody');
    const addBtn    = document.querySelector('#add-variant-row');
    const tpl       = document.querySelector('#variant-template');

    if (!tableBody || !addBtn || !tpl) return;

    // Compute next index based on max existing index in names (safer than row count)
    function getNextIndex() {
        let max = -1;
        tableBody.querySelectorAll('input[name^="variants["], select[name^="variants["]').forEach(el => {
            const m = el.name.match(/^variants\[(\d+)\]/);
            if (m) max = Math.max(max, parseInt(m[1], 10));
        });
        return max + 1;
    }

    addBtn.addEventListener('click', function () {
        const idx = getNextIndex();

        const newRow = tpl.cloneNode(true);
        newRow.id = '';
        newRow.classList.remove('d-none');

        // Replace placeholder names with proper names
        newRow.querySelector('input[name="__NAME__"]').name = `variants[${idx}][name]`;
        newRow.querySelector('input[name="__SKU__"]').name  = `variants[${idx}][sku]`;
        newRow.querySelector('input[name="__PRICE__"]').name= `variants[${idx}][price]`;
        newRow.querySelector('input[name="__STOCK__"]').name= `variants[${idx}][stock]`;
        newRow.querySelector('input[name="__THUMB__"]').name= `variants[${idx}][thumb]`;
        newRow.querySelector('input[name="__REMOVE_THUMB__"]').name= `variants[${idx}][remove_thumb]`;
        newRow.querySelector('select[name="__STATUS__"]').name= `variants[${idx}][status]`;

        // attr selects
        newRow.querySelectorAll('select[name^="__ATTR__"]').forEach(sel => {
            const attrId = sel.name.replace('__ATTR__','').replace('__','');
            sel.name = `variants[${idx}][attributes][${attrId}]`;
        });

        // Make sure preview/remove/current are clean
        const img = newRow.querySelector('.variant-thumb-preview');
        const btn = newRow.querySelector('.variant-remove-thumb');
        const cur = newRow.querySelector('.current-thumb-text');
        if (img) { img.src=''; img.classList.add('d-none'); }
        if (btn) btn.classList.add('d-none');
        if (cur) { cur.textContent=''; cur.classList.add('d-none'); }

        tableBody.appendChild(newRow);
    });

    // Remove row
    tableBody.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-variant-row');
        if (!btn) return;

        const rows = tableBody.querySelectorAll('tr:not(#variant-template)');
        if (rows.length > 1) btn.closest('tr').remove();
    });

    // Image preview
    tableBody.addEventListener('change', function (e) {
        const input = e.target.closest('.variant-thumb-input');
        if (!input) return;

        const tr = input.closest('tr');
        const img = tr.querySelector('.variant-thumb-preview');
        const btn = tr.querySelector('.variant-remove-thumb');
        const flag= tr.querySelector('.variant-remove-flag');
        const cur = tr.querySelector('.current-thumb-text');

        if (input.files && input.files[0]) {
            img.src = URL.createObjectURL(input.files[0]);
            img.classList.remove('d-none');
            btn.classList.remove('d-none');
            if (flag) flag.value = '0';
            if (cur) { cur.textContent=''; cur.classList.add('d-none'); }
        }
    });

    // Remove thumb
    tableBody.addEventListener('click', function (e) {
        const btn = e.target.closest('.variant-remove-thumb');
        if (!btn) return;

        const tr = btn.closest('tr');
        const input = tr.querySelector('.variant-thumb-input');
        const img = tr.querySelector('.variant-thumb-preview');
        const flag= tr.querySelector('.variant-remove-flag');
        const cur = tr.querySelector('.current-thumb-text');

        if (input) input.value = '';
        if (img) { img.src=''; img.classList.add('d-none'); }
        if (flag) flag.value = '1';
        if (cur) { cur.textContent=''; cur.classList.add('d-none'); }

        btn.classList.add('d-none');
    });

})();
</script>
@endPushOnce