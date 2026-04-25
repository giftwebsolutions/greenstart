<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderItemFormRequest extends FormRequest
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
        if ($this->isMethod('PATCH')) {
            return $this->update();
        }
        return $this->store();
    }


    /**
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function store()
    {
        return [
            'slider_id'   => 'required|integer|exists:sliders,id',
            'path'        => 'required|string|max:120',
            'title'       => 'required|string|max:120',
            'target'      => 'required|string|max:120',
            'file'        => 'required|file|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string',
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
            'slider_id'   => 'required|integer|exists:slider_id',
            'path'        => 'required|string|max:120',
            'title'       => 'required|string|max:120',
            'target'      => 'required|string|max:120',
            'file'        => 'required|file|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string',
        ];
    }
}
