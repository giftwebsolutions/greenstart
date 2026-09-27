<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->isMethod('PATCH') || $this->isMethod('PUT')
            ? $this->update()
            : $this->store();
    }

    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function store()
    {
        return [
            'name' => ['required', 'string', 'max:120', 'unique:blog_categories,name'],
            'keywords' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer', Rule::exists('blog_categories', 'id')],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:4096'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'status' => ['required', 'integer', Rule::in([0, 1, 2])],
        ];
    }

    /**
     * Get the validation rules that apply to the put/patch request.
     *
     * @return array
     */
    public function update()
    {
        return [
            'name' => ['required', 'string', 'max:120', Rule::unique('blog_categories', 'name')->ignore($this->route('id'))],
            'keywords' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer', Rule::exists('blog_categories', 'id')->where(fn ($query) => $query->where('id', '!=', $this->route('id')))],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:4096'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'status' => ['required', 'integer', Rule::in([0, 1, 2])],
        ];
    }
}
