<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\SysAdmin\Models\Attribute;

class AttributeFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Determine validation rules based on route name.
     */
    public function rules()
    {
        return match (request()->route()->action['as'] ?? null) {
            'sysadmin.catalog.attribute.create',
            'sysadmin.catalog.attribute.store' => $this->store(),

            'sysadmin.catalog.attribute.edit',
            'sysadmin.catalog.attribute.update' => $this->update(),

            default => $this->store(),
        };
    }

    /**
     * Validation for create
     */
    public function store()
    {
        return [
            'name'        => ['required', 'string', 'max:100', 'unique:attribute,name'],
            'group_id'    => ['required', 'integer', 'exists:attribute_group,id'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'type'        => ['required', 'integer', 'exists:attribute_type,attribute_type_id'],
            'comparable'  => ['nullable', 'boolean'],
            'require'     => ['required', 'boolean'],
            'status'      => ['required', Rule::in(array_keys((new Attribute)->statuses))],
        ];
    }

    /**
     * Validation for update
     */
    public function update()
    {
        return [
            'name'        => [
                'required',
                'string',
                'max:100',
                Rule::unique('attribute', 'name')->ignore($this->id)
            ],
            'group_id'    => ['required', 'integer', 'exists:attribute_group,id'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'type'        => ['required', 'integer', 'exists:attribute_type,attribute_type_id'],
            'comparable'  => ['nullable', 'boolean'],
            'require'     => ['required', 'boolean'],
            'status'      => ['required', Rule::in(array_keys((new Attribute)->statuses))],
        ];
    }

    /**
     * Custom attribute names (for cleaner error messages)
     */
    public function attributes()
    {
        return [
            'name'       => 'attribute name',
            'group_id'   => 'attribute group',
            'type'       => 'attribute type',
            'require'    => 'require field',
            'status'     => 'status',
        ];
    }
}
