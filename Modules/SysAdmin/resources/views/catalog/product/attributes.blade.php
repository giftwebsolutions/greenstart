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
                                    $existingValue = $existing->attribute_value_id ?? ($existing->value ?? null);
                                    $currentValue = old("attributes.{$attribute->id}", $existingValue);

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
                                            @if ($attribute->type == 2 && $attribute->values->count())
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

                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="variants[{{ $rowIndex }}][id]"
                                                            class="form-control"
                                                            value="{{ old("variants.$rowIndex.id", $variant->id) }}">

                                                        <input type="text" name="variants[{{ $rowIndex }}][name]"
                                                            class="form-control"
                                                            value="{{ old("variants.$rowIndex.name", $variant->name) }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="variants[{{ $rowIndex }}][sku]"
                                                            class="form-control"
                                                            value="{{ old("variants.$rowIndex.sku", $variant->sku) }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="variants[{{ $rowIndex }}][price]"
                                                            class="form-control"
                                                            value="{{ old("variants.$rowIndex.price", $variant->price) }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="variants[{{ $rowIndex }}][stock]"
                                                            class="form-control"
                                                            value="{{ old("variants.$rowIndex.stock", $variant->stock) }}">
                                                    </td>

                                                    {{-- ✅ NEW: Variant Image + remove flag --}}
                                                    <td>
                                                        <input type="file" name="variants[{{ $rowIndex }}][thumb]"
                                                            class="form-control form-control-sm variant-thumb-input"
                                                            accept=".jpg,.jpeg,.png,.gif,.webp">

                                                        <input type="hidden"
                                                            name="variants[{{ $rowIndex }}][remove_thumb]"
                                                            class="variant-remove-flag" value="0">

                                                        <div class="d-flex gap-2 align-items-center mt-2">
                                                            <img src="{{ $variantThumbUrl ?? '' }}"
                                                                class="img-fluid border rounded variant-thumb-preview {{ $variantThumbUrl ? '' : 'd-none' }}"
                                                                style="width:60px;height:60px;object-fit:cover;"
                                                                alt="variant">
                                                            <button type="button"
                                                                class="btn btn-outline-danger btn-sm variant-remove-thumb {{ $variantThumbUrl ? '' : 'd-none' }}">
                                                                Remove
                                                            </button>
                                                        </div>

                                                        <small
                                                            class="text-muted d-block mt-1 current-thumb-text {{ !empty($variant->thumb) ? '' : 'd-none' }}">
                                                            @if (!empty($variant->thumb))
                                                                Current: {{ $variant->thumb }}
                                                            @endif
                                                        </small>
                                                    </td>

                                                    <td>
                                                        <select name="variants[{{ $rowIndex }}][status]"
                                                            class="form-select">
                                                            <option value="1"
                                                                {{ old("variants.$rowIndex.status", $variant->status) == 1 ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="0"
                                                                {{ old("variants.$rowIndex.status", $variant->status) == 0 ? 'selected' : '' }}>
                                                                Inactive</option>
                                                        </select>
                                                    </td>

                                                    @foreach ($variantAttributes as $attr)
                                                        @php
                                                            $selectedVal = optional($valueMap->get($attr->id))
                                                                ->attribute_value_id;
                                                            $selectedVal = old(
                                                                "variants.$rowIndex.attributes.{$attr->id}",
                                                                $selectedVal,
                                                            );
                                                        @endphp
                                                        <td>
                                                            <select
                                                                name="variants[{{ $rowIndex }}][attributes][{{ $attr->id }}]"
                                                                class="form-select">
                                                                <option value="">Select {{ $attr->name }}</option>
                                                                @foreach ($attr->values as $v)
                                                                    <option value="{{ $v->id }}"
                                                                        {{ (string) $selectedVal === (string) $v->id ? 'selected' : '' }}>
                                                                        {{ $v->value }}
                                                                    </option>
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
        (function() {
            const tableBody = document.querySelector('#variants-table tbody');
            const addBtn = document.querySelector('#add-variant-row');

            if (!tableBody || !addBtn) return;

            function replaceVariantIndex(name, newIndex) {
                return name.replace(/variants\[\d+]/g, 'variants[' + newIndex + ']');
            }

            // ✅ always compute next index from DOM (safe after delete)
            function getNextVariantIndex() {
                let max = -1;
                tableBody.querySelectorAll('input[name^="variants["], select[name^="variants["]').forEach(el => {
                    const m = el.name.match(/^variants\[(\d+)\]/);
                    if (m) max = Math.max(max, parseInt(m[1], 10));
                });
                return max + 1;
            }

            // ✅ preview image when selected
            tableBody.addEventListener('change', function(e) {
                const input = e.target.closest('.variant-thumb-input');
                if (!input) return;

                const tr = input.closest('tr');
                const img = tr.querySelector('.variant-thumb-preview');
                const btn = tr.querySelector('.variant-remove-thumb');
                const flag = tr.querySelector('.variant-remove-flag');
                const cur = tr.querySelector('.current-thumb-text');

                if (input.files && input.files[0]) {
                    img.src = URL.createObjectURL(input.files[0]);
                    img.classList.remove('d-none');
                    btn.classList.remove('d-none');
                    if (flag) flag.value = '0';
                    if (cur) {
                        cur.textContent = '';
                        cur.classList.add('d-none');
                    }
                }
            });

            // ✅ remove thumb (set remove_thumb=1)
            tableBody.addEventListener('click', function(e) {
                const btn = e.target.closest('.variant-remove-thumb');
                if (!btn) return;

                const tr = btn.closest('tr');
                const input = tr.querySelector('.variant-thumb-input');
                const img = tr.querySelector('.variant-thumb-preview');
                const flag = tr.querySelector('.variant-remove-flag');
                const cur = tr.querySelector('.current-thumb-text');

                if (input) input.value = '';
                if (img) {
                    img.src = '';
                    img.classList.add('d-none');
                }
                if (flag) flag.value = '1';
                if (cur) {
                    cur.textContent = '';
                    cur.classList.add('d-none');
                }

                btn.classList.add('d-none');
            });

            // ✅ add row (clean clone)
            addBtn.addEventListener('click', function() {
                const lastRow = tableBody.querySelector('tr:last-child');
                if (!lastRow) return;

                const newIndex = getNextVariantIndex();
                const newRow = lastRow.cloneNode(true);

                // ✅ remove hidden id so it creates new variant
                newRow.querySelectorAll('input[name$="[id]"]').forEach(el => el.remove());

                newRow.querySelectorAll('input, select, textarea').forEach(function(el) {
                    if (el.name) el.name = replaceVariantIndex(el.name, newIndex);

                    // force remove_thumb = 0
                    if (el.classList && el.classList.contains('variant-remove-flag')) {
                        el.value = '0';
                        return;
                    }

                    if (el.tagName === 'INPUT') {
                        if (el.type === 'file') el.value = '';
                        else if (el.type === 'number') el.value = 0;
                        else el.value = '';
                    }

                    if (el.tagName === 'SELECT') el.selectedIndex = 0;
                    if (el.tagName === 'TEXTAREA') el.value = '';
                });

                // clear preview + current filename
                newRow.querySelectorAll('.variant-thumb-preview').forEach(img => {
                    img.src = '';
                    img.classList.add('d-none');
                });
                newRow.querySelectorAll('.variant-remove-thumb').forEach(btn => btn.classList.add('d-none'));
                newRow.querySelectorAll('.current-thumb-text').forEach(el => {
                    el.textContent = '';
                    el.classList.add('d-none');
                });

                tableBody.appendChild(newRow);
            });

            // ✅ remove row UI
            tableBody.addEventListener('click', function(e) {
                const btn = e.target.closest('.remove-variant-row');
                if (!btn) return;

                const rows = tableBody.querySelectorAll('tr');
                if (rows.length > 1) btn.closest('tr').remove();
            });
        })
        ();
    </script>
@endPushOnce
