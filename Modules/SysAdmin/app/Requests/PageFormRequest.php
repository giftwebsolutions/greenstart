<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageFormRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:120', 'unique:pages,name'],
            'title' => ['required', 'string', 'max:255', 'unique:pages,title'],
            'parent_id' => ['nullable', 'integer', Rule::exists('pages', 'id')],
            'content' => ['required', 'string'],
            'keywords' => ['required', 'string', 'max:220'],
            'description' => ['required', 'string', 'max:2000'],
            'status' => ['required', 'integer', Rule::in([0, 1, 2])],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'remove_banner' => ['nullable', 'boolean'],
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
            'name' => ['required', 'string', 'max:120', Rule::unique('pages', 'name')->ignore($this->route('id'))],
            'title' => ['required', 'string', 'max:255', Rule::unique('pages', 'title')->ignore($this->route('id'))],
            'parent_id' => ['nullable', 'integer', Rule::exists('pages', 'id')->where(fn ($query) => $query->where('id', '!=', $this->route('id')))],
            'content' => ['required', 'string'],
            'keywords' => ['required', 'string', 'max:220'],
            'description' => ['required', 'string', 'max:2000'],
            'status' => ['required', 'integer', Rule::in([0, 1, 2])],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'remove_banner' => ['nullable', 'boolean'],
        ];
    }
}
