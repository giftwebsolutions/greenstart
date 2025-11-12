<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttributeGroupFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return match (request()->route()->action['as'] ?? null) {
            'sysadmin.catalog.attribute.group.store'  => $this->store(),
            'sysadmin.catalog.attribute.group.update' => $this->update(),
            default => $this->store(),
        };
    }

    protected function store(): array
    {
        return [
            'name'   => ['required', 'string', 'max:120', 'unique:attribute_group,name'],
            'slug'   => ['nullable', 'string', 'max:160', 'unique:attribute_group,slug'],
            'status' => ['required', Rule::in([0, 1, 2])], // 0=Delete,1=Published,2=Draft
        ];
    }

    protected function update(): array
    {
        $id = $this->route('id') ?? $this->id;
        return [
            'name'   => ['required', 'string', 'max:120', Rule::unique('attribute_group', 'name')->ignore($id)],
            'slug'   => ['nullable', 'string', 'max:160', Rule::unique('attribute_group', 'slug')->ignore($id)],
            'status' => ['required', Rule::in([0, 1, 2])],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'group name',
        ];
    }
}
