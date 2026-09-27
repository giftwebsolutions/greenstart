<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogFormRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'unique:blogs,title'],
            'category_id' => ['required', 'integer', Rule::exists('blog_categories', 'id')],
            'content' => ['required', 'string'],
            'keywords' => ['required', 'string', 'max:220'],
            'description' => ['required', 'string', 'max:2000'],
            'video_url' => ['nullable', 'url:http,https', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'status' => ['required', 'integer', Rule::in([0, 1, 2])],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:4096'],
            'remove_featured_image' => ['nullable', 'boolean'],
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
            'title' => ['required', 'string', 'max:255', Rule::unique('blogs', 'title')->ignore($this->route('id'))],
            'category_id' => ['required', 'integer', Rule::exists('blog_categories', 'id')],
            'content' => ['required', 'string'],
            'keywords' => ['required', 'string', 'max:220'],
            'description' => ['required', 'string', 'max:2000'],
            'video_url' => ['nullable', 'url:http,https', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'status' => ['required', 'integer', Rule::in([0, 1, 2])],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp', 'max:4096'],
            'remove_featured_image' => ['nullable', 'boolean'],
        ];
    }
}
