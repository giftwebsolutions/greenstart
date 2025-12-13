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

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $routeName = request()->route()->action['as'] ?? null;

        return match ($routeName) {
            'sysadmin.product.create',
            'sysadmin.product.store'  => $this->store(),

            'sysadmin.product.edit',
            'sysadmin.product.update' => $this->update(),

            default                   => $this->store(),
        };
    }

    /**
     * Rules for CREATE (POST)
     */
    public function store(): array
    {
        return [
            'title'                => 'required|string|max:255',
            'slug'                 => 'nullable|string|max:255|unique:product,slug',
            'keywords'             => 'required|string|max:120',
            'short_description'    => 'required|string|max:180',
            'description'          => 'required|string',
            'sku'                  => 'nullable|string|max:100',
            'type'                 => 'required|integer',
            'is_featured'          => 'nullable|boolean',
            'video'                => 'nullable|string|max:255',
            'catalog'              => 'nullable|string|max:255',
            'thumb'                => 'image|mimes:jpg,png,jpeg|max:2048',
            'sort_order'           => 'nullable|integer',
            'status'               => 'nullable|integer',
            'hits'                 => 'nullable|integer',
            'mrp'                  => 'required|integer',
            'sales_price'          => 'nullable|integer',
            'product_category'     => 'required|integer',
            'sub_product_category' => 'nullable|integer',
            'attribute_set_id'  => 'required|integer',
            'slider'               => 'nullable|boolean',
            'order'                => 'nullable|integer',
        ];
    }

    /**
     * Rules for UPDATE (PUT/PATCH)
     */
    public function update(): array
    {

        return [
            'title'                => 'required|string|max:255',
            'slug'                 => 'nullable|string|max:255|unique:product,slug,' . $this->id,
            'keywords'             => 'required|string|max:120',
            'short_description'    => 'required|string|max:180',
            'description'          => 'required|string',
            'sku'                  => 'nullable|string|max:100',
            'type'                 => 'required|integer',
            'is_featured'          => 'nullable|boolean',
            'video'                => 'nullable|string|max:255',
            'catalog'              => 'nullable|string|max:255',
            'thumb'                => 'image|mimes:jpg,png,jpeg|max:2048',
            'sort_order'           => 'nullable|integer',
            'status'               => 'nullable|integer',
            'hits'                 => 'nullable|integer',
            'mrp'                  => 'required|integer',
            'sales_price'          => 'nullable|integer',
            'product_category'     => 'required|integer',
            'sub_product_category' => 'nullable|integer',
            'attribute_set_id'     => 'required|integer',
            'slider'               => 'nullable|boolean',
            'order'                => 'nullable|integer',
        ];
    }

    /**
     * Normalize some fields after validation
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Normalize checkbox fields to 0/1
        $data['is_featured'] = $this->boolean('is_featured');
        $data['slider']      = $this->boolean('slider');

        return $data;
    }
}
