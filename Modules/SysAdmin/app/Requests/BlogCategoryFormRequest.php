<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\Page;

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
        return match (request()->route()->action['as']) {
            'sysadmin.blog.category.create',  => $this->store(),
            'sysadmin.blog.category.edit' => $this->update(),
            'sysadmin.blog.category.update' => $this->update(),
            default => $this->store()
        };
    }


    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function store()
    {
        return [
            'name' => 'required|string|max:30|unique:blog_categories',
            //'slug' => 'required|string|max:30|unique:blog_categories',
            'keywords' => 'string|max:150',
            'description' => 'string',
            'content' => 'string',
            'parent_id' => 'integer|nullable',
            'featured_image' => 'image|mimes:jpg,png,jpeg|max:2048'
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
            'name' => 'required|string|max:30|unique:blog_categories,name,' . $this->id,
            //'slug' => 'required|string|max:30|unique:blog_categories,slug,' . $this->id,
            'keywords' => 'string|max:150',
            'description' => 'string',
            'content' => 'string',
            'parent_id' => 'integer|nullable',
            'featured_image' => 'image|mimes:jpg,png,jpeg|max:2048'
        ];
    }
}
