<?php

namespace Modules\SysAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AttributeGroupFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Auto-slug if empty
        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge(['slug' => Str::slug($this->input('name'))]);
        }

        // Ensure attributes and attribute_values are arrays
        $this->merge([
            'attributes'       => $this->input('attributes', []),
            'attribute_values' => $this->input('attribute_values', []),
        ]);
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
            'name'       => ['required', 'string', 'max:120', 'unique:attribute_group,name'],
            'slug'       => ['nullable', 'string', 'max:160', 'unique:attribute_group,slug'],
            'status'     => ['required', Rule::in([0, 1, 2])], // 0=Delete,1=Published,2=Draft

            // NEW: attribute mapping inputs
            'attributes'       => ['nullable', 'array'],
            'attributes.*'     => ['integer', Rule::exists('attribute', 'id')],
            'attribute_values' => ['nullable', 'array'],
            'attribute_values.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function update(): array
    {
        $id = $this->route('id') ?? $this->id;

        return [
            'name'       => ['required', 'string', 'max:120', Rule::unique('attribute_group', 'name')->ignore($id, 'id')],
            'slug'       => ['nullable', 'string', 'max:160', Rule::unique('attribute_group', 'slug')->ignore($id, 'id')],
            'status'     => ['required', Rule::in([0, 1, 2])],

            // NEW: attribute mapping inputs
            'attributes'       => ['nullable', 'array'],
            'attributes.*'     => ['integer', Rule::exists('attribute', 'id')],
            'attribute_values' => ['nullable', 'array'],
            'attribute_values.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'group name',
        ];
    }
}
