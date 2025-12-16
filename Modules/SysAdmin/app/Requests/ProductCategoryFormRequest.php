<?php



namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\ProductCategory;

class ProductCategoryFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules based on route name.
     */
    public function rules(): array
    {
        $routeName = request()->route()->action['as'] ?? null;

        //dd($routeName);

        return match ($routeName) {
            'sysadmin.catalog.productcategory.create',
            'sysadmin.catalog.productcategory.store'  => $this->store(),

            'sysadmin.catalog.productcategory.edit',
            'sysadmin.catalog.productcategory.update' => $this->update(),

            default                             => $this->store(),
        };
    }

    /**
     * Rules for CREATE (POST)
     */
    public function store(): array
    {
        return [
            'parent_id'   => ['nullable', 'integer', 'exists:product_category,id'],
            'name'        => ['required', 'string', 'max:255', 'unique:product_category,name'],
            'description' => ['nullable', 'string'],
            'banner'      => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:3072'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:product_category,slug'],
            'image'       => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:3072'],
            'sort'        => ['nullable', 'integer', 'min:0'],
            'status'      => ['required', Rule::in(array_keys(ProductCategory::$statuses))]
        ];
    }

    /**
     * Rules for UPDATE (PUT/PATCH)
     */
    public function update(): array
    {
        return [
            'parent_id'   => ['nullable', 'integer', 'exists:product_category,id'],
            'name'        => 'required|string|max:255|unique:product_category,name,' . $this->id,
            'description' => ['nullable', 'string'],
            'banner'      => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:3072'],
            'slug'        => 'nullable|string|max:255|unique:product_category,slug,' . $this->id,
            'image'       => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:3072'],
            'sort'        => ['nullable', 'integer', 'min:0'],
            'status'      => ['required', Rule::in(array_keys(ProductCategory::$statuses))]
        ];
    }

    /**
     * Friendly attribute names for validation messages
     */
    public function attributes(): array
    {
        return [
            'name'      => 'category name',
            'description' =>'description',
            'parent_id' => 'parent category',
            'sort'      => 'sort order',
            'slug'      => 'slug',
            'banner'    => 'banner image',
            'image'     => 'category image',
            'status'    => 'status',
        ];
    }

    /**
     * Normalize validated data
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Normalize parent_id
        $data['parent_id'] = $data['parent_id'] ?: null;

        

        return $data;
    }
}
