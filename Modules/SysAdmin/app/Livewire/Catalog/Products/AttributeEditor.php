<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Livewire\Catalog\Products;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Models\Attribute;
use Modules\SysAdmin\Models\AttributeFamily;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\ProductAttributeValue;
use Modules\SysAdmin\Models\ProductConfigurableAttribute;
use Modules\SysAdmin\Models\ProductVariant;
use Modules\SysAdmin\Models\ProductVariantValue;

class AttributeEditor extends Component
{
    use WithFileUploads;

    public int $productId;

    /** @var array<int|string, mixed> */
    public array $attributeValues = [];

    /** @var array<int, int|string> */
    public array $configurableAttributeIds = [];

    /** @var array<int, array<string, mixed>> */
    public array $variants = [];

    /** @var array<int, mixed> */
    public array $variantUploads = [];

    public function mount(int $productId): void
    {
        $this->productId = $productId;
        $this->loadState();
    }

    public function addVariant(): void
    {
        if ($this->configurableAttributeIds === []) {
            $this->addError('configurableAttributeIds', 'Select at least one configurable attribute before adding variants.');

            return;
        }

        $this->variants[] = [
            '_key' => (string) Str::uuid(),
            'id' => null,
            'name' => '',
            'sku' => '',
            'price' => '0.00',
            'stock' => 0,
            'status' => 1,
            'thumb' => null,
            'remove_thumb' => false,
            'attributes' => collect($this->configurableAttributeIds)
                ->mapWithKeys(fn ($attributeId) => [(int) $attributeId => ''])
                ->all(),
        ];
    }

    public function duplicateVariant(int $index): void
    {
        if (! isset($this->variants[$index])) {
            return;
        }

        $variant = $this->variants[$index];
        $variant['_key'] = (string) Str::uuid();
        $variant['id'] = null;
        $variant['name'] = trim((string) $variant['name']).' copy';
        $variant['sku'] = '';
        $variant['thumb'] = null;
        $variant['remove_thumb'] = false;
        $this->variants[] = $variant;
    }

    public function updatedConfigurableAttributeIds(): void
    {
        $selectedIds = collect($this->configurableAttributeIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $this->configurableAttributeIds = $selectedIds;

        foreach ($this->variants as $index => $variant) {
            $values = collect($variant['attributes'] ?? [])
                ->mapWithKeys(fn ($value, $attributeId) => [(int) $attributeId => $value])
                ->only($selectedIds);

            foreach ($selectedIds as $attributeId) {
                if (! $values->has($attributeId)) {
                    $values->put($attributeId, '');
                }
            }

            $this->variants[$index]['attributes'] = $values->all();
        }

        $this->resetValidation();
    }

    public function removeVariant(int $index): void
    {
        if (! isset($this->variants[$index])) {
            return;
        }

        unset($this->variants[$index], $this->variantUploads[$index]);
        $this->variants = array_values($this->variants);
        $this->variantUploads = array_values($this->variantUploads);
    }

    public function removeVariantImage(int $index): void
    {
        if (! isset($this->variants[$index])) {
            return;
        }

        unset($this->variantUploads[$index]);
        $this->variants[$index]['remove_thumb'] = true;
    }

    public function save(): void
    {
        $product = $this->product();
        $family = $this->family($product);
        $attributes = $family->groups->flatMap->attributes->unique('id')->keyBy('id');
        $configurable = $attributes->filter(fn (Attribute $attribute): bool => $this->isVariantAttribute($attribute));
        $allowedConfigurableIds = $configurable->keys()->map(fn ($id) => (int) $id)->all();

        $this->configurableAttributeIds = collect($this->configurableAttributeIds)
            ->map(fn ($id) => (int) $id)
            ->intersect($allowedConfigurableIds)
            ->unique()
            ->values()
            ->all();

        $this->validate(
            $this->rules($attributes, $configurable),
            attributes: $this->validationAttributes($attributes, $configurable),
        );

        if (! $this->validateVariantCombinations($configurable)) {
            return;
        }

        $removedImages = [];

        DB::transaction(function () use ($product, $attributes, $configurable, &$removedImages): void {
            ProductAttributeValue::query()->where('product_id', $product->id)->delete();

            foreach ($attributes as $attribute) {
                $value = $this->attributeValues[$attribute->id] ?? null;

                if ($this->isBlank($value)) {
                    continue;
                }

                $identifier = $this->identifier($attribute);
                ProductAttributeValue::query()->create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => $identifier === 'select' ? (int) $value : null,
                    'value' => $identifier === 'select' ? null : (is_array($value) ? json_encode(array_values($value)) : trim((string) $value)),
                ]);
            }

            ProductConfigurableAttribute::query()->where('product_id', $product->id)->delete();
            foreach ($this->configurableAttributeIds as $attributeId) {
                ProductConfigurableAttribute::query()->create([
                    'product_id' => $product->id,
                    'attribute_id' => $attributeId,
                ]);
            }

            $keptVariantIds = [];
            foreach ($this->variants as $index => $row) {
                $variantId = (int) ($row['id'] ?? 0);
                $variant = $variantId > 0
                    ? ProductVariant::query()->where('product_id', $product->id)->findOrFail($variantId)
                    : new ProductVariant(['product_id' => $product->id]);

                $oldThumb = $variant->thumb;
                $thumb = $oldThumb;

                if ((bool) ($row['remove_thumb'] ?? false)) {
                    $thumb = null;
                }

                if (isset($this->variantUploads[$index])) {
                    $thumb = ImageUploader::upload($this->variantUploads[$index], (string) $product->created_at);
                }

                $variant->fill([
                    'product_id' => $product->id,
                    'name' => trim((string) ($row['name'] ?? '')) ?: null,
                    'sku' => trim((string) ($row['sku'] ?? '')),
                    'price' => (float) ($row['price'] ?? 0),
                    'stock' => (int) ($row['stock'] ?? 0),
                    'status' => (int) ($row['status'] ?? 1),
                    'thumb' => $thumb,
                ])->save();

                if ($oldThumb && $oldThumb !== $thumb) {
                    $removedImages[] = $oldThumb;
                }

                $keptVariantIds[] = $variant->id;
                ProductVariantValue::query()->where('variant_id', $variant->id)->delete();

                foreach ($this->configurableAttributeIds as $attributeId) {
                    $attribute = $configurable->get($attributeId);
                    $optionId = (int) ($row['attributes'][$attributeId] ?? 0);

                    if (! $attribute || ! $optionId) {
                        continue;
                    }

                    ProductVariantValue::query()->create([
                        'variant_id' => $variant->id,
                        'attribute_id' => $attributeId,
                        'attribute_value_id' => $optionId,
                        'value' => null,
                    ]);
                }
            }

            $removedVariants = ProductVariant::query()
                ->where('product_id', $product->id)
                ->when($keptVariantIds !== [], fn ($query) => $query->whereNotIn('id', $keptVariantIds))
                ->get();

            foreach ($removedVariants as $removedVariant) {
                if ($removedVariant->thumb) {
                    $removedImages[] = $removedVariant->thumb;
                }
                $removedVariant->delete();
            }

            $product->type = $keptVariantIds === [] ? 1 : 2;
            $product->save();
        });

