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
        return match (request()->route()->action['as']) {
            'sysadmin.blog.create',  => $this->store(),
            'sysadmin.blog.edit' => $this->update(),
            'sysadmin.blog.update' => $this->update(),
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
            'title' => 'required|string|unique:blogs',
            'category_id' => 'required|integer',
            'content' => 'required|string',
            'keywords' => 'required|string|max:220',
            'description' => 'required|string|max:220',
            'published_at' => 'string',
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
            'title' => 'required|string|max:120|unique:blogs,title,' . $this->id,
            'category_id' => 'required|integer',
            'content' => 'required|string',
            'keywords' => 'required|string|max:220',
            'description' => 'required|string|max:220',
            'published_at' => 'string',
            'featured_image' => 'image|mimes:jpg,png,jpeg|max:2048'
        ];
    }
}
