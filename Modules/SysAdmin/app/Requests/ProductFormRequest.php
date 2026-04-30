<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

     return match (request()->route()->action['as']) {
            'sysadmin.catalog.product.create',  => $this->store(),
            'sysadmin.catalog.product.edit' => $this->update(),
            'sysadmin.catalog.product.update' => $this->update(),
            default => $this->store()
        };
    }

    /**
     * CREATE rules
     */
    public function store(): array
    {
        return [
            'title'                => ['required', 'string', 'max:255'],
            'slug'                 => ['nullable', 'string', 'max:255', 'unique:product,slug'],
            'keywords'             => ['nullable', 'string', 'max:120'],
            'short_description'    => ['nullable', 'string', 'max:180'],
            'description'          => ['nullable', 'string'], // editor can send empty initially
            'sku'                  => ['nullable', 'string', 'max:100'],

            'product_code'           => ['nullable', 'string', 'max:100'],
            'model'                  => ['nullable', 'string', 'max:100'],
            
            // Auto-determined by attribute set – do NOT validate type from request
            'type' => ['nullable', 'integer', 'min:0'],

            'is_featured'          => ['nullable', 'boolean'],
            'video'                => ['nullable', 'string', 'max:255'],
            'catalog'              => ['nullable', 'string', 'max:255'],

            // thumb is optional because image priority fallback exists
            'thumb'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            // gallery uploads
            'gallery_images'       => ['nullable', 'array'],
            'gallery_images.*'     => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'sort_order'           => ['nullable', 'integer', 'min:0'],
            'status'               => ['nullable', 'integer', Rule::in([0, 1])],
            'hits'                 => ['nullable', 'integer', 'min:0'],

            'mrp'                  => ['required', 'numeric', 'min:0'],
            'sales_price'          => ['required', 'numeric', 'min:0'],

            'product_category'     => ['required', 'integer', 'min:1'],
            'sub_product_category' => ['nullable', 'integer', 'min:1'],

            'attribute_set_id'     => ['required', 'integer', 'min:1'],

            'slider'               => ['nullable', 'boolean'],
            'order'                => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * UPDATE rules
     */
    public function update(): array
    {
        $id = (int)($this->route('product') ?? $this->id ?? 0);

        return [
            'title'                => ['required', 'string', 'max:255'],
            'slug'                 => ['nullable', 'string', 'max:255', Rule::unique('product', 'slug')->ignore($id)],
            'keywords'             => ['nullable', 'string', 'max:120'],
            'short_description'    => ['nullable', 'string', 'max:180'],
            'description'          => ['nullable', 'string'],
            'sku'                  => ['nullable', 'string', 'max:100'],

            'product_code'           => ['nullable', 'string', 'max:100'],
            'model'                  => ['nullable', 'string', 'max:100'],

            // Auto-determined by attribute set – do NOT validate type from request
            'type' => ['nullable', 'integer', 'min:0'],

            'is_featured'          => ['nullable', 'boolean'],
            'video'                => ['nullable', 'string', 'max:255'],
            'catalog'              => ['nullable', 'string', 'max:255'],

            'thumb'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            // edit: explicit remove flags
            'remove_thumb'         => ['nullable', 'integer', Rule::in([0, 1])],

            // gallery uploads
            'gallery_images'       => ['nullable', 'array'],
            'gallery_images.*'     => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            // gallery explicit removals
            'remove_gallery_ids'   => ['nullable', 'array'],
            'remove_gallery_ids.*' => ['integer', 'min:1'],

            'sort_order'           => ['nullable', 'integer', 'min:0'],
            'status'               => ['nullable', 'integer', Rule::in([0, 1])],
            'hits'                 => ['nullable', 'integer', 'min:0'],

            'mrp'                  => ['required', 'numeric', 'min:0'],
            'sales_price'          => ['required', 'numeric', 'min:0'],

            'product_category'     => ['required', 'integer', 'min:1'],
            'sub_product_category' => ['nullable', 'integer', 'min:1'],

            'attribute_set_id'     => ['required', 'integer', 'min:1'],

            'slider'               => ['nullable', 'boolean'],
            'order'                => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Trim strings, convert empty strings to null where helpful.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title'             => is_string($this->title) ? trim($this->title) : $this->title,
            'slug'              => is_string($this->slug) ? trim($this->slug) : $this->slug,
            'keywords'          => is_string($this->keywords) ? trim($this->keywords) : $this->keywords,
            'sku'               => is_string($this->sku) ? trim($this->sku) : $this->sku,
            'video'             => is_string($this->video) ? trim($this->video) : $this->video,
            'catalog'           => is_string($this->catalog) ? trim($this->catalog) : $this->catalog,
            'short_description' => is_string($this->short_description) ? trim($this->short_description) : $this->short_description,
        ]);
    }

    /**
     * Normalize some fields after validation
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        $data['is_featured'] = $this->boolean('is_featured');
        $data['slider']      = $this->boolean('slider');

        // Ensure remove flags default
        if (!isset($data['remove_thumb'])) {
            $data['remove_thumb'] = 0;
        }

        return $data;
    }
}
