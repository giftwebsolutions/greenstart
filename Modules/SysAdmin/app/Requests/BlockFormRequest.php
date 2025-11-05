<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\Page;

class BlockFormRequest extends FormRequest
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
            'sysadmin.cms.block.create',  => $this->store(),
            'sysadmin.block.edit' => $this->update(),
            'sysadmin.block.update' => $this->update(),
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
            'key' => 'required|string|unique:blocks|max:30',
            'title' => 'required|string|max:120',
            'value' => 'required|string',
            'icon' => 'string|max:100',
            'thumbnail' => 'image|mimes:jpg,png,jpeg|max:2048'
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
            'key' => 'required|string|max:30|unique:blocks,key,' . $this->id,
            'title' => 'required|string|max:120',
            'value' => 'required|string',
            'icon' => 'string|max:100',
            'thumbnail' => 'image|mimes:jpg,png,jpeg|max:2048'
        ];
    }
}
