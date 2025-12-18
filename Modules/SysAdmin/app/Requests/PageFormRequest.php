<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\Page;

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
        return match (request()->route()->action['as']) {
            'sysadmin.cms.page.create',  => $this->store(),
            'sysadmin.cms.page.edit' => $this->update(),
            'sysadmin.cms.page.update' => $this->update(),
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
            'name' => 'required|string|unique:pages|max:120',
            'title' => 'required|string|unique:pages',
            'parent_id' => 'nullable|integer',
            'content' => 'required|string',
            'keywords' => 'required|string|max:220',
            'description' => 'required|string|max:220',
            'featured_image' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'banner' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
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
            'name' => 'required|string|max:120|unique:pages,name,' . $this->id,
            'title' => 'required|string|unique:pages,title,' . $this->id,
            'parent_id' => 'nullable|integer',
            'content' => 'required|string',
            'keywords' => 'required|string|max:220',
            'description' => 'required|string|max:220',
            'featured_image' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            'banner' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }
}