        foreach (array_unique($removedImages) as $filename) {
            ImageUploader::remove((string) $product->created_at, $filename);
        }

        $this->loadState();
        $this->dispatch('toast', message: 'Product attributes and variants saved.');
    }

    public function render()
    {
        $product = $this->product();
        $family = $this->family($product);
        $attributes = $family->groups->flatMap->attributes->unique('id')->keyBy('id');
        $variantAttributes = $attributes
            ->filter(fn (Attribute $attribute): bool => $this->isVariantAttribute($attribute))
            ->filter(fn (Attribute $attribute): bool => in_array(
                (string) $attribute->id,
                array_map('strval', $this->configurableAttributeIds),
                true,
            ));

        return view('sysadmin::livewire.catalog.products.attribute-editor', compact(
            'product', 'family', 'variantAttributes'
        ));
    }

    private function loadState(): void
    {
        $product = $this->product()->load([
            'productAttributeValues',
            'configurableAttributes',
            'variants.values',
        ]);
        $family = $this->family($product);
        $attributes = $family->groups->flatMap->attributes->unique('id');
        $storedValues = $product->productAttributeValues->keyBy('attribute_id');

        $this->attributeValues = [];
        foreach ($attributes as $attribute) {
            $stored = $storedValues->get($attribute->id);
            $identifier = $this->identifier($attribute);
            $value = $identifier === 'select' ? $stored?->attribute_value_id : $stored?->value;
            $this->attributeValues[$attribute->id] = $identifier === 'multiselect'
                ? (json_decode((string) $value, true) ?: [])
                : ($value ?? '');
        }

        $this->configurableAttributeIds = $product->configurableAttributes
            ->pluck('attribute_id')->map(fn ($id) => (int) $id)->values()->all();

        $this->variants = $product->variants->map(function (ProductVariant $variant): array {
            return [
                '_key' => 'stored-'.$variant->id,
                'id' => $variant->id,
                'name' => (string) $variant->name,
                'sku' => (string) $variant->sku,
                'price' => number_format((float) $variant->price, 2, '.', ''),
                'stock' => (int) $variant->stock,
                'status' => (int) $variant->status,
                'thumb' => $variant->thumb,
                'remove_thumb' => false,
                'attributes' => $variant->values->pluck('attribute_value_id', 'attribute_id')
                    ->map(fn ($id) => (string) $id)->all(),
            ];
        })->values()->all();
        $this->variantUploads = [];
        $this->resetValidation();
    }

    private function rules($attributes, $configurable): array
    {
        $rules = [
            'attributeValues' => ['array'],
            'configurableAttributeIds' => ['array'],
            'configurableAttributeIds.*' => ['integer', Rule::in($configurable->keys()->all())],
            'variants' => ['array', 'max:250'],
            'variantUploads.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
        ];

        foreach ($attributes as $attribute) {
            $key = 'attributeValues.'.$attribute->id;
            $identifier = $this->identifier($attribute);
            $required = (bool) $attribute->require;

            $rules[$key] = match ($identifier) {
                'select' => [$required ? 'required' : 'nullable', 'integer', Rule::in($attribute->values->pluck('id')->all())],
                'multiselect' => [$required ? 'required' : 'nullable', 'array', $required ? 'min:1' : null],
                'boolean' => [$required ? 'required' : 'nullable', Rule::in(['0', '1', 0, 1])],
                'date' => [$required ? 'required' : 'nullable', 'date_format:Y-m-d'],
                'datetime' => [$required ? 'required' : 'nullable', 'date'],
                'number', 'price' => [$required ? 'required' : 'nullable', 'numeric'],
                'textarea' => [$required ? 'required' : 'nullable', 'string', 'max:65535'],
                default => [$required ? 'required' : 'nullable', 'string', 'max:255'],
            };

            $rules[$key] = array_values(array_filter($rules[$key], fn ($rule) => $rule !== null));
            if ($identifier === 'multiselect') {
                $rules[$key.'.*'] = ['integer', Rule::in($attribute->values->pluck('id')->all())];
            }
        }

        foreach ($this->variants as $index => $row) {
            $variantId = (int) ($row['id'] ?? 0);
            $rules["variants.$index.name"] = ['nullable', 'string', 'max:255'];
            $rules["variants.$index.sku"] = [
                'required', 'string', 'max:100',
                Rule::unique('product_variants', 'sku')->ignore($variantId ?: null),
            ];
            $rules["variants.$index.price"] = ['required', 'numeric', 'min:0'];
            $rules["variants.$index.stock"] = ['required', 'integer', 'min:0'];
            $rules["variants.$index.status"] = ['required', Rule::in([0, 1])];
            $rules["variants.$index.remove_thumb"] = ['boolean'];

            foreach ($this->configurableAttributeIds as $attributeId) {
                $attribute = $configurable->get((int) $attributeId);
                if ($attribute) {
                    $rules["variants.$index.attributes.$attributeId"] = [
                        'required', 'integer', Rule::in($attribute->values->pluck('id')->all()),
                    ];
                }
            }
        }

        return $rules;
    }

    private function validationAttributes($attributes, $configurable): array
    {
        $labels = [];
        foreach ($attributes as $attribute) {
            $labels['attributeValues.'.$attribute->id] = $attribute->name;
        }
        foreach ($this->variants as $index => $row) {
            $number = $index + 1;
            foreach (['name', 'sku', 'price', 'stock', 'status'] as $field) {
                $labels["variants.$index.$field"] = "variant $number $field";
            }
            foreach ($this->configurableAttributeIds as $attributeId) {
                $labels["variants.$index.attributes.$attributeId"] = 'variant '.$number.' '.$configurable->get((int) $attributeId)?->name;
            }
        }

        return $labels;
    }

    private function validateVariantCombinations($configurable): bool
    {
        if ($this->variants !== [] && $this->configurableAttributeIds === []) {
            $this->addError('configurableAttributeIds', 'Select at least one configurable attribute before adding variants.');

            return false;
        }

        $combinations = [];
        $skus = [];
        $valid = true;

        foreach ($this->variants as $index => $row) {
            $sku = Str::lower(trim((string) ($row['sku'] ?? '')));
            if (isset($skus[$sku])) {
                $this->addError("variants.$index.sku", 'Variant SKUs must be unique.');
                $valid = false;
            }
            $skus[$sku] = true;

            $combination = collect($this->configurableAttributeIds)
                ->map(fn ($attributeId) => (string) ($row['attributes'][$attributeId] ?? ''))
                ->implode(':');
            if (isset($combinations[$combination])) {
                $this->addError("variants.$index.attributes", 'This variant option combination is already used.');
                $valid = false;
            }
            $combinations[$combination] = true;
        }

        return $valid;
    }

    private function product(): Product
    {
        return Product::query()->findOrFail($this->productId);
    }

    private function family(Product $product): AttributeFamily
    {
        abort_unless($product->attribute_family_id, 404);

        return AttributeFamily::query()->with([
            'groups.attributes.values' => fn ($query) => $query->orderBy('sort_order'),
            'groups.attributes.attribute_type',
        ])->findOrFail($product->attribute_family_id);
    }

    private function identifier(Attribute $attribute): string
    {
        return (string) Str::of($attribute->attribute_type?->identifier ?? 'text')
            ->lower()
            ->replace(['-', ' '], '_')
            ->replaceMatches('/_+/', '_')
            ->replace('multi_select', 'multiselect');
    }

    private function isVariantAttribute(Attribute $attribute): bool
    {
        return (bool) $attribute->configurable && $this->identifier($attribute) === 'select';
    }

    private function isBlank(mixed $value): bool
    {
        return $value === null || $value === '' || $value === [];
    }
}
