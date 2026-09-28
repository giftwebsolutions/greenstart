<?php

namespace Modules\SysAdmin\Livewire\Catalog\Products;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\SysAdmin\Helpers\ImageUploader;
use Modules\SysAdmin\Models\AttributeFamily;
use Modules\SysAdmin\Models\Product;
use Modules\SysAdmin\Models\ProductCategory;
use Modules\SysAdmin\Models\ProductImage;
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

    public int $stock = 1;

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

    /** @var array<int, array{id: int, image: string, url: string}> */
    public array $existingGalleryImages = [];

    /** @var array<int, int> */
    public array $removedGalleryImageIds = [];

    public bool $removeThumb = false;

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
        $this->stock = (int) $product->stock;
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
        $this->loadExistingGallery($product);
    }

    public function updatedProductCategory(): void
    {
        $this->subProductCategory = '';
        $this->resetValidation('subProductCategory');
    }

    public function updatedThumb(): void
    {
        $this->removeThumb = false;
    }

    public function removeThumbnail(): void
    {
        $this->thumb = null;
        $this->removeThumb = true;
        $this->resetValidation('thumb');
    }

    public function removePendingGalleryImage(int $index): void
    {
        if (! array_key_exists($index, $this->galleryImages)) {
            return;
        }

        unset($this->galleryImages[$index]);
        $this->galleryImages = array_values($this->galleryImages);
        $this->resetValidation('galleryImages');
    }

    public function removeExistingGalleryImage(int $imageId): void
    {
        $image = collect($this->existingGalleryImages)->firstWhere('id', $imageId);

        if (! $image) {
            return;
        }

        $this->removedGalleryImageIds[] = $imageId;
        $this->removedGalleryImageIds = array_values(array_unique($this->removedGalleryImageIds));
        $this->existingGalleryImages = array_values(array_filter(
            $this->existingGalleryImages,
            fn (array $row): bool => $row['id'] !== $imageId,
        ));
    }

    public function moveExistingGalleryImage(int $index, string $direction): void
    {
        $target = $direction === 'up' ? $index - 1 : $index + 1;

        if (! isset($this->existingGalleryImages[$index], $this->existingGalleryImages[$target])) {
            return;
        }

        [$this->existingGalleryImages[$index], $this->existingGalleryImages[$target]] = [
            $this->existingGalleryImages[$target],
            $this->existingGalleryImages[$index],
        ];
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
            'stock' => $this->stock,
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
            // A configurable family only enables variant creation. The product
            // becomes variable after the Attribute Editor persists real rows.
            'type' => $this->productId && Product::query()->whereKey($this->productId)->whereHas('variants')->exists() ? 2 : 1,
        ];

        if ($this->thumb) {
            $data['thumb'] = $this->thumb;
        }

        /** @var ProductRepository $repository */
        $repository = app(ProductRepository::class);
        $oldThumb = $this->productId ? Product::query()->whereKey($this->productId)->value('thumb') : null;
        $product = $repository->saveOrUpdate($data, $this->productId ?? 0);

        if ($this->removeThumb && ! $this->thumb && $product->thumb) {
            $oldThumb = $product->thumb;
            $product->forceFill(['thumb' => null])->save();
        }

        $existingImageIds = $product->images()->pluck('id')->map(fn ($id) => (int) $id)->all();

        if ($this->galleryImages !== []) {
            $repository->syncGallery($product, $this->galleryImages, false);
        }

        $removedImages = $product->images()
            ->whereIn('id', $this->removedGalleryImageIds)
            ->get();
        ProductImage::query()
            ->where('product_id', $product->id)
            ->whereIn('id', $removedImages->pluck('id'))
            ->delete();

        $newImageIds = $product->images()
            ->whereNotIn('id', $existingImageIds)
            ->orderBy('id')
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();
        $galleryOrder = array_merge(
            array_column($this->existingGalleryImages, 'id'),
            $newImageIds,
        );

        foreach ($galleryOrder as $position => $imageId) {
            ProductImage::query()
                ->where('product_id', $product->id)
                ->whereKey($imageId)
                ->update(['sort_order' => $position]);
        }

        if ($oldThumb && $this->removeThumb) {
            ImageUploader::remove((string) $product->created_at, (string) $oldThumb);
        }
        foreach ($removedImages as $removedImage) {
            ImageUploader::remove((string) $product->created_at, (string) $removedImage->image);
        }

        $this->productId = $product->id;
        session()->flash('success', 'Product saved successfully.');

        $route = $manageAttributes
            ? 'sysadmin.catalog.product.attributes'
            : 'sysadmin.catalog.product.edit';

        $this->redirectRoute($route, $product->id, navigate: false);
    }

    private function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => array_intersect_key($this->rules(), array_flip([
                'title', 'slug', 'productCode', 'modelNumber', 'sku', 'keywords',
                'shortDescription', 'description',
            ])),
            2 => array_intersect_key($this->rules(), array_flip([
                'mrp', 'salesPrice', 'stock', 'productCategory', 'subProductCategory', 'attributeFamilyId',
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
            'shortDescription' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (mb_strlen(trim(strip_tags((string) $value))) > 500) {
                        $fail('The short description may not exceed 500 visible characters.');
                    }
                },
            ],
            'description' => ['nullable', 'string'],
            'mrp' => ['required', 'numeric', 'min:0'],
            'salesPrice' => ['required', 'numeric', 'min:0', 'lte:mrp'],
            'stock' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'productCategory' => [
                'required',
                'integer',
                Rule::exists('product_category', 'id')->where(fn ($query) => $query
                    ->where('parent_id', 0)
                    ->where('status', '1')),
            ],
            'subProductCategory' => [
                'nullable',
                'integer',
                Rule::exists('product_category', 'id')->where(fn ($query) => $query
                    ->where('parent_id', $this->productCategory ?: 0)
                    ->where('status', '1')),
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
            'galleryImages' => ['array', 'max:'.max(0, 12 - count($this->existingGalleryImages))],
            'galleryImages.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function render()
    {
        // product_category.status is an ENUM('0', '1'); bind as a string so MySQL
        // compares its value instead of interpreting 1 as the enum's first index.
        $categories = ProductCategory::query()->where('parent_id', 0)->where('status', '1')->orderBy('name')->get(['id', 'name']);
        $subCategories = $this->productCategory
            ? ProductCategory::query()->where('parent_id', $this->productCategory)->where('status', '1')->orderBy('name')->get(['id', 'name'])
            : collect();
        $families = AttributeFamily::query()->active()->withCount(['groups', 'products'])->orderBy('name')->get();
        $product = $this->productId ? Product::with('images')->find($this->productId) : null;

        return view('sysadmin::livewire.catalog.products.form-wizard', compact(
            'categories', 'subCategories', 'families', 'product'
        ));
    }

    private function loadExistingGallery(Product $product): void
    {
        $this->existingGalleryImages = $product->images()
            ->get()
            ->map(fn (ProductImage $image): array => [
                'id' => (int) $image->id,
                'image' => (string) $image->image,
                'url' => $image->image_url,
            ])
            ->all();
    }
}
