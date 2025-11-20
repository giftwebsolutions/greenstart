<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Add your permission logic here if needed
        return true;
    }

    public function rules(): array
    {
        $routeName = $this->route()?->getName();

        return match ($routeName) {
            'sysadmin.product.store',
            'sysadmin.product.create'  => $this->storeRules(),
            'sysadmin.product.update',
            'sysadmin.product.edit'    => $this->updateRules(),

            // Fallback
            default                    => $this->storeRules(),
        };
    }

    /**
     * Rules for CREATE
     */
    protected function storeRules(): array
    {
        return [
            'title'                => ['required', 'string', 'max:255'],
            'slug'                 => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('product', 'slug'),
            ],
            'keywords'             => ['required', 'string', 'max:120'],
            'short_description'    => ['required', 'string', 'max:180'],
            'description'          => ['required', 'string'],
            'sku'                  => ['nullable', 'string', 'max:100'],
            'type'                 => ['required', 'integer'],
            'is_featured'          => ['nullable', 'boolean'],
            'video'                => ['nullable', 'string', 'max:255'],
            'catalog'              => ['nullable', 'string', 'max:255'],
            'thumb'                => ['nullable', 'string', 'max:255'],
            'sort_order'           => ['nullable', 'integer'],
            'status'               => ['nullable', 'integer'],
            'hits'                 => ['nullable', 'integer'],
            'product_category'     => ['required', 'integer'],
            'sub_product_category' => ['required', 'integer'],
            'slider'               => ['nullable', 'boolean'],
            'order'                => ['nullable', 'integer'],
        ];
    }

    /**
     * Rules for UPDATE
     */
    protected function updateRules(): array
    {
        // Get ID from route: /product/{product}
        // adjust 'product' if your route parameter key is different
        $productId = $this->route('product') ?? $this->route('id');

        return [
            'title'                => ['required', 'string', 'max:255'],
            'slug'                 => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('product', 'slug')->ignore($productId),
            ],
            'keywords'             => ['required', 'string', 'max:120'],
            'short_description'    => ['required', 'string', 'max:180'],
            'description'          => ['required', 'string'],
            'sku'                  => ['nullable', 'string', 'max:100'],
            'type'                 => ['required', 'integer'],
            'is_featured'          => ['nullable', 'boolean'],
            'video'                => ['nullable', 'string', 'max:255'],
            'catalog'              => ['nullable', 'string', 'max:255'],
            'thumb'                => ['nullable', 'string', 'max:255'],
            'sort_order'           => ['nullable', 'integer'],
            'status'               => ['nullable', 'integer'],
            'hits'                 => ['nullable', 'integer'],
            'product_category'     => ['required', 'integer'],
            'sub_product_category' => ['required', 'integer'],
            'slider'               => ['nullable', 'boolean'],
            'order'                => ['nullable', 'integer'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Normalize checkbox fields to 0/1
        $data['is_featured'] = $this->boolean('is_featured');
        $data['slider']      = $this->boolean('slider');

        return $data;
    }
}
