<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttributeTypeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return match (request()->route()->action['as'] ?? null) {
            'sysadmin.catalog.attribute.type.store'  => $this->store(),
            'sysadmin.catalog.attribute.type.update' => $this->update(),
            default => $this->store(),
        };
    }

    protected function store(): array
    {
        return [
            'type_name' => ['required', 'string', 'max:120', 'unique:attribute_type,type_name'],
            'identifier' => ['nullable', 'string', 'max:120', 'unique:attribute_type,identifier'],
            // Use numeric statuses like the rest of your module: 0=Delete,1=Published,2=Draft
            'status'    => ['required', Rule::in([0, 1, 2])],
        ];
    }

    protected function update(): array
    {
        // Primary key is attribute_type_id
        $id = $this->route('id') ?? $this->route('attribute_type') ?? $this->attribute_type_id ?? $this->id;

        return [
            'type_name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('attribute_type', 'type_name')->ignore($id, 'attribute_type_id'),
            ],
            'identifier' => [
                'nullable',
                'string',
                'max:120',
                Rule::unique('attribute_type', 'identifier')->ignore($id, 'attribute_type_id'),
            ],
            'status'    => ['required', Rule::in([0, 1, 2])],
        ];
    }

    public function attributes(): array
    {
        return [
            'type_name' => 'type name',
            'identifier' => 'identifier',
            'status'    => 'status',
        ];
    }
}
