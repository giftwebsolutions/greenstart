<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get validation rules based on route action
     */
    public function rules()
    {
        return match (request()->route()->action['as']) {
            'sysadmin.testimonial.store'  => $this->store(),
            'sysadmin.testimonial.update' => $this->update(),
            default => $this->store(),
        };
    }

    /**
     * Rules for creating testimonial
     */
    public function store()
    {
        return [
            'name'   => 'required|string|max:120',
            'content'=> 'required|string',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Rules for updating testimonial
     */
    public function update()
    {
        return [
            'name'   => 'required|string|max:120',
            'content'=> 'required|string',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
