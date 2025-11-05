<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnquiryFormRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:120',
            'city' => 'nullable|string',
            'department_id' => 'numeric|min:0|not_in:0',
            'doctor_id' => 'numeric|min:0|not_in:0',
            'date' => 'required|string',
            'time' => 'nullable',
            'mobile' => 'required|digits:10',
            'email' => 'nullable|email',
            'message' => 'string'
        ];
    }
}
