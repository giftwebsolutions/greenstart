<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Add your permission logic here if needed
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product'); // if route parameter is {product}

        return [
            'title'             => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255', 'unique:product,slug,' . $productId],
            'keywords'          => ['required', 'string', 'max:120'],
            'short_description' => ['required', 'string', 'max:180'],
            'description'       => ['required', 'string'],
            'sku'               => ['nullable', 'string', 'max:100'],
            'type'              => ['required', 'integer'],
            'is_featured'       => ['nullable', 'boolean'],
            'video'             => ['nullable', 'string', 'max:255'],
            'catalog'           => ['nullable', 'string', 'max:255'],
            'thumb'             => ['nullable', 'string', 'max:255'],
            'sort_order'        => ['nullable', 'integer'],
            'status'            => ['required', 'integer'],
            'hits'              => ['nullable', 'integer'],
            'product_category'  => ['required', 'integer'],
            'sub_product_category' => ['required', 'integer'],
            'slider'            => ['nullable', 'boolean'],
            'order'             => ['required', 'integer'],
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
