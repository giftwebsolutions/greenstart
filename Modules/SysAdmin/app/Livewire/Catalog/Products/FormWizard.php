<?php

namespace Modules\SysAdmin\Livewire\Catalog\Products;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\SysAdmin\Models\AttributeFamily;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\ProductCategory;
use Modules\SysAdmin\Repository\ProductRepository;

class FormWizard extends Component
{
    use WithFileUploads;

    public ?int $productId = null;

    public int $step = 1;

    public string $title = '';

    public string $slug = '';

    public string $productCode = '';

    public string $modelNumber = '';

    public string $sku = '';

    public string $keywords = '';

    public string $shortDescription = '';

    public string $description = '';

    public string $mrp = '0.00';

    public string $salesPrice = '0.00';

    public string $productCategory = '';

    public string $subProductCategory = '';

    public string $attributeFamilyId = '';

    public string $video = '';

    public string $catalog = '';

    public int $sortOrder = 0;

    public int $status = 1;

    public bool $isFeatured = false;

    public bool $slider = false;

    public int $displayOrder = 0;

    public $thumb = null;

    public array $galleryImages = [];

    public function mount(?int $id = null): void
    {
        if (! $id) {
            return;
        }

        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->title = (string) $product->title;
        $this->slug = (string) $product->slug;
        $this->productCode = (string) $product->product_code;
        $this->modelNumber = (string) $product->model;
        $this->sku = (string) $product->sku;
        $this->keywords = (string) $product->keywords;
        $this->shortDescription = (string) $product->short_description;
        $this->description = (string) $product->description;
        $this->mrp = (string) $product->mrp;
        $this->salesPrice = (string) $product->sales_price;
        $this->productCategory = (string) $product->product_category;
        $this->subProductCategory = $product->sub_product_category ? (string) $product->sub_product_category : '';
        $this->attributeFamilyId = $product->attribute_family_id ? (string) $product->attribute_family_id : '';
        $this->video = (string) $product->video;
        $this->catalog = (string) $product->catalog;
        $this->sortOrder = (int) $product->sort_order;
        $this->status = (int) $product->status;
        $this->isFeatured = (bool) $product->is_featured;
        $this->slider = (bool) $product->slider;
        $this->displayOrder = (int) $product->order;
    }

    public function updatedProductCategory(): void
    {
        $this->subProductCategory = '';
    }

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step));
        $this->step = min(4, $this->step + 1);
    }

    public function previousStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function goToStep(int $step): void
    {
        if ($step < $this->step) {
            $this->step = max(1, min(4, $step));
        }
    }

    public function save(bool $manageAttributes = true): void
    {
        $this->validate($this->rules());

        $data = [
            'title' => trim($this->title),
            'slug' => trim($this->slug) ?: null,
            'product_code' => trim($this->productCode) ?: null,
            'model' => trim($this->modelNumber) ?: null,
            'sku' => trim($this->sku) ?: null,
            'keywords' => trim($this->keywords),
            'short_description' => trim($this->shortDescription) ?: null,
            'description' => trim($this->description),
            'mrp' => $this->mrp,
            'sales_price' => $this->salesPrice,
            'product_category' => (int) $this->productCategory,
            'sub_product_category' => $this->subProductCategory !== '' ? (int) $this->subProductCategory : 0,
            'attribute_family_id' => (int) $this->attributeFamilyId,
            'video' => trim($this->video) ?: null,
            'catalog' => trim($this->catalog) ?: null,
            'sort_order' => $this->sortOrder,
            'status' => $this->status,
            'is_featured' => $this->isFeatured,
            'slider' => $this->slider,
            'order' => $this->displayOrder,
            'type' => $this->familyHasVariants() ? 2 : 1,
        ];

        if ($this->thumb) {
            $data['thumb'] = $this->thumb;
        }

        /** @var ProductRepository $repository */
        $repository = app(ProductRepository::class);
        $product = $repository->saveOrUpdate($data, $this->productId ?? 0);

        if ($this->galleryImages !== []) {
            $repository->syncGallery($product, $this->galleryImages, false);
        }

        $this->productId = $product->id;
        session()->flash('success', 'Product saved successfully.');

        $route = $manageAttributes
            ? 'sysadmin.catalog.product.attributes'
            : 'sysadmin.catalog.product.edit';

        $this->redirectRoute($route, $product->id, navigate: false);
    }

    private function familyHasVariants(): bool
    {
        if (! $this->attributeFamilyId) {
            return false;
        }

        return AttributeFamily::query()
            ->whereKey($this->attributeFamilyId)
            ->whereHas('groups.attributes', fn ($query) => $query->where('configurable', 1))
            ->exists();
    }

    private function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => array_intersect_key($this->rules(), array_flip([
                'title', 'slug', 'productCode', 'modelNumber', 'sku', 'keywords',
                'shortDescription', 'description',
            ])),
            2 => array_intersect_key($this->rules(), array_flip([
                'mrp', 'salesPrice', 'productCategory', 'subProductCategory', 'attributeFamilyId',
            ])),
            3 => array_intersect_key($this->rules(), array_flip([
                'video', 'catalog', 'thumb', 'galleryImages', 'galleryImages.*',
                'sortOrder', 'status', 'isFeatured', 'slider', 'displayOrder',
            ])),
            default => $this->rules(),
        };
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('product', 'slug')->ignore($this->productId)],
            'productCode' => ['nullable', 'string', 'max:50'],
            'modelNumber' => ['nullable', 'string', 'max:150'],
            'sku' => ['nullable', 'string', 'max:100'],
            'keywords' => ['nullable', 'string', 'max:120'],
            'shortDescription' => ['nullable', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'mrp' => ['required', 'numeric', 'min:0'],
            'salesPrice' => ['required', 'numeric', 'min:0', 'lte:mrp'],
            'productCategory' => ['required', 'integer', Rule::exists('product_category', 'id')],
            'subProductCategory' => [
                'nullable',
                'integer',
                Rule::exists('product_category', 'id')->where('parent_id', $this->productCategory ?: 0),
            ],
            'attributeFamilyId' => ['required', 'integer', Rule::exists('attribute_families', 'id')],
            'video' => ['nullable', 'url:http,https', 'max:255'],
            'catalog' => ['nullable', 'url:http,https', 'max:255'],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:65535'],
            'status' => ['required', Rule::in([0, 1, 2])],
            'isFeatured' => ['boolean'],
            'slider' => ['boolean'],
            'displayOrder' => ['required', 'integer', 'min:0'],
            'thumb' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'galleryImages' => ['array', 'max:12'],
            'galleryImages.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function render()
    {
        $categories = ProductCategory::query()->where('parent_id', 0)->orderBy('name')->get(['id', 'name']);
        $subCategories = $this->productCategory
            ? ProductCategory::query()->where('parent_id', $this->productCategory)->orderBy('name')->get(['id', 'name'])
            : collect();
        $families = AttributeFamily::query()->active()->withCount(['groups', 'products'])->orderBy('name')->get();
        $product = $this->productId ? Product::with('images')->find($this->productId) : null;

        return view('sysadmin::livewire.catalog.products.form-wizard', compact(
            'categories', 'subCategories', 'families', 'product'
        ));
    }
}
