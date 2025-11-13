<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id'    => ['nullable', 'integer', 'exists:product_categories,id'],
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'banner'       => ['nullable', 'string', 'max:255'],
            'slug'         => ['required', 'string', 'max:255', 'unique:product_categories,slug,' . $this->id],
            'image'        => ['nullable', 'string', 'max:255'],
            'sort'         => ['nullable', 'integer'],
            'status'       => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'The category name is required.',
            'slug.required'   => 'The slug field is required.',
            'status.required' => 'The status field is required.',
        ];
    }
}
