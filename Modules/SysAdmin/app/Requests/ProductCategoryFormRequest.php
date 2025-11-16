<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\ProductCategory;

class ProductCategoryFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Apply validation rules based on route name.
     */
    public function rules()
    {
        return match (request()->route()->action['as'] ?? null) {
            'sysadmin.catalog.category.create',
            'sysadmin.catalog.category.store' => $this->store(),

            'sysadmin.catalog.category.edit',
            'sysadmin.catalog.category.update' => $this->update(),

            default => $this->store(),
        };
    }

    /**
     * Validation rules for store
     */
    public function store()
    {
        return [
            'parent_id'   => ['nullable', 'integer', 'exists:product_category,id'],
            'name'        => ['required', 'string', 'max:255', 'unique:product_category,name'],
            'description' => ['nullable', 'string'],
            'banner'      => ['nullable', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:product_category,slug'],
            'image'       => ['nullable', 'string', 'max:255'],
            'sort'        => ['nullable', 'integer', 'min:0'],
            'status'      => ['required', Rule::in(array_keys(ProductCategory::$statuses))]
        ];
    }

    /**
     * Validation rules for update
     */
    public function update()
    {
        return [
            'parent_id'   => ['nullable', 'integer', 'exists:product_category,id'],
            'name'        => 'required|string|max:255|unique:product_category,name,' . $this->id,
            'description' => ['nullable', 'string'],
            'banner'      => ['nullable', 'string', 'max:255'],
            'slug'        =>  'nullable|string|max:255|unique:product_category,slug,' . $this->id,
            'image'       => ['nullable', 'string', 'max:255'],
            'sort'        => ['nullable', 'integer', 'min:0'],
            'status'      => ['required', Rule::in(array_keys(ProductCategory::$statuses))]
        ];
    }

    /**
     * Friendly attribute names for validation errors
     */
    public function attributes()
    {
        return [
            'name'        => 'category name',
            'parent_id'   => 'parent category',
            'sort'        => 'sort order',
            'slug'        => 'slug',
            'status'      => 'status',
        ];
    }

    /**
     * Modify validated data before controller receives it.
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Normalize empty parent_id -> null (model will convert to 0)
        if (empty($data['parent_id'])) {
            $data['parent_id'] = null;
        }

        return $data;
    }
}
