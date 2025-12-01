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
        <form method="POST" action="{{ route('sysadmin.catalog.product.attributes.store', $product->id) }}">
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
                                    $existing      = $productAttributeValues->get($attribute->id) ?? null;
                                    $currentValue  = old("attributes.{$attribute->id}", $existing->value ?? null);

                                    // already selected as configurable for this product?
                                    $isConfigurableAttr = in_array(
                                        $attribute->id,
                                        old('configurable_attributes', $existingConfigurable),
                                    );

                                    // Attribute can be used for variants ONLY if:
                                    // DB column configurable = 1 AND type = 3 (dropdown)
                                    $canBeVariant = (int) $attribute->configurable === 1 && (int) $attribute->type === 3;
                                @endphp

                                <div class="border rounded p-3 mb-3">
                                    <div class="row">
                                        {{-- Label --}}
                                        <label class="col-md-12 col-form-label mb-2">
                                            {{ $attribute->name }}
                                        </label>

                                        {{-- VALUE INPUT --}}
                                        <div class="col-md-12 mb-2">
                                            @if ($attribute->type == 3 && $attribute->values->count())
                                                {{-- type 3 = DROPDOWN --}}
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
                                                {{-- type 2 (or others) = TEXT --}}
                                                <input
                                                    type="text"
                                                    name="attributes[{{ $attribute->id }}]"
                                                    class="form-control"
                                                    value="{{ $currentValue }}"
                                                >
                                            @endif
                                        </div>

                                        {{-- VARIANT CHECKBOX – only for configurable dropdown attributes --}}
                                        @if ($canBeVariant)
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="configurable_attributes[]"
                                                        value="{{ $attribute->id }}"
                                                        id="configurable_{{ $attribute->id }}"
                                                        {{ $isConfigurableAttr ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="configurable_{{ $attribute->id }}">
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

                    {{-- VARIANTS CARD (same page) --}}
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
                                                    // Map variant values by attribute_id
                                                    $valueMap = $variant->values->keyBy('attribute_id');
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <input type="text"
                                                               name="variants[{{ $rowIndex }}][name]"
                                                               class="form-control"
                                                               value="{{ old("variants.$rowIndex.name", $variant->name) }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               name="variants[{{ $rowIndex }}][sku]"
                                                               class="form-control"
                                                               value="{{ old("variants.$rowIndex.sku", $variant->sku) }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                               name="variants[{{ $rowIndex }}][price]"
                                                               class="form-control"
                                                               value="{{ old("variants.$rowIndex.price", $variant->price) }}">
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                               name="variants[{{ $rowIndex }}][stock]"
                                                               class="form-control"
                                                               value="{{ old("variants.$rowIndex.stock", $variant->stock) }}">
                                                    </td>
                                                    <td>
                                                        <select name="variants[{{ $rowIndex }}][status]" class="form-select">
                                                            <option value="1" {{ old("variants.$rowIndex.status", $variant->status) == 1 ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ old("variants.$rowIndex.status", $variant->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </td>

                                                    @foreach ($variantAttributes as $attr)
                                                        @php
                                                            $selectedVal = optional($valueMap->get($attr->id))->attribute_value_id;
                                                            $selectedVal = old("variants.$rowIndex.attributes.{$attr->id}", $selectedVal);
                                                        @endphp
                                                        <td>
                                                            <select name="variants[{{ $rowIndex }}][attributes][{{ $attr->id }}]" class="form-select">
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
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-variant-row">
                                                            &times;
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php $rowIndex++; @endphp
                                            @empty
                                                {{-- one empty row by default --}}
                                                <tr>
                                                    <td>
                                                        <input type="text" name="variants[0][name]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="variants[0][sku]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="variants[0][price]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="variants[0][stock]" class="form-control" value="0">
                                                    </td>
                                                    <td>
                                                        <select name="variants[0][status]" class="form-select">
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </td>

                                                    @foreach ($variantAttributes as $attr)
                                                        <td>
                                                            <select name="variants[0][attributes][{{ $attr->id }}]" class="form-select">
                                                                <option value="">Select {{ $attr->name }}</option>
                                                                @foreach ($attr->values as $v)
                                                                    <option value="{{ $v->id }}">{{ $v->value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    @endforeach

                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-variant-row">
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

                    {{-- GLOBAL FORM FOOTER --}}
                    <div class="mt-3 text-end">
                        <a href="{{ route('sysadmin.catalog.product.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary mx-2">
                            Save Attributes @if((int)$product->type === 2) & Variants @endif
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

            if (!tableBody || !addBtn) {
                return;
            }

            // start index = last existing row index + 1
            let variantIndex = tableBody.querySelectorAll('tr').length;
            if (variantIndex === 0) variantIndex = 1; // safety

            // Add new variant row
            addBtn.addEventListener('click', function () {
                const lastRow = tableBody.querySelector('tr:last-child');
                if (!lastRow) return;

                const newRow = lastRow.cloneNode(true);

                newRow.querySelectorAll('input, select').forEach(function (el) {
                    if (el.name) {
                        el.name = el.name.replace(/\[\d+]/, '[' + variantIndex + ']');
                    }

                    if (el.tagName === 'INPUT') {
                        if (el.type === 'number') {
                            el.value = 0;
                        } else {
                            el.value = '';
                        }
                    }

                    if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0;
                    }
                });

                tableBody.appendChild(newRow);
                variantIndex++;
            });

            // Remove variant row
            tableBody.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-variant-row')) {
                    const rows = tableBody.querySelectorAll('tr');
                    if (rows.length > 1) {
                        e.target.closest('tr').remove();
                    }
                }
            });
        })();
    </script>
@endPushOnce
