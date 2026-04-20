<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('PATCH')) {
            return [
                'name'       => 'required|string|max:100|unique:roles,name,' . $this->route('id'),
                'guard_name' => 'required|string|max:100',
            ];
        }

        return [
            'name'       => 'required|string|max:100|unique:roles',
            'guard_name' => 'required|string|max:100',
        ];
    }
}
