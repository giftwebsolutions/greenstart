<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderFormRequest extends FormRequest
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
            'sysadmin.gallery.create',  => $this->store(),
            'sysadmin.gallery.edit' => $this->update(),
            'sysadmin.gallery.update' => $this->update(),
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
            'name' => 'required|string|unique:galleries|max:120',
            'description' => 'string',
            'status' => 'boolean',
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
            'name' => 'required|string|max:30|unique:galleries,name,' . $this->id,
            'description' => 'string',
            'status' => 'boolean',
            'thumbnail' => 'image|mimes:jpg,png,jpeg|max:2048'
        ];
    }
}
