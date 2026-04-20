<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('PATCH')) {
            return [
                'name' => 'required|string|max:100|unique:tags,name,' . $this->route('id'),
            ];
        }

        return [
            'name' => 'required|string|max:100|unique:tags',
        ];
    }
}
